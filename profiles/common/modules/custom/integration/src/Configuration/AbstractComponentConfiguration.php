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
   * Constructor.
   *
   * @param AbstractConfiguration $configuration
   *    Plugin configuration object this component belongs to.
   */
  public function __construct(AbstractConfiguration $configuration) {
    $this->configuration = $configuration;
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
