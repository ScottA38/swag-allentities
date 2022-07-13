<?php declare(strict_types=1);

namespace Swag\Emojis\Migration;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ConnectionException;
use Exception;
use Shopware\Core\Framework\Migration\MigrationStep;
use Symfony\Component\Finder\Finder;

class Migration1656710360 extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1656710360;
    }

    /**
     * @param Connection $connection
     * @return void
     * @throws ConnectionException
     * @throws \Doctrine\DBAL\Exception
     * @throws \Throwable
     */
    public function update(Connection $connection): void
    {
        $sql = <<<EOF
    CREATE TABLE `swag_emoji` (
        `id` BINARY(16) NOT NULL,
        `name` VARCHAR(255) NOT NULL,
        `unicode_address` VARCHAR(255) NOT NULL,
        `description` LONGTEXT NULL,
        `created_at` DATETIME(3) NOT NULL,
        `updated_at` DATETIME(3) NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
EOF;
        $connection->transactional(function () use ($sql, $connection) {
            $connection->executeStatement($sql);
        });
    }

    /**
     * @throws Exception
     */
    public function updateDestructive(Connection $connection): void
    {
        throw new Exception("No such functionality");
    }
}
