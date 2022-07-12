<?php
declare(strict_types=1);

namespace Swag\Emojis\Core\Content\Emoji;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * Class EmojiCollection
 * @method void add(EmojiEntity $entity)
 * @method void set(string $key, EmojiEntity $emojiEntity)
 * @method EmojiEntity[] getIterator()
 * @method EmojiEntity[] getElements()
 * @method EmojiEntity| null get(string $key)
 * @method EmojiEntity|null first()
 * @method EmojiEntity|null last()
 */
class EmojiCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return EmojiEntity::class;
    }
}
