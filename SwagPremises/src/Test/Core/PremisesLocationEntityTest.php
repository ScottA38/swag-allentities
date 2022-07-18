<?php
declare(strict_types=1);

namespace Swag\Premises\Test\Core;

use Exception;
use PHPUnit\Framework\TestCase;
use Shopware\Core\Framework\DataAbstractionLayer\DefinitionInstanceRegistry;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Swag\Premises\Core\PremisesLocationDefinition;
use Swag\Premises\Core\PremisesLocationEntity;

/**
 * Class PremisesLocationEntityTest
 */
class PremisesLocationEntityTest extends TestCase
{
    public function testLocationEntityHoldsAddressInformation()
    {
        $location = new PremisesLocationEntity();

        $location->setNumber('500');
        $location->setLineOne('West sands road');
        $location->setLineTwo( null);
        $location->setTownOrCity('Portsmouth');
        $location->setCountyOrProvince('Portsmouth');
        $location->setPostalCode('PS15NP');


        $this->assertEquals('500', $location->getNumber());
        $this->assertEquals('West sands road', $location->getLineOne());
        $this->assertEquals(null, $location->getLineTwo());
        $this->assertEquals('Portsmouth', $location->getTownOrCity());
        $this->assertEquals('Portsmouth', $location->getCountyOrProvince());
        $this->assertEquals('PS15NP', $location->getPostalCode());
    }

    public function testLocationEntityNullableFieldsCanHoldNull()
    {
        $location = new PremisesLocationEntity();

        $location->setLineTwo('Some Place');
        $this->assertEquals('Some Place', $location->getLineTwo());

        $location->setLineTwo(null);
        $this->assertNull($location->getLineTwo());

        $location->setTownOrCity('Portsmouth');
        $this->assertEquals('Portsmouth', $location->getTownOrCity());

        $location->setTownOrCity(null);
        $this->assertNull($location->getTownOrCity());
    }

    /**
     * @throws Exception
     */
    public function testPremisesEntityFieldsAreDefined()
    {
        $premisesLocation = new PremisesLocationDefinition();
        /** @var DefinitionInstanceRegistry $definitionInstanceRegistry */
        $definitionInstanceRegistry = $this->getContainer()->get(DefinitionInstanceRegistry::class);
        $definitionInstanceRegistry->register($premisesLocation);
        $fields = $premisesLocation->getFields();

        $id = $fields->get('id');
        $number = $fields->get('number');
        $lineOne = $fields->get('line_one');
        $lineTwo = $fields->get('line_two');
        $townOrCity = $fields->get('town_or_city');
        $countyOrProvince = $fields->get('county_or_province');
        $country = $fields->get('country');
        $postalCode = $fields->get('postal_code');

        $this->assertInstanceOf(IdField::class, $id);
        $this->assertInstanceOf(StringField::class, $number);
        $this->assertInstanceOf(StringField::class, $lineOne);
        $this->assertInstanceOf(StringField::class, $lineTwo);
        $this->assertInstanceOf(StringField::class, $townOrCity);
        $this->assertInstanceOf(StringField::class, $countyOrProvince);
        $this->assertInstanceOf(StringField::class, $country);
        $this->assertInstanceOf(StringField::class, $postalCode);
    }
}
