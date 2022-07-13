<?php /** @noinspection ALL */
declare(strict_types=1);

namespace Swag\Emojis\Migration;

use Closure;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ConnectionException;
use Exception;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;
use Shopware\Core\Framework\Migration\MigrationStep;
use Swag\Emojis\Core\Content\Emoji\EmojiDefinition;
use Shopware\Core\Framework\Uuid\Uuid;

class Migration1657661525PopulateEmojis extends MigrationStep
{
    protected $insertData = [];

    public function getCreationTimestamp(): int
    {
        return 1657661525;
    }

    /**
     * @throws ConnectionException
     */
    public function update(Connection $connection): void
    {
        $client = new Client();
        $crawler = $client->request('GET', 'https://www.fileformat.info/info/unicode/font/noto_emoji/list.htm');

        $connection->beginTransaction();
        try {
            /** @var DomCrawler $elem */
            $crawler
                ->filter('.table.table-list tbody tr')
                ->each(Closure::fromCallable([$this, 'buildInsertQuery']));

            foreach ($this->insertData as $insert) {
                $connection->insert(EmojiDefinition::ENTITY_NAME, $insert);
            }
        } catch (Exception $e) {
            $connection->rollBack();

            throw $e;
        }

        $connection->commit();
    }

    /**
     * @param array $acc
     * @param DomCrawler $elem
     *
     * @return array
     * @throws Exception
     */
    public function buildInsertQuery(DomCrawler $elem): void
    {
        $elem->filter('td');
        $this->insertData[] = [
            'id' => Uuid::randomHex(),
            'name' => $elem->children()->getNode(1)->textContent,
            'unicode_address' => $elem->children()->getNode(0)->textContent,
            'description' => sprintf("%s symbol", $elem->children()->getNode(1)->textContent)
        ];
    }

    /**
     * @throws Exception
     */
    public function updateDestructive(Connection $connection): void
    {
        throw new Exception(__CLASS__ . "::" . __METHOD__ . "() not implemented");
    }
}
