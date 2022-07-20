<?php
declare(strict_types=1);

namespace Swag\Premises\Core\Premises\Generator;

use Faker\Generator;
use Faker\Generator as FakerGenerator;
use Faker\Provider\Address;
use Faker\Provider\Company;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\Demodata\DemodataContext;
use Shopware\Core\Framework\Demodata\DemodataGeneratorInterface;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\System\CustomEntity\Xml\Entity;
use Swag\Premises\Core\Premises\PremisesDefinition;

/**
 * Class PremisesGenerator
 */
class PremisesGenerator implements DemodataGeneratorInterface
{
    /** @var EntityRepository */
    protected $premisesRepository;

    /** @var EntityRepository */
    protected $premisesLocationRepository;

    /** @var Generator $faker */
    protected $faker;

    /**
     * @param $premisesRepository
     * @param $premisesLocationRepository
     */
    public function __construct($premisesRepository, $premisesLocationRepository)
    {
        $this->premisesRepository = $premisesRepository;
        $this->premisesLocationRepository = $premisesLocationRepository;
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
            'locationEntity' => $this->generatePremisesLocation()
        ];
    }

    /**
     * @return array
     */
    private function generatePremisesLocation(): array
    {
        $city = $this->faker->format('city');

        return [
            'id' => Uuid::randomHex(),
            'number' => $this->faker->format('buildingNumber'),
            'line_one' => $this->faker->format('streetName'),
            'line_two' => null,
            'town_or_city' => $city,
            'county_or_province' => $city,
            'postal_code' => $this->faker->format('postcode'),
        ];
    }
}
