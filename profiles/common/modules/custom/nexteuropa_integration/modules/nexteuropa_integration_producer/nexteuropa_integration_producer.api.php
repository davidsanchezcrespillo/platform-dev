<?php

/**
 * @file
 * Contains API documentation.
 */

use Drupal\nexteuropa_integration\Document\DocumentInterface;
use Drupal\nexteuropa_integration\Producer\EntityWrapper\EntityWrapper;

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
      'class' => '\Drupal\nexteuropa_integration\Producer\FieldHandlers\TextFieldHandler',
      'alter' => TRUE,
    ),
  );
}

/**
 * Implements hook_nexteuropa_integration_producer_field_handler_info_alter().
 */
function hook_nexteuropa_integration_producer_field_handler_info_alter(&$field_handlers) {
  $field_handlers['alter'] = FALSE;
}

/**
 * Implements hook_nexteuropa_integration_producer_document_build_alter().
 */
function hook_nexteuropa_integration_producer_document_build_alter(EntityWrapper $entity_wrapper, DocumentInterface $document) {
  if ($entity_wrapper->type() == 'node') {
    $document->setMetadata('original-type', $entity_wrapper->getBundle());
  }
}
