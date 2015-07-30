<?php

/**
 * @file
 * Contains producer-related hook implementations.
 */

/**
 * Implements hook_nexteuropa_integration_consumer_mapping_handler_info().
 */
function nexteuropa_integration_consumer_nexteuropa_integration_consumer_mapping_handler_info() {
  return array(
    'title_mapping' => array(
      'class' => 'Drupal\nexteuropa_integration\Consumer\MappingHandler\TitleMappingHandler',
    ),
    'file_field_mapping' => array(
      'class' => 'Drupal\nexteuropa_integration\Consumer\MappingHandler\FileFieldMappingHandler',
    ),
    'text_with_summary_mapping' => array(
      'class' => 'Drupal\nexteuropa_integration\Consumer\MappingHandler\TextWithSummaryMappingHandler',
    ),
  );
}


