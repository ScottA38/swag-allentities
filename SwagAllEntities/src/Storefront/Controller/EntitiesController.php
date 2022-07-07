<?php
/**
 * Swag AllEntities module
 *
 * @category  API
 * @package   \EntitiesController
 * @author    Scott Anderson <tri.s.anderson@shopware.com>
 * @copyright 2022 ForBetterFuture
 */

namespace Swag\AllEntities\Storefront\Controller;

use OpenApi\Annotations as OA;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use RuntimeException;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\DefinitionInstanceRegistry;
use Shopware\Storefront\Controller\StorefrontController;
use Swag\AllEntities\Event\ApiHitEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Shopware\Core\Framework\DataAbstractionLayer\Exception\MappingEntityClassesException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;


/**
 * Class EntitiesController
 * @RouteScope(scopes={"storefront"})
 */
class EntitiesController extends StorefrontController
{
    protected EventDispatcherInterface $eventDispatcher;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     *
     * @param Context $context
     * @param Request $request
     * @return Response
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @Route("/entities", name="frontend.entities", methods={"GET"})
     */
    public function showEntities(Context $context, Request $request): Response
    {
        $apiHitEvent =  new ApiHitEvent($context, $request->getRequestUri());
        $this->eventDispatcher->dispatch($apiHitEvent);
        $out = [];
        /** @var DefinitionInstanceRegistry $definitionInstanceRegistry */
        $definitionInstanceRegistry = $this->container->get('Shopware\Core\Framework\DataAbstractionLayer\DefinitionInstanceRegistry');

        foreach (array_keys($definitionInstanceRegistry->getDefinitions()) as $name) {
            $repository = $definitionInstanceRegistry->getRepository($name);
            try {
                foreach ($repository->search((new Criteria()), $context) as $item) {
                    $out[$name][] = $item;
                }
            } catch (MappingEntityClassesException | RuntimeException $e) {
                continue;
            }
        }

        return $this->json($out);
    }

    /**
     *
     * @param Context $context
     * @param Request $request
     * @return Response
     * @Route("/context", name="frontend.context", methods={"GET"})
     */
    public function showContext(Context $context, Request $request): Response
    {
        $apiHitEvent =  new ApiHitEvent($context, $request->getPathInfo());
        $this->eventDispatcher->dispatch($apiHitEvent, $apiHitEvent->getName());

        return $this->json([
            "class" => get_class($context),
            "data" => $context->jsonSerialize()
        ]);
    }
}
