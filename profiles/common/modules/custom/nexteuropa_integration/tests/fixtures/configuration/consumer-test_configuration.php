<?php

/**
 * @file
 * Configuration object export.
 */

$export = new \stdClass();
$export->name = 'Test configuration';
$export->machine_name = 'test_configuration';
$export->description = 'Test configuration description.';
$export->backend = 'test_configuration';
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
$export->enabled = 1;
$export->status = 1;
$export->module = 'nexteuropa_integration_test';
