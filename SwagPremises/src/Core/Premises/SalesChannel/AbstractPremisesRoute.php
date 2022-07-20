<?php
declare(strict_types=1);

namespace Swag\Premises\Core\Premises\SalesChannel;

use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SalesChannel\SuccessResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AbstractPremisesRoute
 */
abstract class AbstractPremisesRoute
{
    abstract public function getDecorated(): AbstractPremisesRoute;

    abstract public function generate(Request $request, SalesChannelContext $context): SuccessResponse;

    abstract public function getAll(Request $request, SalesChannelContext $context, Criteria $criteria): PremisesRouteResponse;
}
