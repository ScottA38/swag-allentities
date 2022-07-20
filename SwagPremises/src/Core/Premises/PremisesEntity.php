<?php
declare(strict_types=1);

namespace Swag\Premises\Core\Premises;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

/**
 * Class PremisesEntity
 */
class PremisesEntity extends Entity
{
    use EntityIdTrait;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string
     */
    protected string $address;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }


}
