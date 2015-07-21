<?php

/**
 * @file
 * Configuration object export.
 */

$export = new \stdClass();
$export->label = 'Articles consumer';
$export->name = 'articles';
$export->status = TRUE;
$export->backend = 'rest_backend';
$export->entity_type = 'node';
$export->bundle = 'article';
$export->mapping = array(
  'title' => 'title',
  'body' => 'body',
);
$export->options = array();
