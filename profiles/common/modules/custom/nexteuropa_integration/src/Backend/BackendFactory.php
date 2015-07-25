<?php

/**
 * @file
 * Contains BackendFactory.
 */

namespace Drupal\nexteuropa_integration\Backend;

use Drupal\nexteuropa_integration\Backend\AbstractBackend;

/**
 * Interface BackendFactory.
 *
 * @package Drupal\nexteuropa_integration\Backend
 */
class BackendFactory {

  /**
   * @param $configuration_name
   *
   * @return AbstractBackend
   */
  static public function getInstance($configuration_name) {
    // @todo invoke hook and get which response and formatters are associated.
    return null;
  }

}
