<?php

/**
 * @file
 * Contains EntityWrapper.
 */

namespace Drupal\nexteuropa_integration\Producer\EntityWrapper;

/**
 * Interface EntityWrapperInterface.
 *
 * @package Drupal\nexteuropa_integration\Producer\EntityWrapper
 */
interface EntityWrapperInterface {

  /**
   * Return list of all entity's properties.
   *
   * @return array[string]
   *    Array of property names.
   */
  public function getPropertyList();

  /**
   * Return list of all entity's fields.
   *
   * @return array[string]
   *    Array of field names.
   */
  public function getFieldList();

}
