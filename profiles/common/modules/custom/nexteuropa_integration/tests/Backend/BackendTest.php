<?php

/**
 * @file
 * Contains BackendTest.
 */

namespace Drupal\nexteuropa_integration\Tests\Backend;

use Drupal\nexteuropa_integration\Backend\Configuration\BackendConfiguration;
use Drupal\nexteuropa_integration\Backend\Formatter\JsonFormatter;
use Drupal\nexteuropa_integration\Backend\Response\HttpRequestResponse;
use Drupal\nexteuropa_integration\Backend\RestBackend;
use Drupal\nexteuropa_integration\Document\Document;
use Drupal\nexteuropa_integration\Tests\AbstractTest;

/**
 * Class BackendTest.
 *
 * @package Drupal\nexteuropa_integration\Tests\Backend
 */
class BackendTest extends AbstractTest {

  /**
   * Test HTTP Backend.
   */
  public function testHttpRestBackend() {

    $backend = $this->getMockedHttpBackendInstance('test_configuration');
    $backend->shouldAllowMockingProtectedMethods()
      ->shouldReceive('httpRequest')
      ->andReturn('my-mocked-response');

    /** @var RestBackend $backend */
    $document = new Document();
    $document->setMetadata('producer', 'producer-name');
    $document->setMetadata('producer_content_id', 'node-article-1');

    $response = $backend->create($document);
    $this->assertEquals('my-mocked-response', $response);
  }

  /**
   * Get mocked backend instance.
   *
   * @param $configuration_name
   *    Machine name of backend configuration, available as fixture.
   *
   * @return \Mockery\MockInterface
   *    Mocked object.
   */
  protected function getMockedHttpBackendInstance($configuration_name) {

    /** @var BackendConfiguration $configuration */
    $data = $this->getConfigurationFixture('backend', 'test_configuration');
    $configuration = entity_create('integration_backend', (array) $data);
    $response = new HttpRequestResponse();
    $formatter = new JsonFormatter();

    $arguments = array($configuration, $response, $formatter);
    return \Mockery::mock('Drupal\nexteuropa_integration\Backend\RestBackend[httpRequest]', $arguments);
  }
}
