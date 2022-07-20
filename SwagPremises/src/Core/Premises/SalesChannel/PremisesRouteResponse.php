<?php
declare(strict_types=1);

namespace Swag\Premises\Core\Premises\SalesChannel;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;
use Shopware\Core\System\SalesChannel\StoreApiResponse;

/**
 * Class PremisesRouteResponse
 */
class PremisesRouteResponse extends StoreApiResponse
{
    /** @var EntityCollection $object */
    protected $object;

    /**
     * @param EntityCollection $premisesCollection
     */
    public function __construct(
        EntityCollection $premisesCollection
    ) {
        parent::__construct($premisesCollection);
    }

    public function getPremisesEntities(): EntityCollection
    {
        return $this->object;
    }
}
