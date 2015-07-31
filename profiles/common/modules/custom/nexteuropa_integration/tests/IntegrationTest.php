<?php

/**
 * @file
 * Contains Drupal\nexteuropa_integration\Tests\IntegrationTest.
 */

namespace Drupal\nexteuropa_integration\Tests;

use Drupal\nexteuropa_integration\Backend\BackendFactory;
use Drupal\nexteuropa_integration\Consumer\Consumer;
use Drupal\nexteuropa_integration\Producer\ProducerFactory;

/**
 * Class IntegrationTest.
 *
 * @package Drupal\nexteuropa_integration\Tests
 */
class IntegrationTest extends AbstractTest {

  /**
   * Test producer-consumer workflow.
   */
  public function testProducerConsumerWorkflow() {
    $node = $this->getExportedEntityFixture('node', 'integration_test', 1);

    // Get backend, producer and consumer instances.
    $backend = BackendFactory::getInstance('test_configuration');
    $producer = ProducerFactory::getInstance('test_configuration', $node);
    $consumer = Consumer::getInstance('test_configuration');

    // Build document, at this point it still does not have a remote ID.
    $document = $producer->build();
    $this->assertNull($document->getId());

    // Each backend is responsible for fetching a document's remote ID.
    $this->assertEquals('node-integration-test-' . $node->nid, $backend->getBackendId($document));

    // Test backend create method.
    $document = $backend->create($document);
    $this->assertEquals('node-integration-test-' . $node->nid, $document->getId());
    $this->assertEquals(array('en', 'fr'), $document->getAvailableLanguages());
    foreach (array('en', 'fr') as $language) {
      $document->setCurrentLanguage($language);
      $this->assertEquals($node->title_field[$language][0]['value'], $document->getFieldValue('title_field'));
    }

    // Test backend read method.
    $document = $backend->read($document);
    $this->assertEquals(array('en', 'fr'), $document->getAvailableLanguages());
    foreach (array('en', 'fr') as $language) {
      $document->setCurrentLanguage($language);
      $this->assertEquals($node->title_field[$language][0]['value'], $document->getFieldValue('title_field'));
    }

    // Test backend update method.
    $document->setCurrentLanguage('en');
    $document->setField('title_field', 'English title updated');
    $document = $backend->update($document);
    $this->assertEquals('English title updated', $document->getFieldValue('title_field'));

    // Test backend delete method.
    $backend->delete($document);
    $this->assertFalse($backend->read($document));
  }

}
