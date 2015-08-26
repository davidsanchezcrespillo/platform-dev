<?php

/**
 * @file
 * Contains ComponentConfigurationInterface.
 */

namespace Drupal\integration\Configuration;

/**
 * Interface ComponentConfigurationInterface.
 *
 * @package Drupal\integration\Configuration
 */
interface ComponentConfigurationInterface {

  /**
   * Get value of a component configuration option.
   *
   * @param string $name
   *    Component configuration option name.
   *
   * @return string
   *    Component configuration option value.
   */
  public function getOption($name);

  /**
   * Get value of a component configuration option.
   *
   * @param string $name
   *    Component configuration option name.
   * @param string $value
   *    Component configuration option value.
   */
  public function setOption($name, $value);

}
