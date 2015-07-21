<?php

/**
 * @file
 * Contains \Drupal\nexteuropa_integration\Backend\RestBackend.
 */

namespace Drupal\nexteuropa_integration\Backend;

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
   * {@inheritdoc}
   */
  public function create(DocumentInterface $document) {
    $options = array();
    $options['method'] = 'POST';
    $options['data'] = $document->getDocument();
    $response = drupal_http_request($this->getUri(), $options);
    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function read(DocumentInterface $document) {
    $options = array();
    $options['method'] = 'GET';
    $response = drupal_http_request($this->getUri() . '/' . $document->getId(), $options);
    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function update(DocumentInterface $document) {
    $options = array();
    $options['method'] = 'PUT';
    $options['data'] = $document->getDocument();
    $response = drupal_http_request($this->getUri(), $options);
    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function delete(DocumentInterface $document) {
    $options = array();
    $options['method'] = 'DELETE';
    $response = drupal_http_request($this->getUri() . '/' . $document->getId(), $options);
    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function getBackendId(DocumentInterface $document) {
    // @todo: ask service for remote id.
    return $document->getMetadata('producer_content_id');
  }

}
