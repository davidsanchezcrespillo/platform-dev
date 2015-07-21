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

//    $result = $backend->delete($document->getId());
//
//    $document = $backend->read($document->getId());

  }

  /**
   * Test testProducerConsumerChain().
   */
  public function testRemoteTests() {

//    $settings = $this->getConfigurationFixture('consumer', 'integration_test');
//    $consumer = $this->getConsumerInstance($settings);

    //    $node = $this->getExportedEntityFixture('node', 1);
    //    $settings = $this->getConfigurationFixture('consumer', 'articles');
    //
    //    $base_url = 'http://userProducer:pass@ilayer.deglise.com/v1';
    //
    //
    //    $backend = new RestBackend($base_url, 'articles');
    //    $producer = $this->getNodeProducerInstance($node);
    //
    //    $consumer = $this->getConsumerInstance($settings);
    //    $document = $producer->build();
    return;

  }

}
