<?php

/**
 * @file
 * Contains Drupal\nexteuropa_integration\Tests\Consumer\ConsumerTest.
 */

namespace Drupal\nexteuropa_integration\Tests\Consumer;

use Drupal\nexteuropa_integration\Backend\Configuration\BackendConfiguration;
use Drupal\nexteuropa_integration\Consumer\Configuration\ConsumerConfiguration;
use Drupal\nexteuropa_integration\Consumer\Consumer;
use Drupal\nexteuropa_integration\Tests\AbstractTest;

/**
 * Class ConsumerTest.
 *
 * @package Drupal\nexteuropa_integration\Tests\Consumer
 */
class ConsumerTest extends AbstractTest {

  /**
   * Setup PHPUnit hook.
   */
  public function setUp() {
    parent::setUp();
    \MigrationBase::setDisplayFunction('Drupal\nexteuropa_integration\Tests\Consumer\ConsumerTest::migrateException');
  }

  /**
   * Migration display message callback.
   *
   * @param string $message
   *    Exception message.
   * @param string $level
   *    Exception level.
   *
   * @throws \MigrateException
   *
   * @see \MigrationBase::$displayFunction
   * @see \MigrationBase::displayMessage()
   */
  static public function migrateException($message, $level = 'error') {
    if ($level == 'error') {
      throw new \MigrateException($message, $level);
    }
  }

  /**
   * Test creation of a consumer instance.
   */
  public function testConsumer() {

    /** @var Consumer $migration */
    $migration = Consumer::getInstance('test_configuration');

    $this->assertNotNull($migration);

    $mapping = $migration->getFieldMappings();
    foreach ($migration->getConfiguration()->getMapping() as $destination => $source) {
      $this->assertArrayHasKey($destination, $mapping);
      $this->assertEquals($source, $mapping[$destination]->getSourceField());
    }
    $this->assertArrayHasKey('title_field', $mapping);
    $this->assertEquals('source_title', $mapping['title_field']->getSourceField());
//    $this->assertArrayHasKey('field_integration_test_images:file_replace', $mapping);
//    $this->assertArrayHasKey('field_integration_test_files:file_replace', $mapping);

    return;
  }

}
