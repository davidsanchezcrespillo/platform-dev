<?php

/**
 * @file
 * Contains ConfigurableInterface.
 */

namespace Drupal\nexteuropa_integration\Configuration;

/**
 * Interface ConfigurableInterface.
 *
 * @package Drupal\nexteuropa_integration\Configuration
 */
interface ConfigurableInterface {

  /**
   * Get configuration human readable name.
   *
   * @return string
   *    Configuration name.
   */
  public function setConfiguration(AbstractConfiguration $configuration);

  /**
   * Get configuration human readable name.
   *
   * @return string
   *    Configuration name.
   */
  public function getConfiguration();

}
