<?php
declare(strict_types=1);

namespace Swag\CustomerPrice\Extension\Content\Product;

use Shopware\Core\Checkout\Customer\CustomerDefinition;
use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Content\Rule\RuleDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\CustomFields;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\ApiAware;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\ReverseInherited;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IntField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\PriceField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ReferenceVersionField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\VersionField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

/**
 * Class CustomerPriceExtensionDefinition
 */
class CustomerPriceExtensionDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'swag_customer_price_extension';

    public function getEntityName(): string
    {
        return static::ENTITY_NAME;
    }

    protected function defineFields(): FieldCollection
    {
//        return new FieldCollection([
//                                       (new IdField('id', 'id'))->addFlags(new Required(), new PrimaryKey()),
//                                       (new FkField('product_id', 'productId', ProductDefinition::class))->addFlags(new ApiAware()),
//                                       (new PriceField('customer_price', 'customerPrice'))->addFlags(new ApiAware()),
//                                       (new ReferenceVersionField(ProductDefinition::class))->addFlags(new ApiAware()),
//
//                                       (new ManyToOneAssociationField('product', 'product_id', ProductDefinition::class, 'id', false))
//        ]);

        return new FieldCollection([
           (new IdField('id', 'id'))->addFlags(new PrimaryKey(), new Required()),
           new VersionField(),
           (new FkField('product_id', 'productId', ProductDefinition::class))->addFlags(new Required()),
           (new ReferenceVersionField(ProductDefinition::class))->addFlags(new Required()),
           (new FkField('customer_id', 'customerId', CustomerDefinition::class))->addFlags(new Required()),
           (new PriceField('price', 'price'))->addFlags(new Required()),
           (new IntField('quantity_start', 'quantityStart'))->addFlags(new Required()),
           new IntField('quantity_end', 'quantityEnd'),
           new CustomFields(),

           (new ManyToOneAssociationField('product', 'product_id', ProductDefinition::class, 'id', false))->addFlags(new ReverseInherited('prices')),
           (new ManyToOneAssociationField('customer', 'customer_id', CustomerDefinition::class, 'id', false))
        ]);
    }
}
