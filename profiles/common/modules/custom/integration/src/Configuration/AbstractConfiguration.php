<?php

/**
 * @file
 * Contains ConsumerConfiguration.
 */

namespace Drupal\integration\Configuration;

/**
 * Class AbstractConfiguration.
 *
 * @package Drupal\integration\Configuration
 */
abstract class AbstractConfiguration extends \Entity implements ConfigurationInterface, FormInterface {

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
   * @see integration_configuration_status_options_list()
   */
  public $status;

  /**
   * Configuration entity options.
   *
   * @var array
   */
  public $options = array();

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
    return isset($this->enabled) ? $this->enabled : FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function getStatus() {
    return isset($this->status) ? $this->status : ENTITY_CUSTOM;
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

  /**
   * {@inheritdoc}
   */
  public function getOption($name) {
    return isset($this->options[$name]) ? $this->options[$name] : NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function setOption($name, $value) {
    return $this->options[$name] = $value;
  }

  /**
   * {@inheritdoc}
   */
  public function form(array &$form, array &$form_state, $op) {

    $form['name'] = array(
      '#title' => t('Name'),
      '#type' => 'textfield',
      '#default_value' => ($op == 'clone') ? $this->getName() . ' clone' : $this->getName(),
      '#required' => TRUE,
    );
    $form['machine_name'] = array(
      '#type' => 'machine_name',
      '#default_value' => $this->getMachineName(),
      '#disabled' => $this->getEnabled(),
      '#machine_name' => array(
        'exists' => 'integration_load_backend',
        'source' => array('name'),
      ),
      '#description' => t('A unique machine-readable name for this configuration object. It must only contain lowercase letters, numbers, and underscores.'),
      '#required' => TRUE,
    );
    $form['enabled'] = array(
      '#title' => t('Enabled'),
      '#type' => 'checkbox',
      '#default_value' => ($op == 'add') ? TRUE : $this->getEnabled(),
    );
    $form['status'] = array(
      '#value' => ($op == 'add') ? ENTITY_CUSTOM : $this->getStatus(),
    );
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
