<?php

/**
 * @file
 * Contains producer-related hook implementations.
 */

/**
 * Implements hook_integration_consumer_mapping_handler_info().
 */
function integration_consumer_integration_consumer_mapping_handler_info() {
  return array(
    'title_mapping' => array(
      'class' => 'Drupal\integration\Consumer\MappingHandler\TitleMappingHandler',
    ),
    'file_field_mapping' => array(
      'class' => 'Drupal\integration\Consumer\MappingHandler\FileFieldMappingHandler',
    ),
    'text_with_summary_mapping' => array(
      'class' => 'Drupal\integration\Consumer\MappingHandler\TextWithSummaryMappingHandler',
    ),
  );
}
