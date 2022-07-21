<?php
declare(strict_types=1);

namespace Swag\Premises\Test\Listener;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use Shopware\Core\Framework\Struct\Struct;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Pagelet\Footer\FooterPagelet;
use Shopware\Storefront\Pagelet\Footer\FooterPageletLoadedEvent;
use Swag\Premises\Listener\PageletLoadListener;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class PageletLoadListenerTest extends TestCase
{
    /**
     * @var EntityRepository
     */
    private $premisesRepositoryMock;

    public function setUp(): void
    {
        // Should I actually build the mock criteria here, or is it enough simply to accept an object of type criteria as param?
        $entitySearchResultStub = $this->createStub(EntitySearchResult::class);
        $entitySearchResultStub
            ->method('getElements')
            ->willReturn(array_fill(0, 5, []));
        $this->premisesRepositoryMock = $this->createMock(EntityRepository::class);
        $this->premisesRepositoryMock
            ->expects($this->any())
            ->method('search')
            ->with($this->isInstanceOf(Criteria::class), $this->isInstanceOf(Context::class))
            ->willReturn($entitySearchResultStub);
    }

    public function testGetSubscribedEvents()
    {
        $listener = new PageletLoadListener($this->premisesRepositoryMock);

        $this->assertArrayHasKey(FooterPageletLoadedEvent::class, $listener->getSubscribedEvents());
    }

    //test constructor independently?

    public function testAppendPremisesLocationBlock()
    {
        $listener = new PageletLoadListener($this->premisesRepositoryMock);

        $footerPageletMock = $this->createMock(FooterPagelet::class);
        $footerPageletMock
            ->expects($this->once())
            ->method('addExtensions')
            ->with($this->callback([$this, 'checkReturnedExtensionsFormat']));
        $pageletEvent = new FooterPageletLoadedEvent(
            $footerPageletMock,
            $this->createStub(SalesChannelContext::class),
            $this->createStub(Request::class)
        );

        $listener->appendPremisesLocationBlock($pageletEvent);
    }

    /**
     * @param $extensions
     * @return bool
     */
    public function checkReturnedExtensionsFormat($extensions): bool
    {
        return is_array($extensions) && isset($extensions['premises']) && is_a($extensions['premises'], Struct::class);
    }
}
