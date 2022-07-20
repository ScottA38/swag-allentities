<?php
declare(strict_types=1);

namespace Swag\Premises\Core\Premises\Generator;

use Faker\Generator;
use Faker\Provider\Address;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\Demodata\DemodataContext;
use Shopware\Core\Framework\Demodata\DemodataGeneratorInterface;
use Shopware\Core\Framework\Uuid\Uuid;
use Swag\Premises\Core\Premises\PremisesDefinition;

/**
 * Class PremisesGenerator
 */
class PremisesGenerator implements DemodataGeneratorInterface
{
    /** @var EntityRepository */
    protected $premisesRepository;

    /** @var Generator $faker */
    protected $faker;

    /**
     * @param $premisesRepository
     */
    public function __construct($premisesRepository)
    {
        $this->premisesRepository = $premisesRepository;
    }

    /**
     * @return string
     */
    public function getDefinition(): string
    {
        return PremisesDefinition::class;
    }

    /**
     * @param int $numberOfItems
     * @param DemodataContext $context
     * @param array $options
     * @return void
     */
    public function generate(int $numberOfItems, DemodataContext $context, array $options = []): void
    {
        $this->faker = $context->getFaker();
        $this->faker->addProvider(new Address($this->faker));
        $premisesEntities = array_map([$this, 'generatePremises'], range(0, ($numberOfItems - 1)));

        $this->premisesRepository->create($premisesEntities, $context->getContext());
    }

    /**
     * @return array
     */
    private function generatePremises(): array
    {
        return [
            'id' => Uuid::randomHex(),
            'name' => $this->faker->format('company'),
            'address' => $this->faker->format('address')
        ];
    }
}
