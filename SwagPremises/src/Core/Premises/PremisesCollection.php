<?php
declare(strict_types=1);


namespace Swag\Premises\Core\Premises;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * Class PremisesCollection
 * @method void add(PremisesEntity $entity)
 * @method void set(string $key, PremisesEntity $entity)
 * @method PremisesEntity[] getIterator()
 * @method PremisesEntity[] getElements()
 * @method PremisesEntity|null get(string $key)
 * @method PremisesEntity|null first()
 * @method PremisesEntity|null last()
 */
class PremisesCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return PremisesEntity::class;
    }
}
