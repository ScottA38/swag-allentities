<?php declare(strict_types=1);

namespace Swag\Premises\Migration;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1658140020PremisesEntityAndPremisesLocationEntitySchemaCreate extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1658140020;
    }

    /**
     * @throws Exception
     */
    public function update(Connection $connection): void
    {
        $sql = <<<EOF
    CREATE TABLE IF NOT EXISTS `swag_premises_location` (
        `id` BINARY(16) NOT NULL,
        `number` VARCHAR(255) NOT NULL,
        `line_one` VARCHAR(255) NOT NULL,
        `line_two` VARCHAR(255) NULL,
        `town_or_city` VARCHAR(255) NULL,
        `county_or_province` VARCHAR(255) NULL,
        `country` VARCHAR(255) NOT NULL,
        `postal_code` VARCHAR(255) NOT NULL,
        `created_at` DATETIME(3) NOT NULL,
        `updated_at` DATETIME(3) NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

    CREATE TABLE IF NOT EXISTS `swag_premises` (
        `id` BINARY(16) NOT NULL,
        `name` VARCHAR(255) NOT NULL,
        `location_id` BINARY(16) NOT NULL,
        `created_at` DATETIME(3) NOT NULL,
        `updated_at` DATETIME(3) NULL,
        PRIMARY KEY (`id`),
        FOREIGN KEY (location_id) REFERENCES swag_premises_location(id) ON DELETE NO ACTION
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
    DROP TABLE IF EXISTS `swag_premises_location`;
    CREATE TABLE `swag_premises_location` (
        `id` BINARY(16) NOT NULL,
        `number` VARCHAR(255) NOT NULL,
        `line_one` VARCHAR(255) NOT NULL,
        `line_two` VARCHAR(255) NULL,
        `town_or_city` VARCHAR(255) NULL,
        `county_or_province` VARCHAR(255) NULL,
        `country` VARCHAR(255) NOT NULL,
        `postal_code` VARCHAR(255) NOT NULL,
        `created_at` DATETIME(3) NOT NULL,
        `updated_at` DATETIME(3) NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

    DROP TABLE IF EXISTS `swag_premises`;
    CREATE TABLE IF NOT EXISTS `swag_premises` (
        `id` BINARY(16) NOT NULL,
        `name` VARCHAR(255) NOT NULL,
        `location_id` BINARY(16) NOT NULL,
        `created_at` DATETIME(3) NOT NULL,
        `updated_at` DATETIME(3) NULL,
        PRIMARY KEY (`id`),
        FOREIGN KEY (location_id) REFERENCES swag_premises_location(id) ON DELETE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
EOF;

        $connection->executeStatement($sql);
    }
}
