<?php
declare(strict_types=1);

namespace Swag\Premises\Core\Premises\SalesChannel;

use OpenApi\Annotations as OA;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\Demodata\DemodataRequest;
use Shopware\Core\Framework\Demodata\DemodataService;
use Shopware\Core\Framework\Plugin\Exception\DecorationPatternException;
use Shopware\Core\Framework\Routing\Annotation\Entity;
use Shopware\Core\Framework\Routing\Exception\InvalidRequestParameterException;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SalesChannel\SuccessResponse;
use Swag\Premises\Core\Premises\PremisesDefinition;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PremisesApiRoute
 * @Route(defaults={"_routeScope"={"store-api"}})
 */
class PremisesApiRoute extends AbstractPremisesRoute
{
    /** @var DemodataService $ddService */
    protected DemodataService $ddService;

    /**
     * @var EntityRepository
     */
    protected $premisesRepository;

    /**
     * @param DemodataService $ddService
     * @param $premisesRepository
     */
    public function __construct(
        DemodataService $ddService,
        $premisesRepository
    ) {
        $this->ddService = $ddService;
        $this->premisesRepository = $premisesRepository;
    }


    /**
     * @return AbstractPremisesRoute
     *
     * @throws DecorationPatternException
     */
    public function getDecorated(): AbstractPremisesRoute
    {
        throw new DecorationPatternException(static::class);
    }

    /**
     * @Entity("swag_premises")
     * @OA\Post(
     *     path="/premises/generate",
     *     summary="Demo data creation for premises entity",
     *     operationId="generate-premises",
     *     tags={"Store API", "Premises"},
     *     @OA\RequestBody(
     *          required="true",
     *          @OA\JsonContent(
     *              required={
     *                  "quantity",
     *              },
     *              @OA\Property(
     *                  property="quantity",
     *                  description="Amount of new entities to generate",
     *                  type="integer"
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="See below the generated entities",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="elements",
     *                  type="array",
     *                  @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
     *              )
     *          )
     *     )
     * )
     * @Route("/store-api/premises/generate", name="store-api.premises.generate",  methods={"POST"})
     *
     * @param Request $request
     * @param SalesChannelContext $context
     * @return SuccessResponse
     */
    public function generate(Request $request, SalesChannelContext $context): SuccessResponse
    {
        $requestedQuantity = intval($request->get('quantity'));
        if ($requestedQuantity === 0) {
            throw new InvalidRequestParameterException(sprintf("Parameter 'quantity' not positive non-zero integer in %s", __METHOD__));
        }

        $req = new DemodataRequest();
        $req->add(PremisesDefinition::class, $requestedQuantity);

        // This method is designed for CLI command, so does not normally accept Extended contexts (SalesChannelContext)
        $this->ddService->generate($req, $context->getContext(), null);

        return new SuccessResponse();
    }

    /**
     * @Entity("swag_premises")
     * @OA\Get(
     *     path="/premises",
     *     summary="Fetch all existent Premises entities in the current database",
     *     operationId="get-premises-entities",
     *     tags={"Store API", "Premises"},
     *      @OA\Parameter(name="Api-Basic-Parameters"),
     *      @OA\Response(
     *         response="200",
     *         description="See below the generated entities",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="elements",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/SwagPremises")
     *              )
     *          )
     *     )
     * )
     * @Route("/store-api/premises", name="store-api.premises",  methods={"GET"})
     *
     * @param Request $request
     * @param SalesChannelContext $context
     * @param Criteria $criteria
     * @return PremisesRouteResponse
     */
    public function getAll(Request $request, SalesChannelContext $context, Criteria $criteria): PremisesRouteResponse
    {
        $premisesEntities = $this->premisesRepository->search($criteria, $context->getContext());

        return new PremisesRouteResponse($premisesEntities->getEntities());
    }
}
