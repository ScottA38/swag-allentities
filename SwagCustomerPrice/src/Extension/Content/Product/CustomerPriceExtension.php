<?php
declare(strict_types=1);

namespace Swag\CustomerPrice\Extension\Content\Product;

use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;

/**
 * Class CustomerPriceExtension
 */
class CustomerPriceExtension extends EntityExtension
{
    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            new OneToManyAssociationField('customerPriceExtension', CustomerPriceExtensionDefinition::class, 'product_id', 'id')
        );
    }

    /**
     * @inheritDoc
     */
    public function getDefinitionClass(): string
    {
        return ProductDefinition::class;
    }
}
