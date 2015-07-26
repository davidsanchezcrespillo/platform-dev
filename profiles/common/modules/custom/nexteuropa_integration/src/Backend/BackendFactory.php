<?php

/**
 * @file
 * Contains BackendFactory.
 */

namespace Drupal\nexteuropa_integration\Backend;

use Drupal\nexteuropa_integration\Backend\AbstractBackend;
use Drupal\nexteuropa_integration\Configuration\ConfigurationFactory;
use Drupal\nexteuropa_integration\Configuration\AbstractConfiguration;
use Drupal\nexteuropa_integration\Backend\Configuration\BackendConfiguration;

/**
 * Interface BackendFactory.
 *
 * @package Drupal\nexteuropa_integration\Backend
 */
class BackendFactory {

  /**
   * Instantiate and return a backend object given its configuration.
   *
   * @param string $machine_name
   *    Backend configuration machine name.
   *
   * @return AbstractBackend
   *    Backend instance.
   */
  static public function getInstance($machine_name) {
    /** @var BackendConfiguration $configuration */
    $configuration = self::loadConfiguration($machine_name);

    $backend_info = nexteuropa_integration_backend_get_backend_info();
    $response_info = nexteuropa_integration_backend_get_response_handler_info();
    $formatter_info = nexteuropa_integration_backend_get_formatter_handler_info();

    // @todo: Throw exceptions if necessary.
    $backend_class = $backend_info[$configuration->getType()]['class'];
    $response_class = $response_info[$configuration->getResponse()]['class'];
    $formatter_class = $formatter_info[$configuration->getFormatter()]['class'];

    return new $backend_class($configuration, new $response_class(), new $formatter_class());
  }

  /**
   * Load configuration from database.
   *
   * @param string $machine_name
   *    Backend configuration machine name.
   *
   * @return AbstractConfiguration
   *    Configuration object.
   */
  static public function loadConfiguration($machine_name) {
    return ConfigurationFactory::load('integration_backend', $machine_name);
  }

}
