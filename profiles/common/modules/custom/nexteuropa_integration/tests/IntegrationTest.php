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

    // Test that other proprieties are set correctly on a document.
    $this->assertDocumentConsistency($document, $node);

    // Test backend read method.
    $document = $backend->read($document);

    // Test that other proprieties are set correctly on a document.
    $this->assertDocumentConsistency($document, $node);

    // Test backend update method.
    $document->setCurrentLanguage('en')->setField('title_field', 'English title updated');
    $updated_document = $backend->update($document);
    $this->assertEquals('English title updated', $updated_document->getFieldValue('title_field'));

    // Test backend delete method.
    $backend->delete($updated_document);
    $this->assertFalse($backend->read($updated_document));
  }

  /**
   * Assert that document properties are set correctly.
   *
   * @param DocumentInterface $document
   *    Document object.
   * @param object $node
   *    Node object.
   */
  protected function assertDocumentConsistency(DocumentInterface $document, $node) {
    // Assert that default language has been imported correctly.
    $this->assertEquals($document->getDefaultLanguage(), $node->language);

    // Assert that available languages have been set correctly.
    $this->assertEquals(array('en', 'fr'), $document->getAvailableLanguages());

    foreach (array('en', 'fr') as $language) {
      $document->setCurrentLanguage($language);

      // Assert that title has been imported correctly.
      $this->assertEquals($node->title_field[$language][0]['value'], $document->getFieldValue('title_field'));

      // Assert that body has been imported correctly.
      $this->assertEquals($node->body[$language][0]['value'], $document->getFieldValue('body'));

      // Assert that list field has been imported correctly.
      foreach ($document->getFieldValue('field_integration_test_text') as $key => $value) {
        $this->assertEquals($node->field_integration_test_text[$language][$key]['value'], $value);
      }

      // Assert that images are imported correctly.
      foreach ($document->getFieldValue('field_integration_test_images_path') as $key => $value) {
        if ($value) {
          $this->assertContains($node->field_integration_test_images[$language][$key]['filename'], urldecode($value));
        }
      }

      // Assert that image alt field is imported correctly.
      foreach ($document->getFieldValue('field_integration_test_images_alt') as $key => $value) {
        $this->assertEquals($node->field_integration_test_images[$language][$key]['alt'], $value);
      }

      // Assert that image title field is imported correctly.
      foreach ($document->getFieldValue('field_integration_test_images_title') as $key => $value) {
        $this->assertEquals($node->field_integration_test_images[$language][$key]['title'], $value);
      }

      // Assert that files are imported correctly.
      foreach ($document->getFieldValue('field_integration_test_files_path') as $key => $value) {
        if ($value) {
          $this->assertContains($node->field_integration_test_files[$language][$key]['filename'], $value);
        }
      }

      // Assert that date field has been imported correctly.
      $r = $document->getFieldValue('field_integration_test_dates_start');
      $this->assertEquals($document->getFieldValue('field_integration_test_dates_start'), $node->field_integration_test_dates[LANGUAGE_NONE][0]['value']);
      $this->assertEquals($document->getFieldValue('field_integration_test_dates_end'), $node->field_integration_test_dates[LANGUAGE_NONE][0]['value2']);
    }
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
