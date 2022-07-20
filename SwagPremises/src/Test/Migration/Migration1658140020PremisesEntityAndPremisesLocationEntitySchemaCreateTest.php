<?php
declare(strict_types=1);

namespace Swag\Premises\Test\Migration;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use PHPUnit\Framework\TestCase;
use Shopware\Core\Framework\Test\Migration\MigrationTestBehaviour;
use Shopware\Core\Framework\Test\TestCaseBase\KernelTestBehaviour;
use Swag\Premises\Migration\Migration1658140020PremisesEntitySchemaCreate;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Migration1658140020PremisesEntitySchemaCreateTest
 */
 class Migration1658140020PremisesEntitySchemaCreateTest extends TestCase
 {
     use KernelTestBehaviour;
     use MigrationTestBehaviour;

     public function setUp(): void
     {
         $conn = $this->getContainer()->get(Connection::class);
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
         $migration = new Migration1658140020PremisesEntitySchemaCreate();

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
     public function testNoPremisesTable(): void
     {
         /** @var Connection $conn */
         $conn = $this->getContainer()->get(Connection::class);
         $conn->executeStatement('DROP TABLE `swag_premises`');

         $migration = new Migration1658140020PremisesEntitySchemaCreate();
         $migration->update($conn);
         $exists = $conn->fetchOne('SELECT COUNT(*) FROM `swag_premises`') !== false;

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
         $migration = new Migration1658140020PremisesEntitySchemaCreate();
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
