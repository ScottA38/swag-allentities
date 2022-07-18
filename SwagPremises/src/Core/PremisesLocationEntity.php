<?php
declare(strict_types=1);

namespace Swag\Premises\Core;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;

/**
 * Class PremisesLocationEntity
 */
class PremisesLocationEntity extends Entity
{
    /**
     * @var string
     */
    protected string $number;

    /**
     * @var string
     */
    protected string $lineOne;

    /**1
     * @var ?string
     */
    protected ?string $lineTwo;

    /**
     * @var string|null
     */
    protected ?string $townOrCity;

    /**
     * @var string
     */
    protected string $countyOrProvince;

    /**
     * @var string
     */
    protected string $country;

    /**
     * @var string
     */
    protected string $postalCode;

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @param string $number
     */
    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    /**
     * @return string
     */
    public function getLineOne(): string
    {
        return $this->lineOne;
    }

    /**
     * @param string $lineOne
     */
    public function setLineOne(string $lineOne): void
    {
        $this->lineOne = $lineOne;
    }

    /**
     * @return string
     */
    public function getLineTwo(): ?string
    {
        return $this->lineTwo;
    }

    /**
     * @param string|null $lineTwo
     */
    public function setLineTwo(?string $lineTwo): void
    {
        $this->lineTwo = $lineTwo;
    }

    /**
     * @return string
     */
    public function getCountyOrProvince(): string
    {
        return $this->countyOrProvince;
    }

    /**
     * @param string $countyOrProvince
     */
    public function setCountyOrProvince(string $countyOrProvince): void
    {
        $this->countyOrProvince = $countyOrProvince;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     */
    public function setPostalCode(string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return string|null
     */
    public function getTownOrCity(): ?string
    {
        return $this->townOrCity;
    }

    /**
     * @param string|null $townOrCity
     */
    public function setTownOrCity(?string $townOrCity): void
    {
        $this->townOrCity = $townOrCity;
    }
}
