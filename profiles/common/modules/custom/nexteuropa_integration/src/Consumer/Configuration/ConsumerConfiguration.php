<?php

/**
 * @file
 * Contains ConsumerConfiguration.
 */

namespace Drupal\nexteuropa_integration\Consumer\Configuration;

use Drupal\nexteuropa_integration\Configuration\AbstractConfiguration;

/**
 * Class ConsumerConfiguration.
 *
 * @package Drupal\nexteuropa_integration\Consumer
 */
class ConsumerConfiguration extends AbstractConfiguration {

  /**
   * Contains consumer options.
   *
   * @var array
   *    Array of backend specific option.
   */
  public $options = array();

  /**
   * Return consumer field mapping.
   *
   * @return array
   *    Field mapping.
   */
  public function getMapping() {
    return $this->options['mapping'];
  }

}
