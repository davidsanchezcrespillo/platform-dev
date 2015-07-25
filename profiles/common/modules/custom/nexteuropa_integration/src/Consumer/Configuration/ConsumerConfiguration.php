<?php

/**
 * @file
 * Contains ConsumerConfiguration.
 */

namespace Drupal\nexteuropa_integration\Consumer\Configuration;

use Drupal\nexteuropa_integration\Backend\Configuration\BackendConfiguration;
use Drupal\nexteuropa_integration\Configuration\AbstractConfiguration;
use Drupal\nexteuropa_integration\Configuration\ConfigurationFactory;

/**
 * Class ConsumerConfiguration.
 *
 * @package Drupal\nexteuropa_integration\Consumer
 */
class ConsumerConfiguration extends AbstractConfiguration {

  /**
   * Backend machine name associated to current consumer configuration.
   *
   * @var string
   *    Backend machine name.
   */
  public $backend = '';

  /**
   * Contains consumer field mapping.
   *
   * @var array
   *    Array of consumer field mapping.
   */
  public $mapping = array();

  /**
   * Contains consumer options.
   *
   * @var array
   *    Array of consumer specific option.
   */
  public $options = array();

  /**
   * Return backend configuration machine name.
   *
   * @return string
   *    Backend configuration machine name.
   */
  public function getBackend() {
    return $this->backend;
  }

  /**
   * Return wrapped backend configuration entity.
   *
   * @return BackendConfiguration
   *    Backend configuration entity.
   */
  public function getBackendConfiguration() {
    return ConfigurationFactory::load('integration_backend', $this->backend);
  }

  /**
   * Return consumer field mapping.
   *
   * @return array
   *    Field mapping.
   */
  public function getMapping() {
    return $this->mapping;
  }

  /**
   * Return destination field given source field.
   *
   * @param $destination_field
   *    Destination field.
   *
   * @return null
   *    Source field mapped to the destination field if any, NULL otherwise.
   */
  public function getMappingSource($destination_field) {
    return isset($this->mapping[$destination_field]) ? $this->mapping[$destination_field] : NULL;
  }

  /**
   * Return source field given destination field.
   *
   * @param $source_field
   *    Source field.
   *
   * @return null
   *    Destination field mapped to the source field if any, NULL otherwise.
   */
  public function getMappingDestination($source_field) {
    $mapping = array_flip($this->mapping);
    return isset($mapping[$source_field]) ? $mapping[$source_field] : NULL;
  }

}
