<?php
declare(strict_types=1);

namespace Swag\CustomerPrice\Listener;

use Exception;
use Faker\Factory;
use Psr\Log\LoggerInterface;
use Shopware\Core\Content\Product\ProductEvents;
use Shopware\Core\Defaults;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Event\EntityWrittenEvent;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Swag\CustomerPrice\Extension\Content\Product\CustomerPriceExtension;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Shopware\Core\Framework\Demodata\Faker\Commerce;

/**
 * Class DemoDataServiceExtensionAttacher
 */
 class DemoDataServiceExtensionAttacher implements EventSubscriberInterface
 {
     private const NUMBER_OF_CUSTOM_PRICES = 200;

     /**
      * @var EntityRepository
      */
     protected $productEntityRepository;

     /**
      * @var LoggerInterface
      */
     protected LoggerInterface $logger;

     /**
      * @var EntityRepository
      */
     protected $customerEntityRepository;

     /**
      * @var EntityRepository
      */
     protected $customerPriceEntityRepository;

     /**
      * @var Factory
      */
     protected $faker;

     /**
      * @var array
      */
     protected array $handledIds = [];

     /**
      * @param EntityRepository $productEntityRepository
      * @param EntityRepository $customerEntityRepository
      * @param LoggerInterface $logger
      * @param EntityRepository $customerPriceExtensionRepository
      */
     public function __construct(
         EntityRepository $productEntityRepository,
         EntityRepository $customerEntityRepository,
         LoggerInterface $logger,
         EntityRepository $customerPriceExtensionRepository
     ) {
         $this->productEntityRepository = $productEntityRepository;
         $this->customerEntityRepository = $customerEntityRepository;
         $this->logger = $logger;
         $faker = Factory::create('en_GB');
         $faker->addProvider(new Commerce($faker));
         $this->faker = $faker;
         $this->customerPriceEntityRepository = $customerPriceExtensionRepository;
     }


     /**
      * @inheritDoc
      */
     public static function getSubscribedEvents(): array
     {
         return [ ProductEvents::PRODUCT_WRITTEN_EVENT => 'attachExtension' ];
     }

     /**
      * @throws Exception
      */
     public function attachExtension(EntityWrittenEvent $event)
     {
         $stack = debug_backtrace();
         $customers = $this->customerEntityRepository->searchIds(new Criteria(), Context::createDefaultContext());
         foreach ($stack as $executor) {
             if (strpos($executor["file"], "ProductGenerator") !== false && strpos($executor["file"], "Demodata") !== false) {

                 foreach ($event->getIds() as $id) {
                     if (!in_array($id, $this->handledIds)) {
                         $this->customerPriceEntityRepository->create(
                             $this->createCustomerPrices($id, $customers->getIds()),
                             $event->getContext()
                         );
//                         $this->productEntityRepository->upsert([[
//                             'id' => "$id",
//                             'customerPriceExtension' => $this->createCustomerPrices()
//                         ]], $event->getContext());

                         $this->handledIds[] = $id;
                     }
                 }
             }
         }
     }

     /**
      * @param string $productId
      * @param array $customers
      * @return array
      * @throws Exception
      */
     private function createCustomerPrices(string $productId, array $customers): array
     {
         $customers = \array_slice(
             $customers,
             random_int(0, \count($customers) - 3),
             random_int(1, 3)
         );

         $range = range(0, 200);
         $values = array_map(function ($item, $key) {
             $value = $this->faker->randomFloat(2, $key * 10, $key * 100);

             return [
                 $value,
                 round($value / 100 * (random_int(50, 90)), 2),
             ];
         }, $range, array_keys($range));

         return array_reduce($customers, function ($prices, $customerId) use ($values, $productId) {
             $price = $this->faker->randomElement($values);

             $prices[] = [
                 'productId' => $productId,
                 'customerId' => $customerId,
                 'quantityStart' => 1,
                 'quantityEnd' => 10,
                 'price' => [['currencyId' => Defaults::CURRENCY, 'gross' => $price[0], 'net' => $price[0] / 119, 'linked' => false]],
             ];

             $prices[] = [
                 'productId' => $productId,
                 'customerId' => $customerId,
                 'quantityStart' => 11,
                 'price' => [['currencyId' => Defaults::CURRENCY, 'gross' => $price[1], 'net' => $price[1] / 119, 'linked' => false]],
             ];

             return $prices;
         }, []);
     }
 }
