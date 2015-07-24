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

}
