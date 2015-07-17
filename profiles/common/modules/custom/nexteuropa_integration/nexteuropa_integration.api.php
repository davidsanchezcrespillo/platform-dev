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
