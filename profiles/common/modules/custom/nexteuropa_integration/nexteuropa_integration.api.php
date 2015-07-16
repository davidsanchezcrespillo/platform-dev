<?php
/**
 * @file
 * Contains API documentation.
 */

/**
 * Implements hook_nexteuropa_integration_producer_info().
 */
function hook_nexteuropa_integration_producer_info() {
  return array(
    'node' => array(
      'class' => '\Drupal\nexteuropa_integration\Producer\DefaultProducer',
    ),
  );
}

/**
 * Implements hook_nexteuropa_integration_producer_info_alter().
 */
function hook_nexteuropa_integration_producer_info_alter(&$producers) {
  $producers['node']['class'] = '\Drupal\custom\Producer\CustomProducer';
}

/**
 * Implements hook_nexteuropa_integration_producer_field_handler_info().
 */
function hook_nexteuropa_integration_producer_field_handler_info() {
  return array(
    'text' => array(
      'class' => '\Drupal\nexteuropa_integration\Producer\FieldHandlers\DefaultFieldHandler',
      'alter' => FALSE,
    ),
    'file' => array(
      'class' => '\Drupal\nexteuropa_integration\Producer\FileFieldHandler',
      'alter' => TRUE,
    ),
  );
}

/**
 * Implements hook_nexteuropa_integration_producer_field_handler_info().
 */
function hook_nexteuropa_integration_producer_field_handler_info_alter(&$field_handler) {
  $field_handler['text']['class'] = '\Drupal\custom\Producer\FieldHandlers\CustomFieldHandler';
}
