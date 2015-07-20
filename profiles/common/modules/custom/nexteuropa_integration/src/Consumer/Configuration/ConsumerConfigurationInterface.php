<?php

/**
 * @file
 * Contains ConsumerConfigurationInterface.
 */

namespace Drupal\nexteuropa_integration\Consumer\Configuration;

/**
 * Interface ConsumerInterface.
 *
 * @package Drupal\nexteuropa_integration\Consumer
 */
interface ConsumerConfigurationInterface {

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
  public static function getInstance(\stdClass $settings);

  /**
   * Get configuration label.
   *
   * @return string
   *    Configuration label.
   */
  public function getLabel();

  /**
   * Set configuration label.
   *
   * @param string $label
   *    Configuration label.
   */
  public function setLabel($label);

  /**
   * Get configuration status.
   *
   * @return string
   *    Configuration status.
   */
  public function getStatus();

  /**
   * Set configuration status.
   *
   * @param string $status
   *    Configuration status.
   */
  public function setStatus($status);

  /**
   * Get configuration name.
   *
   * @return string
   *    Configuration name.
   */
  public function getName();

  /**
   * Set configuration name.
   *
   * @param string $name
   *    Configuration name.
   */
  public function setName($name);

  /**
   * Set backend name.
   *
   * @return string
   *    Backend name.
   */
  public function getBackend();

  /**
   * Set backend name.
   *
   * @param string $backend
   *    Backend name.
   */
  public function setBackend($backend);

  /**
   * Get entity type.
   *
   * @return string
   *    Entity type.
   */
  public function getEntityType();

  /**
   * Set entity type.
   *
   * @param string $entity_type
   *    Entity type.
   */
  public function setEntityType($entity_type);

  /**
   * Get entity bundle.
   *
   * @return string
   *    Entity bundle.
   */
  public function getBundle();

  /**
   * Set entity bundle.
   *
   * @param string $bundle
   *    Entity bundle.
   */
  public function setBundle($bundle);

  /**
   * Get field mapping.
   *
   * @return array
   *    Field mapping.
   */
  public function getMapping();

  /**
   * Set field mapping.
   *
   * @param array $mapping
   *    Field mapping.
   */
  public function setMapping(array $mapping);

  /**
   * Get consumer specific options.
   *
   * @return array
   *    Consumer specific options.
   */
  public function getOptions();

  /**
   * Set consumer specific options.
   *
   * @param array $options
   *    Consumer specific options.
   */
  public function setOptions(array $options);

  /**
   * Validate consistency of settings array.
   *
   * @param object $settings
   *    Setting array.
   *
   * @return bool
   *    TRUE if valid, FALSE otherwise.
   */
  static public function validate($settings);

  /**
   * Returns validation errors, if any.
   *
   * @return array
   *    Validation errors array.
   */
  static public function getErrors();

}
