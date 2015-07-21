<?php

/**
 * @file
 * Configuration object export.
 */

$export = new \stdClass();
$export->label = 'Local backend';
$export->name = 'local';
$export->status = TRUE;
$export->base = 'http://userProducer:pass@127.0.0.1:5984/integration-layer/_design/integration-layer/_rewrite/v1';
$export->endpoint = 'articles';
$export->notifications = 'changes/articles';
