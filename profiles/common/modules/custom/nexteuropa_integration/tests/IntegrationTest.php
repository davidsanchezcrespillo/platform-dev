<?php

/**
 * @file
 * Contains Drupal\nexteuropa_integration\Tests\IntegrationTest.
 */

namespace Drupal\nexteuropa_integration\Tests;
use Drupal\nexteuropa_integration\Backend\MemoryBackend;
use Drupal\nexteuropa_integration\Consumer\Consumer;
use Drupal\nexteuropa_integration\Producer\NodeProducer;

/**
 * Class IntegrationTest.
 *
 * @package Drupal\nexteuropa_integration\Tests
 */
class IntegrationTest extends AbstractTest {

  /**
   * Test testProducerConsumerChain().
   */
  public function testProducerConsumerChain() {

    $node = $this->getExportedEntityFixture('integration_test', 1);
    $settings = $this->getConfigurationFixture('consumer', 'integration_test');

    $backend = new MemoryBackend('node', 'integration_test');
    $producer = $this->getNodeProducerInstance($node);

    $this->assertEquals('node-integration-test-49', $backend->getBackendId($producer));

    $consumer = $this->getConsumerInstance($settings);
    $document = $producer->build();
    $result = $backend->create($document);

  }

}
