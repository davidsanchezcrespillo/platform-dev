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
$export->response = 'memory_response';
$export->formatter = 'json_formatter';
$export->module = 'nexteuropa_integration';
$export->options = array(
  'base_path' => 'http://example.com',
  'endpoint' => 'articles',
);
$export->enabled = 1;
$export->status = 1;
$export->module = 'nexteuropa_integration_test';
