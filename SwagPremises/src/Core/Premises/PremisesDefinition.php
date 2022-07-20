<?php
declare(strict_types=1);

namespace Swag\Premises\Core\Premises;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

/**
 * Class PremisesDefinition
 */
class PremisesDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'swag_premises';

    /**
     * @return string
     */
    public function getEntityName(): string
    {
        return static::ENTITY_NAME;
    }

    /**
     * @return string
     */
    public function getCollectionClass(): string
    {
        return PremisesCollection::class;
    }

    public function getEntityClass(): string
    {
        return PremisesEntity::class;
    }

    /**
     * @return FieldCollection
     */
    protected function defineFields(): FieldCollection
    {
        return (new FieldCollection([
                (new Field\IdField('id', 'id'))->addFlags(new Flag\PrimaryKey(), new Flag\Required()),
                (new Field\StringField('name', 'name'))->addFlags(new Flag\Required(), new Flag\ApiAware()),
                (new Field\StringField('address', 'address'))->addFlags(new Flag\Required(), new Flag\ApiAware())
            ])
        );
    }
}
