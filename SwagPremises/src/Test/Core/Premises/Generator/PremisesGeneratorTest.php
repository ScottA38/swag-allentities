<?php
declare(strict_types=1);

namespace Swag\Premises\Test\Core\Premises\Generator;

use Faker\Generator;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\Demodata\DemodataContext;
use PHPUnit\Framework\TestCase;
use Swag\Premises\Core\Premises\Generator\PremisesGenerator;
use Swag\Premises\Core\Premises\PremisesDefinition;

class PremisesGeneratorTest extends TestCase
{

    public function setUp(): void
    {

    }

    public static function validateCreatePayload($data): bool
    {
        if (!is_array($data))
            return false;
        foreach ($data as $item) {
            if (!is_array($item) || !isset($item['id']) || !isset($item['name']) || !isset($item['address']))
                return false;
        }

        return true;
    }

    public function testGeneratorSuccessfullyGeneratesPremisesEntities()
    {
        $demoDataContextStub = $this->createStub(DemodataContext::class);
        $faker = $this->createMock( Generator::class);
        $faker->method('format')
            ->willReturnMap(
                [
                    ['company', [], 'Becker and Sons'],
                    ['address', [], '96 Adams Street 16573 AlvenaVille']
                ]
            );

        $demoDataContextStub->method('getFaker')->willReturn($faker);
        $premisesRepositoryMock = $this->createMock(EntityRepository::class);
        // Configure premises repository mock to be
        $premisesRepositoryMock
            ->expects($this->atLeastOnce())
            ->method('create')
            ->with(
                $this->callback([static::class, 'validateCreatePayload']),
                $this->isInstanceOf(Context::class)
            );
        $generator = new PremisesGenerator($premisesRepositoryMock);

        $generator->generate(2, $demoDataContextStub);
    }

    public function testGeneratorDefinedEntityDefinitionIsCorrect()
    {
        $generator = new PremisesGenerator($this->createStub(PremisesGenerator::class));

        $this->assertEquals(PremisesDefinition::class, $generator->getDefinition());
    }
}
