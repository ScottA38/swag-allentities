<?php
declare(strict_types=1);

namespace Swag\Emojis\Core\Content\Emoji;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

/**
 * Class EmojiEntity
 */
class EmojiEntity extends Entity
{
    use EntityIdTrait;

    protected ?string $name;

    protected ?int $image_url;

    protected ?string $description;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int|null
     */
    public function getImageUrl(): ?int
    {
        return $this->image_url;
    }

    /**
     * @param int|null $image_url
     */
    public function setImageUrl(?int $image_url): void
    {
        $this->image_url = $image_url;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
