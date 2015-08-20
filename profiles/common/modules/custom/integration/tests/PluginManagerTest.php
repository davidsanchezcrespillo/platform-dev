<?php

/**
 * @file
 * Contains Drupal\integration\Tests\PluginManager.
 */

namespace Drupal\integration\Tests;

use Drupal\integration\PluginManager;

/**
 * Class PluginManager.
 *
 * @package Drupal\integration\Tests
 */
class PluginManagerTest extends \PHPUnit_Framework_TestCase {

  /**
   * Test plugin manager construction.
   */
  public function testConstruction() {

    $this->assertEquals(array('response_handler', 'formatter_handler'), PluginManager::getInstance('backend')->getComponents());
    $this->assertEquals(array('mapping_handler'), PluginManager::getInstance('consumer')->getComponents());
    $this->assertEquals(array('field_handler'), PluginManager::getInstance('producer')->getComponents());
  }

  /**
   * Test info hooks.
   */
  public function testInfo() {

    $info = PluginManager::getInstance('consumer')->setComponent('mapping_handler')->getInfo();
    $expected = array(
      'title_mapping',
      'file_field_mapping',
      'text_with_summary_mapping',
    );
    $this->assertEquals($expected, array_keys($info));

    $manager = PluginManager::getInstance('backend')->setComponent('response_handler');

    $label = $manager->getLabel();
    $class = $manager->getClass();
    $description = $manager->getDescription();

    return;
  }
}
