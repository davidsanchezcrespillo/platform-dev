<?php

/**
 * @file
 * Configuration object export.
 */

$export = new \stdClass();
$export->label = 'Integration test consumer';
$export->name = 'integration_test';
$export->status = TRUE;
$export->backend = 'memory_backend';
$export->entity_type = 'node';
$export->bundle = 'integration_test';
$export->mapping = array(
  'title' => 'title_field',
  'body' => 'body',
  'field_integration_test_images' => 'field_integration_test_images_path',
);
$export->options = array();
