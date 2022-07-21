<?php
declare(strict_types=1);

namespace Swag\Premises\Test\Core\Premises\SalesChannel;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Swag\Premises\Core\Premises\SalesChannel\PremisesRouteResponse;
use PHPUnit\Framework\TestCase;

class PremisesRouteResponseTest extends TestCase
{
    /**
     * @var EntityRepository
     */
    protected $premisesCollection;

    public function setUp(): void
    {
        $this->premisesCollection = $this->createStub(EntityCollection::class);
    }

    public function testGetPremisesEntities()
    {
        $response = new PremisesRouteResponse($this->premisesCollection);

        $this->assertInstanceOf(EntityCollection::class, $response->getPremisesEntities());
    }
}
