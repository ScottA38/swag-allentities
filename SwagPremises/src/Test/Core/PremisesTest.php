<?php
declare(strict_types=1);

namespace Swag\Premises\Test\Core;

use Exception;
use PHPUnit\Framework\TestCase;
use Shopware\Core\Framework\DataAbstractionLayer\DefinitionInstanceRegistry;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\Test\TestCaseBase\KernelTestBehaviour;
use Shopware\Core\Framework\Uuid\Uuid;
use Swag\Premises\Core\Premises\PremisesCollection;
use Swag\Premises\Core\Premises\PremisesDefinition;
use Swag\Premises\Core\Premises\PremisesEntity;
use Swag\Premises\Core\Premises\PremisesLocationEntity;

/**
 * Class PremisesTest
 */
class PremisesTest extends TestCase
{
    use KernelTestBehaviour;

    protected array $shopData;

    protected function setUp(): void
    {
        $this->shopData = [
            [
                'id' => Uuid::randomHex(),
                'name' => 'Filson Supply Ltd.',
                'size' => 100,
                'location' => Uuid::randomHex()
            ],
            [
                'id' => Uuid::randomHex(),
                'name' => 'Canned Heat Plc.',
                'size' => 500,
                'location' => Uuid::randomHex()
            ]
        ];
    }

    public function testCanInstantiateNewShop()
    {
        $premises = new PremisesEntity();

        $this->assertInstanceOf(PremisesEntity::class, $premises);
    }

    public function testShopCanHoldLocationInformation()
    {
        $premises = new PremisesEntity();
        $location = new PremisesLocationEntity();

        $premises->setLocationEntity($location);

        $this->assertInstanceOf(PremisesLocationEntity::class, $premises->getLocationEntity());
    }

    public function testPremisesDefinitionExposesDatabaseName()
    {
        $this->assertEquals('swag_premises', PremisesDefinition::ENTITY_NAME);
    }

    public function testPremisesDefinitionExposesCollectionClass()
    {
        $premisesDefinition = new PremisesDefinition();

        $this->assertEquals(PremisesCollection::class, $premisesDefinition->getCollectionClass());
    }

    public function testShopCanHoldIdentificationInformation()
    {
        $premises = new PremisesEntity();

        $premises->setName('Filson Supply Ltd.');
        $premises->setLocationEntity((new PremisesLocationEntity()));

        $this->assertEquals('Filson Supply Ltd.', $premises->getName());
        $this->assertInstanceOf(PremisesLocationEntity::class, $premises->getLocationEntity());
    }

    public function testGetPremisesDefinitionEntityName()
    {
        $premises = new PremisesDefinition();

        $this->assertEquals('swag_premises', $premises->getEntityName());
    }

    /**
     * Ensure that entity definition returns successfully
     * @throws Exception
     */
    public function testPremisesEntityFieldsAreDefined()
    {
        $premises = new PremisesDefinition();
        /** @var DefinitionInstanceRegistry $definitionInstanceRegistry */
        $definitionInstanceRegistry = $this->getContainer()->get(DefinitionInstanceRegistry::class);
        $definitionInstanceRegistry->register($premises);
        $fields = $premises->getFields();

        $id = $fields->get('id');
        $name = $fields->get('name');
        $location = $fields->get('location');

        $this->assertInstanceOf(IdField::class, $id);
        $this->assertInstanceOf(StringField::class, $name);
        $this->assertInstanceOf(OneToOneAssociationField::class, $location);
    }
}
