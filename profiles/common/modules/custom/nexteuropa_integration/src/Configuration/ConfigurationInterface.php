<?php

/**
 * @file
 * Contains ConfigurationInterface.
 */

namespace Drupal\nexteuropa_integration\Configuration;

/**
 * Interface ConfigurationInterface.
 *
 * @package Drupal\nexteuropa_integration\Configuration
 */
interface ConfigurationInterface {

  /**
   * Get configuration human readable name.
   *
   * @return string
   *    Configuration name.
   */
  public function getName();

  /**
   * Get configuration machine name.
   *
   * @return string
   *    Configuration machine name.
   */
  public function getMachineName();

  /**
   * Return a flag indicating whether the backend is enabled.
   *
   * @return int
   *    Flag indicating whether the backend is enabled.
   */
  public function getEnabled();

  /**
   * Return the exportable status of the backend.
   *
   * @return string
   *    Exportable status of the backend.
   *
   * @see nexteuropa_integration_configuration_status_options_list()
   */
  public function getStatus();

  /**
   * Check whether the configuration is marked as "Fixed".
   *
   * @return bool
   *    TRUE if condition is met, FALSE otherwise.
   */
  public function isCustom();

  /**
   * Check whether the configuration is marked as "Fixed".
   *
   * @return bool
   *    TRUE if condition is met, FALSE otherwise.
   */
  public function isInCode();

  /**
   * Check whether the configuration is marked as "Fixed".
   *
   * @return bool
   *    TRUE if condition is met, FALSE otherwise.
   */
  public function isOverridden();

  /**
   * Check whether the configuration is marked as "Fixed".
   *
   * @return bool
   *    TRUE if condition is met, FALSE otherwise.
   */
  public function isFixed();

  /**
   * Return value of an entity key value.
   *
   * @param string $name
   *    Entity key name.
   *
   * @return mixed|bool
   *    Entity key value if set, FALSE otherwise.
   *
   * @see entity_get_info()
   */
  public function getEntityKey($name);

}
