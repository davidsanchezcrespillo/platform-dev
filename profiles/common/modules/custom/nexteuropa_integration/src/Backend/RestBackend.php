<?php

/**
 * @file
 * Contains \Drupal\nexteuropa_integration\Backend\RestBackend.
 */

namespace Drupal\nexteuropa_integration\Backend;

use Drupal\nexteuropa_integration\Producer\ProducerInterface;
use Drupal\nexteuropa_integration\Document\DocumentInterface;

/**
 * Class RestBackend.
 *
 * @package Drupal\nexteuropa_integration\Backend
 */
class RestBackend extends AbstractBackend {


  /**
   * Get full service URI.
   *
   * @return string
   *    Full service URI.
   */
  protected function getUri() {
    return $this->getBase() . '/' . $this->getEndpoint();
  }

  /**
   * @param $json
   */
  public function post($data) {
    $options = array();
    $options['method'] = 'POST';
    $options['data'] = $data;
    $response = drupal_http_request($this->getUri(), $options);

    return $response;
  }



  /**
   * {@inheritdoc}
   */
  public function create(DocumentInterface $document) {
    // TODO: Implement create() method.
  }

  /**
   * {@inheritdoc}
   */
  public function read($id) {
    // TODO: Implement read() method.
  }

  /**
   * {@inheritdoc}
   */
  public function update(DocumentInterface $document) {
    // TODO: Implement update() method.
  }

  /**
   * {@inheritdoc}
   */
  public function delete($id) {
    // TODO: Implement delete() method.
  }

  /**
   * {@inheritdoc}
   */
  public function getBackendId(ProducerInterface $producer) {
    return $producer->getProducerContentId();
  }

}
