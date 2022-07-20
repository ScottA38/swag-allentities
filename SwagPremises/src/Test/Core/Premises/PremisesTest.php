<?php
declare(strict_types=1);

namespace Swag\Premises\Test\Core\Premises;

use Exception;
use PHPUnit\Framework\TestCase;
use Shopware\Core\Framework\DataAbstractionLayer\DefinitionInstanceRegistry;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\Test\TestCaseBase\KernelTestBehaviour;
use Shopware\Core\Framework\Uuid\Uuid;
use Swag\Premises\Core\Premises\PremisesCollection;
use Swag\Premises\Core\Premises\PremisesDefinition;
use Swag\Premises\Core\Premises\PremisesEntity;

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
                'address' => '101 Some Street, Some Town, 80085'
            ],
            [
                'id' => Uuid::randomHex(),
                'name' => 'Canned Heat Plc.',
                'address' => '005 Bar Street, BazzTown, 101'
            ]
        ];
    }

    public function testCanInstantiateNewShop()
    {
        $premises = new PremisesEntity();

        $this->assertInstanceOf(PremisesEntity::class, $premises);
    }

    public function testShopCanHoldAddressInformation()
    {
        $premises = new PremisesEntity();

        $premises->setAddress($this->shopData[0]['address']);

        $this->assertIsString($premises->getAddress());
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

        $premises->setName($this->shopData[1]['name']);
        $premises->setAddress($this->shopData[1]['address']);

        $this->assertEquals('Canned Heat Plc.', $premises->getName());
        $this->assertEquals('005 Bar Street, BazzTown, 101', $premises->getAddress());
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
        $address = $fields->get('address');

        $this->assertInstanceOf(IdField::class, $id);
        $this->assertInstanceOf(StringField::class, $name);
        $this->assertInstanceOf(StringField::class, $address);
    }
}
