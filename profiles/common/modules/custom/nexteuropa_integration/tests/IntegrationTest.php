<?php

/**
 * @file
 * Contains Drupal\nexteuropa_integration\Tests\IntegrationTest.
 */

namespace Drupal\nexteuropa_integration\Tests;

use Drupal\nexteuropa_integration\Backend\BackendFactory;
use Drupal\nexteuropa_integration\Consumer\Consumer;
use Drupal\nexteuropa_integration\Producer\ProducerFactory;
use Drupal\nexteuropa_integration\Backend\AbstractBackend;
use Drupal\nexteuropa_integration\Producer\AbstractProducer;
use Drupal\nexteuropa_integration\Document\DocumentInterface;

/**
 * Class IntegrationTest.
 *
 * @package Drupal\nexteuropa_integration\Tests
 */
class IntegrationTest extends AbstractTest {

  /**
   * Test producer-consumer workflow.
   */
  public function testProducerConsumerWorkflow($bundle, $id) {
    // Get backend, producer and consumer instances.
    $backend = BackendFactory::getInstance('test_configuration');
    $consumer = Consumer::getInstance('test_configuration');

    foreach ($this->nodeFixturesDataProvider() as $row) {
      $node = $this->getExportedEntityFixture('node', $row[0], $row[1]);

      // Build document: at this point it should not have a remote ID.
      $document = ProducerFactory::getInstance('test_configuration', $node)->build();
      $document = $backend->create($document);

      // Test that backend create does assign an ID to a document.
      $this->assertEquals($this->expectedNodeDocumentId($node), $document->getId());
    }


    return;
  }

}
