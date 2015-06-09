<?php
/**
 * @file
 * ecas_wrapper.features.inc
 */

/**
 * Implements hook_ctools_plugin_api().
 */
function ecas_wrapper_ctools_plugin_api($module = NULL, $api = NULL) {
  if ($module == "strongarm" && $api == "strongarm") {
    return array("version" => "1");
  }
}
