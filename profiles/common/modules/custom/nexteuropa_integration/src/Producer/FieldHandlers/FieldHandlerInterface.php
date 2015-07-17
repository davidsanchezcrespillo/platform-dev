<?php

/**
 * @file
 * Contains FieldHandlers.
 */

namespace Drupal\nexteuropa_integration\Producer\FieldHandlers;

/**
 * Interface FieldHandlerInterface.
 *
 * @package Drupal\nexteuropa_integration\Producer\FieldHandlers
 */
interface FieldHandlerInterface {

  /**
   * Get field value.
   *
   * @return mixed
   *    Get field values.
   */
  public function getValues();

}
