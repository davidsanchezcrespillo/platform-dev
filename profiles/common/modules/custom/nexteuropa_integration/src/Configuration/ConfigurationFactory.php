<?php

/**
 * @file
 * Contains ConfigurationFactory.
 */

namespace Drupal\nexteuropa_integration\Configuration;

use Drupal\nexteuropa_integration\Configuration\AbstractConfiguration;

/**
 * Interface ConfigurationFactory.
 *
 * @package Drupal\nexteuropa_integration\Configuration
 */
class ConfigurationFactory {

  /**
   * Load configuration.
   *
   * Simply wraps entity_load_single() so we can mock entity loading in tests.
   *
   * @param string $type
   *    Configuration entity type.
   * @param string $machine_name
   *    Configuration entity machine name.
   *
   * @return AbstractConfiguration
   *    Loaded configuration entity.
   */
  public static function load($type, $machine_name) {
    return entity_load_single($type, $machine_name);
  }

}
