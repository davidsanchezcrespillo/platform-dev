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
   * Contains list of validation errors.
   *
   * @var array
   */
  static private $validationErrors = array();

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
   * {@inheritdoc}
   */
  public function getLabel() {
    return $this->label;
  }

  /**
   * {@inheritdoc}
   */
  public function setLabel($label) {
    $this->label = $label;
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
  public function setStatus($status) {
    $this->status = $status;
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->name;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->name = $name;
  }

  /**
   * {@inheritdoc}
   */
  public function getBackend() {
    return $this->backend;
  }

  /**
   * {@inheritdoc}
   */
  public function setBackend($backend) {
    $this->backend = $backend;
  }

  /**
   * {@inheritdoc}
   */
  public function getEntityType() {
    return $this->entityType;
  }

  /**
   * {@inheritdoc}
   */
  public function setEntityType($entity_type) {
    $this->entityType = $entity_type;
  }

  /**
   * {@inheritdoc}
   */
  public function getBundle() {
    return $this->bundle;
  }

  /**
   * {@inheritdoc}
   */
  public function setBundle($bundle) {
    $this->bundle = $bundle;
  }

  /**
   * {@inheritdoc}
   */
  public function getMapping() {
    return $this->mapping;
  }

  /**
   * {@inheritdoc}
   */
  public function setMapping(array $mapping) {
    $this->mapping = $mapping;
  }

  /**
   * {@inheritdoc}
   */
  public function getOptions() {
    return $this->options;
  }

  /**
   * {@inheritdoc}
   */
  public function setOptions(array $options) {
    $this->options = $options;
  }

  /**
   * {@inheritdoc}
   */
  static public function validate($settings) {
    $required = array(
      'label',
      'name',
      'entity_type',
      'backend',
      'bundle',
      'status',
      'mapping',
      'options',
    );
    foreach ($required as $key) {
      if (!isset($settings->{$key})) {
        self::$validationErrors[] = "Configuration property {$key} is missing.";
      }
      if (!in_array($key, array('options', 'mapping')) && empty($settings->{$key})) {
        self::$validationErrors[] = "Configuration property {$key} is missing.";
      }
    }
    return empty(self::$validationErrors);
  }

  /**
   * {@inheritdoc}
   */
  static public function getErrors() {
    return self::$validationErrors;
  }

  /**
   * {@inheritdoc}
   */
  public static function getInstance(\stdClass $settings) {

    if (!self::validate($settings)) {
      throw new \InvalidArgumentException(implode(' ', self::getErrors()));
    }

    $instance = new self($settings->label, $settings->name, $settings->entity_type, $settings->bundle);
    $instance->setStatus($settings->status);
    $instance->setBackend($settings->backend);
    $instance->setMapping($settings->mapping);
    $instance->setOptions($settings->options);
    return $instance;
  }

}
