<?php
declare(strict_types=1);

namespace Swag\Premises\Test\Migration;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use PHPUnit\Framework\TestCase;
use Shopware\Core\Framework\Test\Migration\MigrationTestBehaviour;
use Shopware\Core\Framework\Test\TestCaseBase\KernelTestBehaviour;
use Swag\Premises\Migration\Migration1658140020PremisesEntityAndPremisesLocationEntitySchemaCreate;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Migration1658140020PremisesEntityAndPremisesLocationEntitySchemaCreateTest
 */
 class Migration1658140020PremisesEntityAndPremisesLocationEntitySchemaCreateTest extends TestCase
 {
     use KernelTestBehaviour;
     use MigrationTestBehaviour;

     public function setUp(): void
     {
         $conn = $this->getContainer()->get(Connection::class);
         $sql = <<<EOF
    DROP TABLE IF EXISTS `swag_premises`;
    CREATE TABLE IF NOT EXISTS `swag_premises` (
        `id` BINARY(16) NOT NULL,
        `name` VARCHAR(255) NOT NULL,
        `created_at` DATETIME(3) NOT NULL,
        `updated_at` DATETIME(3) NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

    DROP TABLE IF EXISTS `swag_premises_location`;
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

EOF;
         $conn->executeStatement($sql);
     }

     /**
      * @throws Exception
      */
     public function testNoChangesPremisesTable(): void
     {
         /** @var Connection $conn */
         $conn = $this->getContainer()->get(Connection::class);
         $expectedSchema = $conn->fetchAssociative('SHOW CREATE TABLE `swag_premises`')['Create Table'];
         // Use fetchAssociative such that can access the table create create query directly
         $migration = new Migration1658140020PremisesEntityAndPremisesLocationEntitySchemaCreate();

         $migration->update($conn);
         $actualSchema = $conn->fetchAssociative('SHOW CREATE TABLE `swag_premises`')['Create Table'];
         static::assertSame($expectedSchema, $actualSchema, 'Schema changed!. Run init again to have clean state');

         $migration->updateDestructive($conn);
         $actualSchema = $conn->fetchAssociative('SHOW CREATE TABLE `swag_premises`')['Create Table'];
         static::assertSame($expectedSchema, $actualSchema, 'Schema changed!. Run init again to have clean state');
     }

     /**
      * @throws Exception
      */
     public function testNoChangesPremisesLocationTable(): void
     {
         /** @var Connection $conn */
         $conn = $this->getContainer()->get(Connection::class);
         $expectedSchema = $conn->fetchAssociative('SHOW CREATE TABLE `swag_premises_location`')['Create Table'];
         // Use fetchAssociative such that can access the table create create query directly
         $migration = new Migration1658140020PremisesEntityAndPremisesLocationEntitySchemaCreate();

         $migration->update($conn);
         $actualSchema = $conn->fetchAssociative('SHOW CREATE TABLE `swag_premises_location`')['Create Table'];
         static::assertSame($expectedSchema, $actualSchema, 'Schema changed!. Run init again to have clean state');

         $migration->updateDestructive($conn);
         $actualSchema = $conn->fetchAssociative('SHOW CREATE TABLE `swag_premises_location`')['Create Table'];
         static::assertSame($expectedSchema, $actualSchema, 'Schema changed!. Run init again to have clean state');
     }

     /**
      * @throws Exception
      */
     public function testNoPremisesTable(): void
     {
         /** @var Connection $conn */
         $conn = $this->getContainer()->get(Connection::class);
         $conn->executeStatement('DROP TABLE `swag_premises`');

         $migration = new Migration1658140020PremisesEntityAndPremisesLocationEntitySchemaCreate();
         $migration->update($conn);
         $exists = $conn->fetchOne('SELECT COUNT(*) FROM `swag_premises`') !== false;

         static::assertTrue($exists);
     }

     /**
      * @throws Exception
      */
     public function testNoPremisesLocationTable(): void
     {
         /** @var Connection $conn */
         $conn = $this->getContainer()->get(Connection::class);
         $conn->executeStatement('DROP TABLE `swag_premises_location`');

         $migration = new Migration1658140020PremisesEntityAndPremisesLocationEntitySchemaCreate();
         $migration->update($conn);
         $exists = $conn->fetchOne('SELECT COUNT(*) FROM `swag_premises_location`') !== false;

         static::assertTrue($exists);
     }

     /**
      * @throws Exception
      */
     public function testCanRunMigrationTwice(): void
     {
         /** @var Connection $conn */
         $conn = $this->getContainer()->get(Connection::class);
         $expectedSchema = $conn->fetchAssociative('SHOW CREATE TABLE `swag_premises`')['Create Table'];
         $conn->executeStatement('DROP TABLE `swag_premises`');
         $migration = new Migration1658140020PremisesEntityAndPremisesLocationEntitySchemaCreate();
         try {
             $migration->update($conn);
             $migration->update($conn);
             $actualSchema = $conn->fetchAssociative('SHOW CREATE TABLE `swag_premises`')['Create Table'];
             $this->assertEquals($expectedSchema, $actualSchema);
         } catch (Exception $e) {
             $this->fail(sprintf("Failed %s: %s", __METHOD__, $e->getMessage()));
         }
     }
 }
