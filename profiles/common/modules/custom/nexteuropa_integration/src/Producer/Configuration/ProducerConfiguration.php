<?php

/**
 * @file
 * Contains ProducerConfiguration.
 */

namespace Drupal\nexteuropa_integration\Producer\Configuration;

use Drupal\nexteuropa_integration\Configuration\AbstractConfiguration;

/**
 * Class ProducerConfiguration.
 *
 * @package Drupal\nexteuropa_integration\Producer
 */
class ProducerConfiguration extends AbstractConfiguration {

  /**
   * Contains consumer options.
   *
   * @var array
   *    Array of backend specific option.
   */
  public $options = array();

  /**
   * Get producer ID setting parameter.
   *
   * @return string
   *    Producer ID.
   */
  public function getProducerId() {
    return $this->producer_id;
  }

  /**
   * Get producer entity type setting parameter.
   *
   * @return string
   *    Entity type.
   */
  public function getType() {
    return $this->type;
  }

  /**
   * Get option value given its name.
   *
   * @param string $name
   *    Option name.
   *
   * @return string
   *    Option value.
   */
  public function getOptionValue($name) {
    return isset($this->options[$name]) ? $this->options[$name] : '';
  }

}
