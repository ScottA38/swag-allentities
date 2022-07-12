<?php
declare(strict_types=1);

namespace Swag\Emojis\Core\Content\Emoji;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag;
use Shopware\Core\Framework\DataAbstractionLayer\Field;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

/**
 * Class EmojiDefinition
 */
class EmojiDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'swag_emoji';

    /**
     * @return string
     */
    public function getEntityName(): string
    {
        return static::ENTITY_NAME;
    }

    /**
     * {@inheritDoc}
     */
    public function getEntityClass(): string
    {
        return EmojiEntity::class;
    }

    public function getCollectionClass(): string
    {
        return EmojiCollection::class;
    }

    /**
     * @return FieldCollection
     */
    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new Field\IdField('id', 'id'))->addFlags(new Flag\Required(), new Flag\PrimaryKey()),
            (new Field\StringField('name', 'name'))->addFlags(new Flag\Required()),
            (new Field\StringField('unicode_address', 'unicode_address'))->addFlags(new Flag\Required()),
            (new Field\LongTextField('description', 'description'))
        ]);
    }
}
