<?php

/**
 * @file
 * Contains Drupal\nexteuropa_integration\Tests\IntegrationTest.
 */

namespace Drupal\nexteuropa_integration\Tests;
use Drupal\nexteuropa_integration\Backend\Formatter\JsonFormatter;
use Drupal\nexteuropa_integration\Backend\MemoryBackend;
use Drupal\nexteuropa_integration\Backend\RestBackend;
use Drupal\nexteuropa_integration\Consumer\Consumer;
use Drupal\nexteuropa_integration\Producer\NodeProducer;

/**
 * Class IntegrationTest.
 *
 * @package Drupal\nexteuropa_integration\Tests
 */
class IntegrationTest extends AbstractTest {

  /**
   * Test testMemoryProducer().
   */
  public function testProducerConsumerChain() {
    $node = $this->getExportedEntityFixture('integration_test', 1);
    $backend = new MemoryBackend('node', 'integration_test', new JsonFormatter());

    $producer = $this->getNodeProducerInstance($node);

    // Build document, still does not have a remote ID.
    $document = $producer->build();
    $this->assertNull($document->getId());

    // Each backend is responsible for fetching a document's remote ID.
    $this->assertEquals('node-integration-test-49', $backend->getBackendId($document));

    $document = $backend->create($document);
    $this->assertEquals('node-integration-test-49', $document->getId());
    $this->assertEquals(array('en', 'fr'), $document->getAvailableLanguages());
    $this->assertEquals('English title article 1', $document->getFieldValue('title_field'));

    $document->setField('title_field', 'English title article 1 updated');

    $document = $backend->update($document);
    $this->assertEquals('English title article 1 updated', $document->getFieldValue('title_field'));

    $document = $backend->read($document);
    $this->assertEquals(array('en', 'fr'), $document->getAvailableLanguages());
    $this->assertEquals('English title article 1 updated', $document->getFieldValue('title_field'));

    $backend->delete($document);
    $this->assertFalse($backend->read($document));
  }

  /**
   * Test testProducerConsumerChain().
   */
  public function testRemoteTests() {

  }

}
