<?php

/**
 * @file
 * Contains ProducerFactory.
 */

namespace Drupal\nexteuropa_integration\Producer;

use Drupal\nexteuropa_integration\Configuration\ConfigurationFactory;
use Drupal\nexteuropa_integration\Configuration\AbstractConfiguration;
use Drupal\nexteuropa_integration\Document\Document;
use Drupal\nexteuropa_integration\Producer\Configuration\ProducerConfiguration;

/**
 * Interface ProducerFactory.
 *
 * @package Drupal\nexteuropa_integration\Producer
 */
class ProducerFactory {

  /**
   * Instantiate and return a producer object given its configuration.
   *
   * @param string $machine_name
   *    Producer configuration machine name.
   * @param $entity
   *    Entity object.
   *
   * @return AbstractProducer
   *    Producer instance.
   */
  static public function getInstance($machine_name, $entity) {
    /** @var ProducerConfiguration $configuration */
    $configuration = self::loadConfiguration($machine_name);

    $producer_info = nexteuropa_integration_producer_get_producer_info();
    $producer_class = $producer_info[$configuration->getType()]['class'];

    if (!class_exists($producer_class)) {
      throw new \InvalidArgumentException("Class $producer_class does not exists");
    }

    $entity_wrapper = new EntityWrapper\EntityWrapper($configuration->getType(), $entity);
    $document = new Document();
    return new $producer_class($configuration, $entity_wrapper, $document);
  }

  /**
   * Load configuration from database.
   *
   * @param string $machine_name
   *    Producer configuration machine name.
   *
   * @return AbstractConfiguration
   *    Configuration object.
   */
  static public function loadConfiguration($machine_name) {
    return ConfigurationFactory::load('integration_producer', $machine_name);
  }

}
