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
use RuntimeException;
use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\DefinitionInstanceRegistry;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Response;
use Shopware\Core\Framework\Routing\Annotation\Entity as EntityAnnotation;
use Shopware\Core\Framework\DataAbstractionLayer\Exception\MappingEntityClassesException;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class EntitiesController
 * @RouteScope(scopes={"storefront"})
 */
class EntitiesController extends StorefrontController
{
    /**
     *
     * @param Context $context
     * @param Criteria $criteria
     *
     * @return Response
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @Entity("customer")
     * @Route("/entities", name="frontend.entities", methods={"GET"})
     */
    public function showEntities(Context $context, Criteria $criteria): Response
    {
        $out = [];
        /** @var DefinitionInstanceRegistry $definitionInstanceRegistry */
        $definitionInstanceRegistry = $this->container->get('Shopware\Core\Framework\DataAbstractionLayer\DefinitionInstanceRegistry');

        foreach (array_keys($definitionInstanceRegistry->getDefinitions()) as $name) {
            $repository = $definitionInstanceRegistry->getRepository($name);
            try {
                /** @var Entity $item */
                foreach ($repository->search($criteria, $context) as $item) {
                    $out[$name][] = $item;
                }
            } catch (MappingEntityClassesException| RuntimeException $e) {
                continue;
            }
        }

        return $this->json($out);
    }
}
