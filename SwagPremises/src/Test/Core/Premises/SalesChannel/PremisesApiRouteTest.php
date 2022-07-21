<?php
declare(strict_types=1);

namespace Swag\Premises\Test\Core\Premises\SalesChannel;

use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\System\SalesChannel\SuccessResponse;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\Demodata\DemodataService;
use Shopware\Core\Framework\Plugin\Exception\DecorationPatternException;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Swag\Premises\Core\Premises\SalesChannel\PremisesApiRoute;
use PHPUnit\Framework\TestCase;
use Swag\Premises\Core\Premises\SalesChannel\PremisesRouteResponse;
use Symfony\Component\HttpFoundation\Request;

class PremisesApiRouteTest extends TestCase
{
    protected PremisesApiRoute $route;
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Context
     */
    protected $context;

    public function setUp(): void
    {
        $demodataServiceStub = $this->createStub(DemodataService::class);
        $repositoryStub = $this->createStub(EntityRepository::class);
        $this->route = new PremisesApiRoute($demodataServiceStub, $repositoryStub);
        $this->request = $this->createMock(Request::class);
        $this->request->method('get')
            ->with($this->equalTo('quantity'))
            ->willReturn(3);
        $this->context = $this->createStub(SalesChannelContext::class);
    }

    public function testGetDecorated()
    {
        $this->expectException(DecorationPatternException::class);
        $this->route->getDecorated();
    }

    public function testGenerate()
    {
        $result = $this->route->generate($this->request, $this->context);

        $this->assertInstanceOf(SuccessResponse::class, $result);
    }

    public function testGetAll()
    {
        $result = $this->route->getAll($this->request, $this->context, new Criteria());

        $this->assertInstanceOf(PremisesRouteResponse::class, $result);
    }
}
