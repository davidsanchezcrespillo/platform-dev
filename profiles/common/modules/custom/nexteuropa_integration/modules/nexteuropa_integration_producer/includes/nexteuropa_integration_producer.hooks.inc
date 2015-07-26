<?php

/**
 * @file
 * Contains producer-related hook implementations.
 */

/**
 * Implements hook_nexteuropa_integration_producer_info().
 */
function nexteuropa_integration_nexteuropa_integration_producer_info() {
  return array(
    'node' => array(
      'class' => '\Drupal\nexteuropa_integration\Producer\NodeProducer',
    ),
    'taxonomy_term' => array(
      'class' => '\Drupal\nexteuropa_integration\Producer\TaxonomyTermProducer',
    ),
  );
}

/**
 * Implements hook_nexteuropa_integration_producer_formatter_handler_info().
 */
function nexteuropa_integration_nexteuropa_integration_producer_formatter_handler_info() {
  return array(
    'json_formatter' => array(
      'class' => '\Drupal\nexteuropa_integration\Backend\Formatter\JsonFormatter',
    ),
  );
}

/**
 * Implements hook_nexteuropa_integration_producer_response_handler_info().
 */
function nexteuropa_integration_nexteuropa_integration_producer_response_handler_info() {
  return array(
    'http_response' => array(
      'class' => '\Drupal\nexteuropa_integration\Backend\Response\HttpRequestResponse',
    ),
    'memory_response' => array(
      'class' => '\Drupal\nexteuropa_integration\Backend\Response\MemoryResponse',
    ),
  );
}

/**
 * Implements hook_nexteuropa_integration_producer_info().
 */
function nexteuropa_integration_nexteuropa_integration_producer_field_handler_info() {
  return array(
    'default' => array(
      'class' => '\Drupal\nexteuropa_integration\Producer\FieldHandlers\DefaultFieldHandler',
    ),
    'text' => array(
      'class' => '\Drupal\nexteuropa_integration\Producer\FieldHandlers\TextFieldHandler',
    ),
    'text_long' => array(
      'class' => '\Drupal\nexteuropa_integration\Producer\FieldHandlers\TextFieldHandler',
    ),
    'text_with_summary' => array(
      'class' => '\Drupal\nexteuropa_integration\Producer\FieldHandlers\TextWithSummaryFieldHandler',
    ),
    'date' => array(
      'class' => '\Drupal\nexteuropa_integration\Producer\FieldHandlers\DateFieldHandler',
    ),
    'datetime' => array(
      'class' => '\Drupal\nexteuropa_integration\Producer\FieldHandlers\DateFieldHandler',
    ),
    'datestamp' => array(
      'class' => '\Drupal\nexteuropa_integration\Producer\FieldHandlers\DateFieldHandler',
    ),
    'file' => array(
      'class' => '\Drupal\nexteuropa_integration\Producer\FieldHandlers\FileFieldHandler',
    ),
    'image' => array(
      'class' => '\Drupal\nexteuropa_integration\Producer\FieldHandlers\FileFieldHandler',
    ),
  );
}
