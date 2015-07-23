<?php

/**
 * @file
 * Contains BackendConfiguration.
 */

namespace Drupal\nexteuropa_integration\Backend\Configuration;

use Drupal\nexteuropa_integration\Configuration\AbstractConfiguration;

/**
 * Class BackendConfiguration.
 *
 * @package Drupal\nexteuropa_integration\Backend
 */
class BackendConfiguration extends AbstractConfiguration {

  /**
   * Contains backend options.
   *
   * @var array
   *    Array of backend specific option.
   */
  public $options = array();

  /**
   * Get backend base path.
   *
   * @return string
   *     Backend base path.
   */
  public function getBasePath() {
    return $this->options['base_path'];
  }

  /**
   * Set backend base path.
   *
   * @param string $base_path
   *    Backend base path.
   */
  public function setBasePath($base_path) {
    $this->options['base_path'] = $base_path;
  }

  /**
   * Get backend endpoint.
   *
   * @return string
   *    Backend endpoint.
   */
  public function getEndpoint() {
    return $this->options['endpoint'];
  }

  /**
   * Set backend endpoint.
   *
   * @param string $endpoint
   *    Backend base path.
   */
  public function setEndpoint($endpoint) {
    $this->options['endpoint'] = $endpoint;
  }

}
