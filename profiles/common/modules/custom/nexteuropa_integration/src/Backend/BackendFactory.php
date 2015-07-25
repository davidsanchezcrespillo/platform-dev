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
   * Instantiate and return a backend object given its configuration.
   *
   * @param string $configuration_name
   *    Backend configuration machine name.
   *
   * @return AbstractBackend
   *    Backend instance.
   */
  static public function getInstance($configuration_name) {
    // @todo invoke hook and get which response and formatters are associated.
    return NULL;
  }

}
