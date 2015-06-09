<?php
/**
 * @file
 * ecas_wrapper.strongarm.inc
 */

/**
 * Implements hook_strongarm().
 */
function ecas_wrapper_strongarm() {
  $export = array();

  $strongarm = new stdClass();
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'cas_port';
  $strongarm->value = '7002';
  $export['cas_port'] = $strongarm;

  $strongarm = new stdClass();
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'cas_server';
  $strongarm->value = 'ecas.cc.cec.eu.int';
  $export['cas_server'] = $strongarm;

  $strongarm = new stdClass();
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'cas_service_validate_url';
  $strongarm->value = 'https://ecas.cc.cec.eu.int:7002/cas/serviceValidate?userDetails=true&groups=*';
  $export['cas_service_validate_url'] = $strongarm;

  $strongarm = new stdClass();
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'cas_uri';
  $strongarm->value = 'cas';
  $export['cas_uri'] = $strongarm;

  return $export;
}
