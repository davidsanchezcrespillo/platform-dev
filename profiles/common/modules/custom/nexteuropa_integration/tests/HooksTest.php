<?php

/**
 * @file
 * Contains Drupal\nexteuropa_integration\Tests\BackendTest.
 */

namespace Drupal\nexteuropa_integration\Tests;

/**
 * Test nexteuropa_integration hook implementation and altering.
 *
 * @package Drupal\nexteuropa_integration\Tests\BackendTest
 */
class HooksTest extends \PHPUnit_Framework_TestCase {

  /**
   * Test hook_nexteuropa_integration_producer_info().
   */
  public function testInfoProducers() {

    $producers = nexteuropa_integration_producer_info_producers();
    foreach (array('node', 'taxonomy_term') as $entity_type) {
      $this->assertTrue(isset($producers[$entity_type]));
      $this->assertTrue($producers[$entity_type]['class'] == '\Drupal\nexteuropa_integration\Producer\DefaultProducer');
    }
  }

  /**
   * Test hook_nexteuropa_integration_producer_field_handler_info().
   */
  public function testInfoFieldHandlers() {

    $field_types = array(
      'datetime',
      'date',
      'datestamp',
      'list_float',
      'list_text',
      'list_boolean',
      'number_integer',
      'number_decimal',
      'number_float',
      'text',
      'text_long',
      'text_with_summary',
    );
    $field_handlers = nexteuropa_integration_producer_info_field_handlers();
    foreach ($field_types as $type) {
      $this->assertTrue(isset($field_handlers[$type]));
      $this->assertTrue($field_handlers[$type]['class'] == '\Drupal\nexteuropa_integration\Producer\FieldHandlers\DefaultFieldHandler');
      $this->assertFalse($field_handlers[$type]['alter']);
    }
  }

}
