<?php

/**
 * @file
 * Contains Drupal\nexteuropa_integration\Tests\AbstractTest.
 */

namespace Drupal\nexteuropa_integration\Tests;

use Drupal\nexteuropa_integration\Consumer\Consumer;
use Drupal\nexteuropa_integration\Producer\EntityWrapper\EntityWrapper;
use Drupal\nexteuropa_integration\Document\Document;
use Drupal\nexteuropa_integration\Producer\NodeProducer;
use Drupal\nexteuropa_integration\Backend\Configuration\BackendConfiguration;
use Drupal\nexteuropa_integration\Consumer\Configuration\ConsumerConfiguration;
use Drupal\nexteuropa_integration\Producer\Configuration\ProducerConfiguration;


/**
 * Class AbstractTest.
 *
 * @package Drupal\nexteuropa_integration\Tests
 */
abstract class AbstractTest extends \PHPUnit_Framework_TestCase {

  /**
   * Reference to backend configuration object.
   *
   * @var BackendConfiguration
   */
  public $backend_configuration = NULL;

  /**
   * Reference to producer configuration object.
   *
   * @var ProducerConfiguration
   */
  public $producer_configuration = NULL;

  /**
   * Reference to backend configuration object.
   *
   * @var ConsumerConfiguration
   */
  public $consumer_configuration = NULL;


  /**
   * Setup PHPUnit hook.
   */
  public function setUp() {
    parent::setUp();
    $GLOBALS['base_url'] = 'http://example.com';

    $data = $this->getConfigurationFixture('backend', 'test_configuration');
    $this->backend_configuration = entity_create('integration_backend', (array) $data);
    $this->backend_configuration->save();

    $data = $this->getConfigurationFixture('producer', 'test_configuration');
    $this->producer_configuration = entity_create('integration_producer', (array) $data);
    $this->producer_configuration->save();

    $data = $this->getConfigurationFixture('consumer', 'test_configuration');
    $this->consumer_configuration = entity_create('integration_consumer', (array) $data);
    $this->consumer_configuration->save();
  }

  /**
   * PHPUnit hook.
   */
  public function tearDown() {
    parent::tearDown();

    $this->backend_configuration->delete();
    $this->producer_configuration->delete();
    $this->consumer_configuration->delete();
  }

  /**
   * Get configuration fixture.
   *
   * @param string $type
   *    Configuration type.
   * @param string $name
   *    Configuration machine name.
   *
   * @return \stdClass
   *    Configuration settings object.
   */
  protected function getConfigurationFixture($type, $name) {
    static $fixtures = array();
    if (!isset($fixtures[$type][$name])) {
      $export = new \stdClass();
      include "fixtures/configuration/$type-$name.php";
      $fixtures[$type][$name] = clone $export;
    }
    return $fixtures[$type][$name];
  }

  /**
   * Get exported entity from fixture directory.
   *
   * @param string $entity_type
   *    Entity type.
   * @param string $bundle
   *    Bundle.
   * @param int $id
   *    Entity ID.
   *
   * @return \stdClass
   *    Entity object.
   */
  protected function getExportedEntityFixture($entity_type, $bundle, $id) {
    static $fixtures = array();
    if (!isset($fixtures[$type][$id])) {
      $export = new \stdClass();
      include "fixtures/entities/$entity_type-$bundle-$id.php";
      $fixtures[$type][$id] = clone $export;
    }
    return $fixtures[$type][$id];
  }

  /**
   * Get rendered entity from fixture directory.
   *
   * @param string $type
   *    Entity type.
   * @param int $id
   *    Entity ID.
   *
   * @return \stdClass
   *    Entity object.
   */
  protected function getRenderedEntityFixture($type, $id) {
    $filename = dirname(__FILE__) . "/fixtures/$type-$id.json";
    if (!file_exists($filename)) {
      throw new \InvalidArgumentException("Fixture '$type-$id.json' not found");
    }
    return file_get_contents($filename);
  }

  /**
   * Factory method: return node producer instance given a node object.
   *
   * @param object $node
   *    Node object.
   *
   * @return NodeProducer
   *    Node producer instance.
   */
  protected function getNodeProducerInstance($node) {
    $settings = $this->getConfigurationFixture('producer', 'local');

    $entity_wrapper = new EntityWrapper('node', $node);
    $document = new Document();
    return new NodeProducer($settings, $entity_wrapper, $document);
  }

  /**
   * Factory method: return consumer instance given its name.
   *
   * @param object $settings
   *    Consumer configuration settings.
   *
   * @return Consumer
   *    Consumer instance.
   */
  protected function getConsumerInstance($settings) {
    Consumer::register($settings);
    return Consumer::getInstance($settings->name);
  }

}
