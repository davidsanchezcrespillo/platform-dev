<?php

/**
 * @file
 * Contains AbstractComponentConfiguration.
 */

namespace Drupal\integration\Configuration;

/**
 * Class AbstractComponentConfiguration.
 *
 * @package Drupal\integration\Configuration
 */
abstract class AbstractComponentConfiguration implements ComponentConfigurationInterface, FormInterface {

  /**
   * Plugin configuration object this component belongs to.
   *
   * @var AbstractConfiguration
   */
  protected $configuration;

  /**
   * Component configuration options.
   *
   * @var array
   */
  protected $options;

  /**
   * Constructor.
   *
   * @param AbstractConfiguration $configuration
   *    Plugin configuration object this component belongs to.
   * @param array $options
   *    Component configuration options.
   */
  public function __construct(AbstractConfiguration $configuration, array $options = array()) {
    $this->configuration = $configuration;
    $this->options = $options;
  }

  /**
   * {@inheritdoc}
   */
  public function getOption($name) {
    return isset($this->options[$name]) ? $this->options[$name] : '';
  }

  /**
   * {@inheritdoc}
   */
  public function setOption($name, $value) {
    $this->options[$name] = $value;
  }

  /**
   * {@inheritdoc}
   */
  public function formSubmit(array $form, array &$form_state) {

  }

  /**
   * {@inheritdoc}
   */
  public function formValidate(array $form, array &$form_state) {

  }

}
