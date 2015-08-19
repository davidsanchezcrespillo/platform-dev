<?php

/**
 * @file
 * Contains backend-related hook implementations.
 */

/**
 * Implements hook_integration_backend_info().
 */
function integration_integration_backend_info() {
  return array(
    'rest_backend' => array(
      'class' => 'Drupal\integration\Backend\RestBackend',
    ),
    'memory_backend' => array(
      'class' => 'Drupal\integration\Backend\MemoryBackend',
    ),
  );
}

/**
 * Implements hook_integration_backend_formatter_handler_info().
 */
function integration_integration_backend_formatter_handler_info() {
  return array(
    'json_formatter' => array(
      'class' => 'Drupal\integration\Backend\Formatter\JsonFormatter',
    ),
  );
}

/**
 * Implements hook_integration_backend_response_handler_info().
 */
function integration_integration_backend_response_handler_info() {
  return array(
    'http_response' => array(
      'class' => 'Drupal\integration\Backend\Response\HttpRequestResponse',
    ),
    'memory_response' => array(
      'class' => 'Drupal\integration\Backend\Response\MemoryResponse',
    ),
  );
}
