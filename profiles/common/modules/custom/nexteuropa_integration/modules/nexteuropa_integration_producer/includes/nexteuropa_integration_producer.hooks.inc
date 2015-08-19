<?php

/**
 * @file
 * Contains producer-related hook implementations.
 */

/**
 * Implements hook_integration_producer_info().
 */
function integration_producer_integration_producer_info() {
  return array(
    'node' => array(
      'class' => 'Drupal\integration\Producer\NodeProducer',
    ),
    'taxonomy_term' => array(
      'class' => 'Drupal\integration\Producer\TaxonomyTermProducer',
    ),
  );
}

/**
 * Implements hook_integration_producer_field_handler_info().
 */
function integration_producer_integration_producer_field_handler_info() {
  return array(
    'default' => array(
      'class' => 'Drupal\integration\Producer\FieldHandlers\DefaultFieldHandler',
    ),
    'text' => array(
      'class' => 'Drupal\integration\Producer\FieldHandlers\TextFieldHandler',
    ),
    'text_long' => array(
      'class' => 'Drupal\integration\Producer\FieldHandlers\TextFieldHandler',
    ),
    'text_with_summary' => array(
      'class' => 'Drupal\integration\Producer\FieldHandlers\TextWithSummaryFieldHandler',
    ),
    'date' => array(
      'class' => 'Drupal\integration\Producer\FieldHandlers\DateFieldHandler',
    ),
    'datetime' => array(
      'class' => 'Drupal\integration\Producer\FieldHandlers\DateFieldHandler',
    ),
    'datestamp' => array(
      'class' => 'Drupal\integration\Producer\FieldHandlers\DateFieldHandler',
    ),
    'file' => array(
      'class' => 'Drupal\integration\Producer\FieldHandlers\FileFieldHandler',
    ),
    'image' => array(
      'class' => 'Drupal\integration\Producer\FieldHandlers\ImageFieldHandler',
    ),
  );
}
