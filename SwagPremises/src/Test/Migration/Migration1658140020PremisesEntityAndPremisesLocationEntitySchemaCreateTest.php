<?php
declare(strict_types=1);

namespace Swag\Premises\Test\Migration;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use PHPUnit\Framework\TestCase;
use Shopware\Core\Framework\Test\Migration\MigrationTestBehaviour;
use Shopware\Core\Framework\Test\TestCaseBase\KernelTestBehaviour;
use Swag\Premises\Migration\Migration1658140020PremisesEntityAndPremisesLocationEntitySchemaCreate;

/**
 * Class Migration1658140020PremisesEntityAndPremisesLocationEntitySchemaCreateTest
 */
 class Migration1658140020PremisesEntityAndPremisesLocationEntitySchemaCreateTest extends TestCase
 {
     use KernelTestBehaviour;
     use MigrationTestBehaviour;

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
 }
