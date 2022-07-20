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
     * @var PremisesLocationEntity
     */
    protected PremisesLocationEntity $locationEntity;

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
     * @return PremisesLocationEntity
     */
    public function getLocationEntity(): PremisesLocationEntity
    {
        return $this->locationEntity;
    }

    /**
     * @param PremisesLocationEntity $locationEntity
     */
    public function setLocationEntity(PremisesLocationEntity $locationEntity): void
    {
        $this->locationEntity = $locationEntity;
    }


}
