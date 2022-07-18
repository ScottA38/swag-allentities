<?php
declare(strict_types=1);

namespace Swag\Premises\Test;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use PHPUnit\Framework\TestCase;
use Shopware\Core\Framework\Test\TestCaseBase\IntegrationTestBehaviour;
use Shopware\Core\System\SalesChannel\Context\SalesChannelContextFactory;
use Shopware\Storefront\Page\GenericPageLoaderInterface;
use Shopware\Storefront\Pagelet\Footer\FooterPageletLoadedEvent;
use Shopware\Storefront\Pagelet\Footer\FooterPageletLoader;
use Shopware\Storefront\Pagelet\Footer\FooterPageletLoaderInterface;
use Shopware\Storefront\Test\Page\StorefrontPageTestBehaviour;
use Swag\Premises\Listener\AttachShopDataListener;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Shopware\Core\Framework\Uuid\Uuid;
use Swag\Premises\Core\PremisesEntity;
use Swag\Premises\Core\PremisesLocationEntity;
use Shopware\Core\Framework\Event\GenericEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FooterRenderTest
 */
class FooterRenderTest extends TestCase
{
    use StorefrontPageTestBehaviour;
    use IntegrationTestBehaviour;

    private GenericEvent $event;

    private GenericPageLoaderInterface $pageLoader;

    private ContainerInterface $container;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        /** @var Connection $connection */
        $connection = $this->getContainer()->get(Connection::class);
        $locationData = [
            [
                'id' => Uuid::randomHex(),
                'number_or_name' => '500',
                'line_one' => 'West sands road',
                'line_two' => null,
                'town_or_city' => 'Portsmouth',
                'county_or_province' => 'Portsmouth',
                'postal_code' => 'PS15NP'
            ],
            [
                'id'=> Uuid::randomHex(),
                'number_or_name' => '200',
                'line_one' => 'Egal Straße',
                'line_two' => 'Obendorf',
                'town_or_city' => 'Obendorf',
                'county_or_province' => 'Stuttgart',
                'postal_code' => '90402'
            ]
        ];
        $shopData = [
            [
                'id' => Uuid::randomHex(),
                'name' => 'Filson Supply Ltd.',
                'size' => 100,
                'location' => $locationData[0]['id']
            ],
            [
                'id' => Uuid::randomHex(),
                'name' => 'Canned Heat Plc.',
                'size' => 500,
                'location' => 2
            ]
        ];

        foreach ($locationData as $locationDatum) {
            $connection->insert(PremisesEntity::ENTITY_NAME, $locationDatum);
        }

        $i = 0;
        foreach ($shopData as $shopDatum) {
            $shopDatum['location'] = $locationData[$i]['id'];
            $connection->insert(PremisesLocationEntity::ENTITY_NAME, $shopDatum);
            $i++;
        }
    }

    /**
     * @group ignore
     * @return void
     */
    public function testSubscriberIsAttachedToFooterRenderEvent()
    {
        /** @var EventDispatcher $dispatcher */
        $dispatcher = $this->getContainer()->get('event_dispatcher');
        $listeners = $dispatcher->getListeners(FooterPageletLoadedEvent::class);

        $this->assertContains(AttachShopDataToFooterListener::class, $listeners);
    }

    /**
     * @group ignore
     * @return void
     */
    public function testRenderedPageFooterHasShopFinderPagelet()
    {
        /** @var FooterPageletLoaderInterface $pageLoader */
        $pageLoader = $this->container->get(FooterPageletLoader::class);
        $request = new Request();
        $salesChannelContext =  new SalesChannelContextFactory();
    }

    /**
     * @group ignore
     * @return void
     */
    public function testPageFooterShopFinderBlockContainsAllShopLocations()
    {
        $shopFinderPagelet = new ShopFinderPageletLoader();

    }

    /**
     * @throws Exception
     */
    protected function getPageLoader()
    {
        throw new Exception("Not implemented");
    }
}
