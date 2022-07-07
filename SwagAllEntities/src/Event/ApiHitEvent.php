<?php
declare(strict_types=1);

namespace Swag\AllEntities\Event;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Event\GenericEvent;

/**
 * Class ApiHitEvent
 */
final class ApiHitEvent implements GenericEvent
{
    const API_ALLENTITIES_HIT_EVENT = 'api.allentities.hit';

    protected Context $context;

    protected string $endpoint;

    /**
     * @param Context $context
     * @param string $endpoint
     */
    public function __construct(Context $context, string $endpoint)
    {
        $this->context = $context;
        $this->endpoint = $endpoint;
    }

    public function getContext(): Context
    {
        return $this->context;
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function getName(): string
    {
        return self::API_ALLENTITIES_HIT_EVENT;
    }
}
