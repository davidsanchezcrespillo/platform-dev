<?php

/**
 * @file
 * Configuration object export.
 */

$export = new \stdClass();
$export->name = 'Test configuration';
$export->machine_name = 'test_configuration';
$export->description = 'Test configuration description.';
$export->type = 'memory_backend';
$export->module = 'nexteuropa_integration';
$export->options = array(
  'base_path' => 'http://example.com',
  'endpoint' => 'articles',
);
