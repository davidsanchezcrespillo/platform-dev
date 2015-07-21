<?php

/**
 * @file
 * Contains Drupal\nexteuropa_integration\Tests\Consumer\ConsumerTest.
 */

namespace Drupal\nexteuropa_integration\Tests\Consumer;

use Drupal\nexteuropa_integration\Consumer\Configuration\ConsumerConfiguration;
use Drupal\nexteuropa_integration\Consumer\Consumer;

/**
 * Class ConsumerTest.
 *
 * @package Drupal\nexteuropa_integration\Tests\Consumer
 */
class ConsumerTest extends \PHPUnit_Framework_TestCase {

  /**
   * Setup PHPUnit hook.
   */
  public function setUp() {
    $GLOBALS['base_url'] = 'http://example.com';
  }

  /**
   * Test creation of a consumer instance.
   */
  public function testConsumerConfiguration() {

    $configuration = new ConsumerConfiguration('Label', 'name', 'node', 'article');

    $this->assertEquals('Label', $configuration->getLabel());
    $this->assertEquals('name', $configuration->getName());
    $this->assertEquals('node', $configuration->getEntityType());
    $this->assertEquals('article', $configuration->getBundle());
    $this->assertEquals(TRUE, $configuration->getStatus());

    $settings = $this->getSettings();

    $configuration = ConsumerConfiguration::getInstance($settings);

    $this->assertEquals($settings->label, $configuration->getLabel());
    $this->assertEquals($settings->name, $configuration->getName());
    $this->assertEquals($settings->entity_type, $configuration->getEntityType());
    $this->assertEquals($settings->bundle, $configuration->getBundle());
    $this->assertEquals($settings->status, $configuration->getStatus());
    $this->assertEquals($settings->mapping, $configuration->getMapping());
    $this->assertEquals($settings->options, $configuration->getOptions());
  }

  /**
   * Test creation of a consumer instance.
   */
  public function testConsumer() {
    $settings = $this->getSettings();

    Consumer::register($settings);

    $migration = \Migration::getInstance($settings->name);
    $this->assertNotNull($migration);

    $mapping = $migration->getFieldMappings();
    foreach ($settings->mapping as $destination => $source) {
      $this->assertTrue(isset($mapping[$destination]));
      $this->assertEquals($source, $mapping[$destination]->getSourceField());
    }
    $this->assertEquals('source_title', $mapping['title_field']->getSourceField());
    $this->assertArrayHasKey('field_integration_test_images:file_replace', $mapping);
    $this->assertArrayHasKey('field_integration_test_files:file_replace', $mapping);
  }

  /**
   * Test settings object.
   *
   * @return \stdClass
   *    Settings object.
   */
  protected function getSettings() {
    $settings = new \stdClass();
    $settings->label = 'Label';
    $settings->name = 'name';
    $settings->status = TRUE;
    $settings->backend = 'backend';
    $settings->entity_type = 'node';
    $settings->bundle = 'article';
    $settings->mapping = array(
      'title' => 'source_title',
      'body' => 'source_body',
      'field_integration_test_images' => 'source_image',
      'field_integration_test_files' => 'source_files',
    );
    $settings->options = array(
      'option1' => 'value1',
      'option2' => 'value2',
    );
    return $settings;
  }

}
