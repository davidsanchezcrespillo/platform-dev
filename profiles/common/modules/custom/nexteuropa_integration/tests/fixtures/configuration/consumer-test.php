<?php

/**
 * @file
 * Configuration object export.
 */

$export = new \stdClass();
$export->label = 'Label';
$export->name = 'test';
$export->status = TRUE;
$export->backend = 'backend';
$export->entity_type = 'node';
$export->bundle = 'article';
$export->mapping = array(
  'title' => 'source_title',
  'body' => 'source_body',
  'field_integration_test_images' => 'source_image',
  'field_integration_test_files' => 'source_files',
  'field_integration_test_ref' => 'source_reference',
  'field_integration_test_terms' => 'source_terms',
);
$export->options = array(
  'option1' => 'value1',
  'option2' => 'value2',
);
