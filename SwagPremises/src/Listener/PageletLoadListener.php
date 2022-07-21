<?php
declare(strict_types=1);

namespace Swag\Premises\Listener;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\Struct\ArrayStruct;
use Shopware\Storefront\Pagelet\Footer\FooterPageletLoadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class PageletLoadListener
 */
 class PageletLoadListener implements EventSubscriberInterface
 {
     /** @var EntityRepository */
     protected $premisesRepository;

     /**
      * @param $premisesRepository
      */
     public function __construct(
         $premisesRepository
     ) {
         $this->premisesRepository = $premisesRepository;
     }

     public static function getSubscribedEvents(): array
     {
         return [
             FooterPageletLoadedEvent::class => 'appendPremisesLocationBlock'
         ];
     }


     public function appendPremisesLocationBlock(FooterPageletLoadedEvent $pageletLoadedEvent)
     {
         $pagelet = $pageletLoadedEvent->getPagelet();
         $criteria = new Criteria();
         $criteria->setIncludes(['address']);
         $allResults = $this->premisesRepository->search($criteria, $pageletLoadedEvent->getContext());

         $pagelet->addExtensions([ 'premises' => $allResults ]);
     }
 }
