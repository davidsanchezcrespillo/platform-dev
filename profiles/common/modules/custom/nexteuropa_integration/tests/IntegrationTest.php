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
   * @var AbstractBackend
   */
  protected $backend;

  /**
   * @var AbstractProducer
   */
  protected $producer;

  /**
   * @var Consumer
   */
  protected $consumer;

  /**
   * @var \stdClass
   */
  protected $node;

  /**
   * Setup PHPUnit hook.
   */
  public function setUp() {
    parent::setUp();

    $this->node = $this->getExportedEntityFixture('node', 'integration_test', 1);

    // Get backend, producer and consumer instances.
    $this->backend = BackendFactory::getInstance('test_configuration');
    $this->producer = ProducerFactory::getInstance('test_configuration', $this->node);
    $this->consumer = Consumer::getInstance('test_configuration');
  }


  /**
   * Test producer-consumer workflow.
   */
  public function testProducerConsumerWorkflow() {

    // Build document: at this point it should not have a remote ID.
    $document = $this->producer->build();
    $this->assertNull($document->getId());

    // Each backend is responsible for fetching a document's remote ID.
    $this->assertEquals($this->expectedDocumentId(), $this->backend->getBackendId($document));

    // Test backend create method.
    $document = $this->backend->create($document);

    // Test that backend create does assign an ID to a document.
    $this->assertEquals($this->expectedDocumentId(), $document->getId());

    // Test that other proprieties are set correctly on a document.
    $this->assertDocumentConsistency($document);

    // Test backend read method.
    $document = $this->backend->read($document);

    // Test that other proprieties are set correctly on a document.
    $this->assertDocumentConsistency($document);

    // Test backend update method.
    $document->setCurrentLanguage('en')->setField('title_field', 'English title updated');
    $updated_document = $this->backend->update($document);
    $this->assertEquals('English title updated', $updated_document->getFieldValue('title_field'));

    // Test backend delete method.
    $this->backend->delete($updated_document);
    $this->assertFalse($this->backend->read($updated_document));
  }

  /**
   * Assert that document properties are set correctly.
   *
   * @param DocumentInterface $document
   *    Document object.
   */
  protected function assertDocumentConsistency(DocumentInterface $document) {
    $this->assertEquals(array('en', 'fr'), $document->getAvailableLanguages());
    foreach (array('en', 'fr') as $language) {
      $document->setCurrentLanguage($language);
      $this->assertEquals($this->node->title_field[$language][0]['value'], $document->getFieldValue('title_field'));
    }
  }

  /**
   * Return expected document ID.
   *
   * @return string
   *    Expected document ID.
   */
  protected function expectedDocumentId() {
    return 'node-integration-test-' . $this->node->nid;
  }

}
