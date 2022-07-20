<?php declare(strict_types=1);

namespace Swag\Premises\Migration;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1658140020PremisesEntitySchemaCreate extends MigrationStep
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
CREATE TABLE IF NOT EXISTS `swag_premises` (
    `id` BINARY(16) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `address` VARCHAR(255) NOT NULL,
    `created_at` DATETIME(3) NOT NULL,
    `updated_at` DATETIME(3) NULL,
    PRIMARY KEY (`id`)
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
DROP TABLE IF EXISTS `swag_premises`;
CREATE TABLE `swag_premises` (
    `id` BINARY(16) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `address` VARCHAR(255) NOT NULL,
    `created_at` DATETIME(3) NOT NULL,
    `updated_at` DATETIME(3) NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
EOF;

        $connection->executeStatement($sql);
    }
}
