<?php

/**
 * @file
 * Contains backend-related hook implementations.
 */

/**
 * Implements hook_nexteuropa_integration_backend_info().
 */
function nexteuropa_integration_nexteuropa_integration_backend_info() {
  return array(
    'rest_backend' => array(
      'class' => 'Drupal\nexteuropa_integration\Backend\RestBackend',
    ),
    'memory_backend' => array(
      'class' => 'Drupal\nexteuropa_integration\Backend\MemoryBackend',
    ),
  );
}

/**
 * Implements hook_nexteuropa_integration_backend_formatter_handler_info().
 */
function nexteuropa_integration_nexteuropa_integration_backend_formatter_handler_info() {
  return array(
    'json_formatter' => array(
      'class' => 'Drupal\nexteuropa_integration\Backend\Formatter\JsonFormatter',
    ),
  );
}

/**
 * Implements hook_nexteuropa_integration_backend_response_handler_info().
 */
function nexteuropa_integration_nexteuropa_integration_backend_response_handler_info() {
  return array(
    'http_response' => array(
      'class' => 'Drupal\nexteuropa_integration\Backend\Response\HttpRequestResponse',
    ),
    'memory_response' => array(
      'class' => 'Drupal\nexteuropa_integration\Backend\Response\MemoryResponse',
    ),
  );
}

