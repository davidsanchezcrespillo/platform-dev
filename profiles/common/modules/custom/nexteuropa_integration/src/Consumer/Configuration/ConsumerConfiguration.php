<?php

/**
 * @file
 * Contains ConsumerConfiguration.
 */

namespace Drupal\nexteuropa_integration\Consumer\Configuration;

/**
 * Class ConsumerConfiguration.
 *
 * @package Drupal\nexteuropa_integration\Consumer\Configuration
 */
class ConsumerConfiguration implements ConsumerConfigurationInterface {

  /**
   * Configuration label.
   *
   * @var string
   */
  private $label;

  /**
   * Configuration status.
   *
   * @var string
   */
  private $status;

  /**
   * Configuration name.
   *
   * @var string
   */
  private $name;

  /**
   * Backend name.
   *
   * @var string
   */
  private $backend;

  /**
   * Configuration entity type.
   *
   * @var string
   */
  private $entityType;

  /**
   * Configuration bundle.
   *
   * @var string
   */
  private $bundle;

  /**
   * Field mapping configuration.
   *
   * @var array[string]
   */
  private $mapping;

  /**
   * Other consumer-specific options.
   *
   * @var array[string]
   */
  private $options;

  /**
   * Constructor.
   *
   * @param string $label
   *    Configuration label.
   * @param string $name
   *    Configuration name.
   * @param string $entity_type
   *    Configuration entity type.
   * @param string $bundle
   *    Configuration bundle.
   */
  public function __construct($label, $name, $entity_type, $bundle) {

    $this->setLabel($label);
    $this->setName($name);
    $this->setEntityType($entity_type);
    $this->setBundle($bundle);
    $this->setStatus(TRUE);
    $this->setMapping(array());
    $this->setOptions(array());
  }

  /**
   * Static factory method: return an instance given a setting object.
   *
   * @param \stdClass $settings
   *    Consumer settings, as retrieved from settings table.
   *
   * @return ConsumerConfiguration
   *    Instance of ConsumerConfiguration object.
   *
   * @see nexteuropa_integration_schema()
   */
  public static function getInstance(\stdClass $settings) {
    return new self($settings->label, $settings->name, $settings->entity_type, $settings->bundle);
  }

  /**
   * Get configuration label.
   *
   * @return string
   *    Configuration label.
   */
  public function getLabel() {
    return $this->label;
  }

  /**
   * Set configuration label.
   *
   * @param string $label
   *    Configuration label.
   */
  public function setLabel($label) {
    $this->label = $label;
  }

  /**
   * Get configuration status.
   *
   * @return string
   *    Configuration status.
   */
  public function getStatus() {
    return $this->status;
  }

  /**
   * Set configuration status.
   *
   * @param string $status
   *    Configuration status.
   */
  public function setStatus($status) {
    $this->status = $status;
  }

  /**
   * Get configuration name.
   *
   * @return string
   *    Configuration name.
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Set configuration name.
   *
   * @param string $name
   *    Configuration name.
   */
  public function setName($name) {
    $this->name = $name;
  }

  /**
   * Set backend name.
   *
   * @return string
   *    Backend name.
   */
  public function getBackend() {
    return $this->backend;
  }

  /**
   * Set backend name.
   *
   * @param string $backend
   *    Backend name.
   */
  public function setBackend($backend) {
    $this->backend = $backend;
  }

  /**
   * Get entity type.
   *
   * @return string
   *    Entity type.
   */
  public function getEntityType() {
    return $this->entityType;
  }

  /**
   * Set entity type.
   *
   * @param string $entity_type
   *    Entity type.
   */
  public function setEntityType($entity_type) {
    $this->entityType = $entity_type;
  }

  /**
   * Get entity bundle.
   *
   * @return string
   *    Entity bundle.
   */
  public function getBundle() {
    return $this->bundle;
  }

  /**
   * Set entity bundle.
   *
   * @param string $bundle
   *    Entity bundle.
   */
  public function setBundle($bundle) {
    $this->bundle = $bundle;
  }

  /**
   * Get field mapping.
   *
   * @return array
   *    Field mapping.
   */
  public function getMapping() {
    return $this->mapping;
  }

  /**
   * Set field mapping.
   *
   * @param array $mapping
   *    Field mapping.
   */
  public function setMapping(array $mapping) {
    $this->mapping = $mapping;
  }

  /**
   * Get consumer specific options.
   *
   * @return array
   *    Consumer specific options.
   */
  public function getOptions() {
    return $this->options;
  }

  /**
   * Set consumer specific options.
   *
   * @param array $options
   *    Consumer specific options.
   */
  public function setOptions(array $options) {
    $this->options = $options;
  }

}
