<?php
declare(strict_types=1);

namespace Swag\AllEntities\Listener;

use Swag\AllEntities\Event\ApiHitEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Psr\Log\LoggerInterface;

/**
 * Class ApiHitListener
 */
class ApiHitListener implements EventSubscriberInterface
{
    protected LoggerInterface $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ApiHitEvent::API_ALLENTITIES_HIT_EVENT => 'recordHit'
        ];
    }

    public function recordHit(ApiHitEvent $apiHitEvent)
    {
        $this->logger->notice($apiHitEvent->getEndpoint());
    }
}
