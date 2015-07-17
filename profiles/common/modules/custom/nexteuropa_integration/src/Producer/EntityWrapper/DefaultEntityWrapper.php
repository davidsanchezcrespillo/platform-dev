<?php

/**
 * @file
 * Contains DefaultEntityWrapper.
 */

namespace Drupal\nexteuropa_integration\Producer\EntityWrapper;

/**
 * Class DefaultEntityWrapper.
 *
 * @package Drupal\nexteuropa_integration\Producer\EntityWrapper
 */
class DefaultEntityWrapper extends \EntityDrupalWrapper implements EntityWrapperInterface {

  /**
   * Return list of all entity's properties.
   *
   * @return array[string]
   *    Array of property names.
   */
  public function getPropertyList() {

    return array();
  }

  /**
   * Return list of all entity's fields.
   *
   * @return array[string]
   *    Array of field names.
   */
  public function getFieldList() {

    return array();
  }

}
