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
  public function testProducerInfo() {

    $hook_response = nexteuropa_integration_producer_get_producers();
    $expected = array(
      'node' => '\Drupal\nexteuropa_integration\Producer\NodeProducer',
      'taxonomy_term' => '\Drupal\nexteuropa_integration\Producer\TaxonomyTermProducer',
    );
    foreach ($expected as $key => $value) {
      $this->assertTrue(isset($hook_response[$key]));
      $this->assertEquals($value, $hook_response[$key]['class']);
    }
  }

  /**
   * Test hook_nexteuropa_integration_producer_formatter_handler_info().
   */
  public function testProducerFormatterHandlersInfo() {

    $hook_response = nexteuropa_integration_producer_get_formatter_handlers();
    $expected = array(
      'json_formatter' => '\Drupal\nexteuropa_integration\Backend\Formatter\JsonFormatter',
    );
    foreach ($expected as $key => $value) {
      $this->assertTrue(isset($hook_response[$key]));
      $this->assertEquals($value, $hook_response[$key]['class']);
    }
  }

  /**
   * Test hook_nexteuropa_integration_producer_response_handler_info().
   */
  public function testProducerResponseHandlersInfo() {

    $hook_response = nexteuropa_integration_producer_get_response_handlers();
    $expected = array(
      'http_response' => '\Drupal\nexteuropa_integration\Backend\Response\HttpRequestResponse',
      'memory_response' => '\Drupal\nexteuropa_integration\Backend\Response\MemoryResponse',
    );
    foreach ($expected as $key => $value) {
      $this->assertTrue(isset($hook_response[$key]));
      $this->assertEquals($value, $hook_response[$key]['class']);
    }
  }

  /**
   * Test hook_nexteuropa_integration_producer_field_handler_info().
   */
  public function testProducerFieldHandlersInfo() {

    $hook_response = nexteuropa_integration_producer_get_field_handlers();
    $expected = array(
      'default' => '\Drupal\nexteuropa_integration\Producer\FieldHandlers\DefaultFieldHandler',
      'text' => '\Drupal\nexteuropa_integration\Producer\FieldHandlers\TextFieldHandler',
      'text_long' => '\Drupal\nexteuropa_integration\Producer\FieldHandlers\TextFieldHandler',
    );
    foreach ($expected as $key => $value) {
      $this->assertTrue(isset($hook_response[$key]));
      $this->assertEquals($value, $hook_response[$key]['class']);
    }
  }

}
