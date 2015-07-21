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

/**
 * Class AbstractTest.
 *
 * @package Drupal\nexteuropa_integration\Tests
 */
abstract class AbstractTest extends \PHPUnit_Framework_TestCase {

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
   * @param string $type
   *    Entity type.
   * @param int $id
   *    Entity ID.
   *
   * @return \stdClass
   *    Entity object.
   */
  protected function getExportedEntityFixture($type, $id) {
    static $fixtures = array();
    if (!isset($fixtures[$type][$id])) {
      $export = new \stdClass();
      include "fixtures/$type-$id.php";
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
    $entity_wrapper = new EntityWrapper('node', $node);
    $document = new Document();
    return new NodeProducer($entity_wrapper, $document);
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
