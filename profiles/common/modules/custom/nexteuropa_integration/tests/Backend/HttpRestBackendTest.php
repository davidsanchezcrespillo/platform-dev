<?php

/**
 * @file
 * Contains HttpRestBackendTest.
 */

namespace Drupal\nexteuropa_integration\Tests\Backend;

use Drupal\nexteuropa_integration\Backend\Formatter\JsonFormatter;
use Drupal\nexteuropa_integration\Backend\Response\HttpRequestResponse;
use Drupal\nexteuropa_integration\Backend\RestBackend;
use Drupal\nexteuropa_integration\Document\Document;
use Drupal\nexteuropa_integration\Tests\AbstractTest;

/**
 * Class HttpRestBackendTest.
 *
 * @package Drupal\nexteuropa_integration\Tests\Backend
 */
class HttpRestBackendTest extends AbstractTest {

  /**
   * Test create method.
   */
  public function testCreate() {
    $response = new \stdClass();
    $response->code = 200;
    $response->data = (object) array('_id' => '123');

    $backend = $this->getMockedHttpBackendInstance($response);

    /** @var RestBackend $backend */
    $document = $backend->create(new Document());
    $this->assertEquals('123', $document->getId());
  }

  /**
   * Test update method.
   */
  public function testUpdate() {
    $response = new \stdClass();
    $response->code = 200;
    $response->data = (object) array('_id' => '123');

    $backend = $this->getMockedHttpBackendInstance($response);

    /** @var RestBackend $backend */
    $document = $backend->update(new Document());
    $this->assertEquals('123', $document->getId());
  }

  /**
   * Test delete method.
   */
  public function testDelete() {
    $response = new \stdClass();
    $response->code = 200;
    $response->data = (object) array('_id' => '123');

    $backend = $this->getMockedHttpBackendInstance($response);

    /** @var RestBackend $backend */
    $return = $backend->delete(new Document());
    $this->assertTrue($return);
  }

  /**
   * Get mocked backend instance.
   *
   * @param string $returned_response
   *    Response that it's going to be returned by the backend.
   *
   * @return \Mockery\MockInterface
   *    Mocked object.
   */
  protected function getMockedHttpBackendInstance($returned_response) {

    $arguments = array(
      $this->backendConfiguration,
      new HttpRequestResponse(),
      new JsonFormatter(),
    );
    $backend = \Mockery::mock('Drupal\nexteuropa_integration\Backend\RestBackend[httpRequest]', $arguments);
    $backend->shouldAllowMockingProtectedMethods()
      ->shouldReceive('httpRequest')
      ->andReturn($returned_response);
    return $backend;
  }

}
