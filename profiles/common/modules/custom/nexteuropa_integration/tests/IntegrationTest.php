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
   *
   * @param string $bundle
   *    Node bundle.
   * @param int $id
   *    Node ID.
   *
   * @dataProvider nodeFixturesProvider
   */
  public function testProducerConsumerWorkflow($bundle, $id) {
    $node = $this->getExportedEntityFixture('node', $bundle, $id);

    // Get backend, producer and consumer instances.
    $backend = BackendFactory::getInstance('test_configuration');
    $producer = ProducerFactory::getInstance('test_configuration', $node);
    $consumer = Consumer::getInstance('test_configuration');

    // Build document: at this point it should not have a remote ID.
    $document = $producer->build();
    $this->assertNull($document->getId());

    // Each backend is responsible for fetching a document's remote ID.
    $this->assertEquals($this->expectedDocumentId($node), $backend->getBackendId($document));

    // Test backend create method.
    $document = $backend->create($document);

    // Test that backend create does assign an ID to a document.
    $this->assertEquals($this->expectedDocumentId($node), $document->getId());

    // Test backend read method.
    $document = $backend->read($document);

    // Test backend update method.
    $document->setCurrentLanguage('en')->setField('title_field', 'English title updated');
    $updated_document = $backend->update($document);
    $this->assertEquals('English title updated', $updated_document->getFieldValue('title_field'));

    // Test backend delete method.
    $backend->delete($updated_document);
    $this->assertFalse($backend->read($updated_document));
  }

  /**
   * Return expected document ID.
   *
   * @param object $node
   *    Node object.
   *
   * @return string
   *    Expected document ID.
   */
  protected function expectedDocumentId($node) {
    return 'node-integration-test-' . $node->nid;
  }

  /**
   * Node fixture data provider.
   *
   * @return array
   *    List of fixtures types and IDs.
   */
  public function nodeFixturesProvider() {
    return array(
      array('integration_test', 1),
      array('integration_test', 2),
      array('integration_test', 3),
    );
  }

}
