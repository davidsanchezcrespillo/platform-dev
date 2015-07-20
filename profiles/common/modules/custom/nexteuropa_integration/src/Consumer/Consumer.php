<?php

/**
 * @file
 * Contains Drupal\nexteuropa_integration\Consumer\Consumer.
 */

namespace Drupal\nexteuropa_integration\Consumer;

use Drupal\nexteuropa_integration\Backend\BackendInterface;
use Drupal\nexteuropa_integration\Consumer\Configuration\ConsumerConfiguration;
use Drupal\nexteuropa_integration\Consumer\Configuration\ConsumerConfigurationInterface;
use Drupal\nexteuropa_integration\Consumer\Migrate\AbstractMigration;
use Drupal\nexteuropa_integration\Document\DocumentInterface;

/**
 * Interface ConsumerInterface.
 *
 * @package Drupal\nexteuropa_integration\Consumer
 */
class Consumer extends AbstractMigration implements ConsumerInterface {

  /**
   * Configuration object.
   *
   * @var ConsumerConfiguration
   */
  private $configuration;

  /**
   * Document object.
   *
   * @var DocumentInterface
   */
  private $document;

  /**
   * Backend object.
   *
   * @var BackendInterface
   */
  private $backend;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $arguments) {

    // Will throw exceptions if arguments are not valid.
    $this->validateArguments($arguments);

    $configuration_class = $arguments['consumer']['class'];
    $configuration = $configuration_class::getInstance($arguments['consumer']['settings']);
    $this->setConfiguration($configuration);

    parent::__construct($arguments);
  }

  /**
   * {@inheritdoc}
   */
  public function getSourceKey() {
    return array(
      '_id' => array(
        'type' => 'varchar',
        'length' => 255,
        'not null' => TRUE,
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getConfiguration() {
    return $this->configuration;
  }

  /**
   * {@inheritdoc}
   */
  public function setConfiguration(ConsumerConfigurationInterface $configuration) {
    $this->configuration = $configuration;
  }

  /**
   * {@inheritdoc}
   */
  public function getDocument() {
    return $this->document;
  }

  /**
   * {@inheritdoc}
   */
  public function setDocument(DocumentInterface $document) {
    $this->document = $document;
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
  public function setBackend(BackendInterface $backend) {
    $this->backend = $backend;
  }

  /**
   * {@inheritdoc}
   */
  private function validateArguments($arguments) {
    // Pass class dependencies via the $arguments array.
    // Since the Consumer class is built via Migration::registerMigration()
    // this is the only way we can implement some form of dependency injection.
    if (!isset($arguments['consumer'])) {
      throw new \InvalidArgumentException('Argument "consumer" is missing');
    }
    if (!isset($arguments['consumer']['class'])) {
      throw new \InvalidArgumentException('Sub-argument "consumer" class is missing.');
    }
    else {
      $reflection = new \ReflectionClass($arguments['consumer']['class']);
      if (!$reflection->implementsInterface('Drupal\nexteuropa_integration\Consumer\Configuration\ConsumerConfigurationInterface')) {
        throw new \InvalidArgumentException('Sub-argument "consumer" class must implement Drupal\nexteuropa_integration\Consumer\Configuration\ConsumerConfigurationInterface');
      }
    }
    if (!isset($arguments['consumer']['settings'])) {
      throw new \InvalidArgumentException('Sub-argument "consumer" settings is missing.');
    }
    elseif (!ConsumerConfiguration::validate($arguments['consumer']['settings'])) {
      throw new \InvalidArgumentException('Sub-argument "consumer" settings does not validate.');
    }
  }

}
