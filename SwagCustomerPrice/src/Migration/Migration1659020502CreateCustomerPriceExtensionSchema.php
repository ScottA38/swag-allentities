<?php declare(strict_types=1);

namespace Swag\CustomerPrice\Migration;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1659020502CreateCustomerPriceExtensionSchema extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1659020502;
    }

    /**
     * @throws Exception
     */
    public function update(Connection $connection): void
    {
        $sql = <<<EOF
CREATE TABLE IF NOT EXISTS `swag_customer_price_extension` (
    `id` BINARY(16) NOT NULL,
    `version_id` BINARY(16) NOT NULL,
    `product_id` BINARY(16) NOT NULL,
    `product_version_id` BINARY(16) NOT NULL,
    `customer_id` BINARY(16) NOT NULL,
    `price` JSON NOT NULL,
    `quantity_start` INT(11) NOT NULL,
    `quantity_end` INT(11) NULL,
    `custom_fields` JSON NULL,
    `created_at` DATETIME(3) NOT NULL,
    `updated_at` DATETIME(3) NULL,
    PRIMARY KEY (`id`,`version_id`),
    CONSTRAINT `json.swag_customer_price_extension.price` CHECK (JSON_VALID(`price`)),
    CONSTRAINT `json.swag_customer_price_extension.custom_fields` CHECK (JSON_VALID(`custom_fields`)),
    KEY `fk.swag_customer_price_extension.product_id` (`product_id`,`product_version_id`),
    KEY `fk.swag_customer_price_extension.customer_id` (`customer_id`),
    CONSTRAINT `fk.swag_customer_price_extension.product_id` FOREIGN KEY (`product_id`,`product_version_id`) REFERENCES `product` (`id`,`version_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
    CONSTRAINT `fk.swag_customer_price_extension.customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
EOF;

        $connection->executeStatement($sql);
    }

    /**
     * @throws Exception
     */
    public function updateDestructive(Connection $connection): void
    {
        $sql = <<<EOF
DROP TABLE IF EXISTS `swag_customer_price_extension`;
CREATE TABLE `swag_customer_price_extension` (
    `id` BINARY(16) NOT NULL,
    `version_id` BINARY(16) NOT NULL,
    `product_id` BINARY(16) NOT NULL,
    `product_version_id` BINARY(16) NOT NULL,
    `customer_id` BINARY(16) NOT NULL,
    `price` JSON NOT NULL,
    `quantity_start` INT(11) NOT NULL,
    `quantity_end` INT(11) NULL,
    `custom_fields` JSON NULL,
    `created_at` DATETIME(3) NOT NULL,
    `updated_at` DATETIME(3) NULL,
    PRIMARY KEY (`id`,`version_id`),
    CONSTRAINT `json.swag_customer_price_extension.price` CHECK (JSON_VALID(`price`)),
    CONSTRAINT `json.swag_customer_price_extension.custom_fields` CHECK (JSON_VALID(`custom_fields`)),
    KEY `fk.swag_customer_price_extension.product_id` (`product_id`,`product_version_id`),
    KEY `fk.swag_customer_price_extension.customer_id` (`customer_id`),
    CONSTRAINT `fk.swag_customer_price_extension.product_id` FOREIGN KEY (`product_id`,`product_version_id`) REFERENCES `product` (`id`,`version_id`) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `fk.swag_customer_price_extension.customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
EOF;

        $connection->executeStatement($sql);
    }
}
