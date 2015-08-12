<?php

/**
 * @file
 * Contains ProducerFactoryTest.
 */

namespace Drupal\nexteuropa_integration\Tests\Producer;

use Drupal\nexteuropa_integration\Producer\ProducerFactory;
use Drupal\nexteuropa_integration\Tests\AbstractTest;

/**
 * Class ProducerFactoryTest.
 *
 * @package Drupal\nexteuropa_integration\Tests\Producer
 */
class ProducerFactoryTest extends AbstractTest {

  /**
   * Test create method.
   */
  public function testFactory() {
    $node = $this->getExportedEntityFixture('node', 'integration_test', 1);
    $producer_info = nexteuropa_integration_producer_get_producer_info();
    $producer_class = $producer_info[$this->producerConfiguration->getType()]['class'];

    $producer = ProducerFactory::getInstance('test_configuration', $node);

    $reflection = new \ReflectionClass($producer);
    $this->assertEquals($producer_class, $reflection->getName());
  }

}
