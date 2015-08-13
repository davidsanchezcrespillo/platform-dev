<?php

/**
 * @file
 * Contains BackendTest.
 */

namespace Drupal\nexteuropa_integration\Tests\Backend;

use Drupal\nexteuropa_integration\Backend\BackendFactory;
use Drupal\nexteuropa_integration\Backend\Formatter\JsonFormatter;
use Drupal\nexteuropa_integration\Backend\Response\HttpRequestResponse;
use Drupal\nexteuropa_integration\Backend\RestBackend;
use Drupal\nexteuropa_integration\Document\Document;
use Drupal\nexteuropa_integration\Producer\ProducerFactory;
use Drupal\nexteuropa_integration\Tests\AbstractTest;

/**
 * Class BackendTest.
 *
 * @package Drupal\nexteuropa_integration\Tests\Backend
 */
class BackendTest extends AbstractTest {

  /**
   * Test backend CRUD operations.
   *
   * @param string $bundle
   *    Node bundle.
   * @param int $id
   *    Node ID.
   *
   * @dataProvider nodeFixturesDataProvider
   */
  public function testBackendCrudOperations($bundle, $id) {
    $node = $this->getExportedEntityFixture('node', $bundle, $id);

    // Get backend, producer and consumer instances.
    $backend = BackendFactory::getInstance('test_configuration');
    $producer = ProducerFactory::getInstance('test_configuration', $node);

    // Build document: at this point it should not have a remote ID.
    $document = $producer->build();
    $this->assertNull($document->getId());

    // Each backend is responsible for fetching a document's remote ID.
    $this->assertEquals($this->expectedNodeDocumentId($node), $backend->getBackendId($document));

    // Test backend create method.
    $document = $backend->create($document);

    // Test that backend create does assign an ID to a document.
    $this->assertEquals($this->expectedNodeDocumentId($node), $document->getId());

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

}
