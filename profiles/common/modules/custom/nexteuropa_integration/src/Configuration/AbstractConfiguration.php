<?php

/**
 * @file
 * Contains ConsumerConfiguration.
 */

namespace Drupal\nexteuropa_integration\Configuration;

/**
 * Class AbstractConfiguration.
 *
 * @package Drupal\nexteuropa_integration\Configuration
 */
abstract class AbstractConfiguration extends \Entity implements ConfigurationInterface {

  /**
   * Configuration human readable name.
   *
   * @var string
   */
  public $name;

  /**
   * Weather the configuration is enabled or not.
   *
   * @var bool
   */
  public $enabled;

  /**
   * Configuration export status.
   *
   * @var string
   *
   * @see nexteuropa_integration_configuration_status_options_list()
   */
  public $status;


  /**
   * {@inheritdoc}
   */
  public function getName() {
    return isset($this->name) ? $this->name : '';
  }

  /**
   * {@inheritdoc}
   */
  public function getMachineName() {
    return isset($this->machine_name) ? $this->machine_name : '';
  }

  /**
   * {@inheritdoc}
   */
  public function getEnabled() {
    $this->enabled;
  }

  /**
   * {@inheritdoc}
   */
  public function getStatus() {
    return $this->status;
  }

  /**
   * {@inheritdoc}
   */
  public function isCustom() {
    return $this->getStatus() == ENTITY_CUSTOM;
  }

  /**
   * {@inheritdoc}
   */
  public function isInCode() {
    return $this->getStatus() == ENTITY_IN_CODE;
  }

  /**
   * {@inheritdoc}
   */
  public function isOverridden() {
    return $this->getStatus() == ENTITY_OVERRIDDEN;
  }

  /**
   * {@inheritdoc}
   */
  public function isFixed() {
    return $this->getStatus() == ENTITY_FIXED;
  }

  /**
   * {@inheritdoc}
   */
  public function getEntityKey($name) {
    return isset($this->entityInfo['entity keys'][$name]) ? $this->entityInfo['entity keys'][$name] : FALSE;
  }

}
