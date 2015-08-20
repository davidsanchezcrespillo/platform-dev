<?php

/**
 * @file
 * Contains \Drupal\integration\PluginManager
 */

namespace Drupal\integration;

/**
 * Class PluginManager.
 *
 * @package Drupal\integration
 */
class PluginManager {

  /**
   * List of available plugins, along with their components.
   *
   * @var array
   */
  private $plugins = array(
    'backend' => array(
      'components' => array('response_handler', 'formatter_handler'),
    ),
    'consumer' => array(
      'components' => array('mapping_handler'),
    ),
    'producer' => array(
      'components' => array('field_handler'),
    ),
  );

  /**
   * Current plugin identifier.
   *
   * @var string
   */
  private $plugin;

  /**
   * Current component identifier.
   *
   * @var string
   */
  private $component = NULL;

  /**
   * Get plugin manager instance.
   *
   * @param string $plugin
   *    Plugin type, as defined in self::$plugins array's keys.
   *
   * @return PluginManager
   *    PluginManager instance for specified plugin type.
   */
  static function getInstance($plugin) {
    return new self($plugin);
  }

  /**
   * PluginManager constructor.
   *
   * @param array $plugin
   *    Plugin identifier.
   */
  public function __construct($plugin) {
    $this->plugin = $plugin;
  }

  /**
   * Set current plugin component
   *
   * @param string $component
   *    Set current plugin component identifier.
   *
   * @return $this
   */
  public function setComponent($component) {
    $this->component = $component;
    return $this;
  }

  /**
   * Return list of current plugin components.
   *
   * @return array
   *    List of current plugin components.
   */
  public function getComponents() {
    return $this->plugins[$this->plugin]['components'];
  }

  /**
   * Get result of info hook for current plugin and component identifier.
   *
   * @return array
   *    Array of information about current plugin and component identifier.
   */
  public function getInfo() {
    $function_name = $this->buildInfoGetterName();
    return $function_name();
  }

  /**
   * Get current plugin label.
   *
   * @return string
   *    Current plugin label.
   */
  public function getLabel() {
    $info = $this->getInfo();
    $identifier = $this->getCurrentIdentifier();
    return $info[$identifier]['label'];
  }

  /**
   * Get current plugin class.
   *
   * @return string
   *    Current plugin class.
   */
  public function getClass() {
    $info = $this->getInfo();
    $identifier = $this->getCurrentIdentifier();
    return $info[$identifier]['class'];
  }

  /**
   * Get current plugin description.
   *
   * @return string
   *    Current plugin description.
   */
  public function getDescription() {
    $info = $this->getInfo();
    $identifier = $this->getCurrentIdentifier();
    return $info[$identifier]['description'];
  }

  /**
   * @return string
   */
  private function getCurrentIdentifier() {
    return isset($this->component) ? $this->component : $this->plugin;
  }

  /**
   * Build info getter name give current plugin and component identifier.
   *
   * @return string
   *    Full info getter name.
   */
  private function buildInfoGetterName() {
    $parts = array('integration', $this->plugin, 'get');
    if ($this->component) {
      $parts[] = $this->component;
    }
    $parts[] = 'info';
    return implode('_', $parts);
  }

}
