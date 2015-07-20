<?php

/**
 * @file
 * Contains \Drupal\nexteuropa_integration\Tests\AbstractMigrateTest.
 */

namespace Drupal\nexteuropa_integration\Tests\Consumer\Migrate;

/**
 * Class AbstractMigrateTest.
 *
 * @package Drupal\nexteuropa_integration\Tests\Consumer\Migrate
 */
abstract class AbstractMigrateTest extends \PHPUnit_Framework_TestCase {

  /**
   * List of JSON document paths, divided by entity type, keyed by document id.
   *
   * @var array
   *    List of fixtures divided by entity type.
   */
  public $fixtures = array();

  /**
   * {@inheritdoc}
   */
  public function setUp() {

    if (!module_exists('nexteuropa_integration_test')) {
      throw new \Exception('NextEuropa Migrate module must be enabled before running tests.');
    }
    $this->buildFixturesList();
  }

  /**
   * Return Consumer tests fixtures path.
   *
   * @return string
   *    Fixtures path.
   */
  public static function getFixturesPath() {
    return dirname(__FILE__) . '/fixtures';
  }

  /**
   * Generate list of fixtures divided by entity type.
   */
  public function buildFixturesList() {
    $directory = self::getFixturesPath();
    foreach (array('news', 'articles', 'categories') as $type) {
      foreach (file_scan_directory($directory . '/' . $type, '/(document-.*\.json)$/') as $path => $file) {
        list(, $id) = explode('-', $file->name);
        $this->fixtures[$type][$id] = $path;
      }
    }
  }

  /**
   * Get list of fixtures.
   *
   * @return array
   *    List of JSON document paths.
   */
  public function getFixturesList() {

    if (empty($this->fixtures)) {
      $this->buildFixturesList();
    }
    return $this->fixtures;
  }

  /**
   * Get parsed JSON document.
   *
   * @param string $type
   *    Document type, either 'articles', 'news', 'categories'.
   * @param int $id
   *    Document ID.
   *
   * @return object
   *    Parsed JSON document.
   */
  public function getDocument($type, $id) {
    $filename = $this->fixtures[$type][$id];
    $json = file_get_contents($filename);
    return json_decode($json);
  }

}
