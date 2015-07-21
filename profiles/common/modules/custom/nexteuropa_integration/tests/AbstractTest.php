<?php

/**
 * @file
 * Contains Drupal\nexteuropa_integration\Tests\AbstractTest.
 */

namespace Drupal\nexteuropa_integration\Tests;

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
      include_once "fixtures/configuration/$type-$name.php";
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
      include_once "fixtures/$type-$id.php";
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

}
