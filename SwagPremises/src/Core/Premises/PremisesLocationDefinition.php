<?php
declare(strict_types=1);

namespace Swag\Premises\Core\Premises;

use Shopware\Core\Checkout\Order\Aggregate\OrderCustomer\OrderCustomerDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\ApiAware;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\CascadeDelete;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\SearchRanking;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

/**
 * Class PremisesLocationDefinition
 */
class PremisesLocationDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'swag_premises_location';

    /**
     * @return string
     */
    public function getEntityName(): string
    {
        return static::ENTITY_NAME;
    }

    public function getEntityClass(): string
    {
        return PremisesLocationEntity::class;
    }

    /**
     * @return FieldCollection
     */
    protected function defineFields(): FieldCollection
    {
        return (new FieldCollection([
                (new Field\IdField('id', 'id'))->addFlags(new Flag\PrimaryKey(), new Flag\Required()),
                (new Field\StringField('number', 'number' ))->addFlags(new Flag\Required(), new Flag\ApiAware()),
                (new Field\StringField('line_one', 'line_one'))->addFlags(new Flag\Required(), new Flag\ApiAware()),
                (new Field\StringField('line_two', 'line_two'))->addFlags(new Flag\ApiAware()),
                (new Field\StringField('town_or_city', 'town_or_city'))->addFlags(new Flag\ApiAware()),
                (new Field\StringField('county_or_province', 'county_or_province'))->addFlags(new Flag\ApiAware()),
                (new Field\StringField('postal_code', 'postal_code'))->addFlags(new Flag\Required(), new Flag\ApiAware()),

                (new OneToOneAssociationField('premises', 'location_id', 'location_id', PremisesDefinition::class))->addFlags(new ApiAware())
            ])
        );
    }
}
