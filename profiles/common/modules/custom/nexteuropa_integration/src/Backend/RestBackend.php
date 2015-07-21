<?php

/**
 * @file
 * Contains \Drupal\nexteuropa_integration\Backend\RestBackend.
 */

namespace Drupal\nexteuropa_integration\Backend;

use Drupal\nexteuropa_integration\Document\Document;
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
    $options['data'] = $this->getFormatter()->format($document);
    $response = drupal_http_request($this->getUri(), $options);
    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function read(DocumentInterface $document) {
    $options = array();
    $options['method'] = 'GET';
    $response = drupal_http_request($this->getUri() . '/' . $this->getBackendId($document), $options);

    if ($response->code == 200) {
      $data = json_decode($response->data);
      return new Document($data);
    }
    else {
      return NULL;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function update(DocumentInterface $document) {
    $options = array();
    $options['method'] = 'PUT';
    $options['data'] = $this->getFormatter()->format($document);
    $response = drupal_http_request($this->getUri() . '/' . $this->getBackendId($document), $options);

    if ($response->code == 200) {
      return $this->read($document);
    }
    else {
      return NULL;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function delete(DocumentInterface $document) {
    $options = array();
    $options['method'] = 'DELETE';
    $response = drupal_http_request($this->getUri() . '/' . $this->getBackendId($document), $options);

    if ($response->code == 200) {
      // @todo: backend sets deleted_by_producer = true.
      return TRUE;
    }
    else {
      return NULL;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getBackendId(DocumentInterface $document) {
    $options = array();
    $options['method'] = 'GET';
    $producer = $document->getMetadata('producer');
    $producer_content_id = $document->getMetadata('producer_content_id');
    if (!$producer || !$producer_content_id) {
      return NULL;
    }
    $response = drupal_http_request($this->getBase() . '/uuid/' . $producer . '/' . $producer_content_id, $options);

    if ($response->code == 200) {
      $data = json_decode($response->data);
      return $data->rows[0]->id;
    }
    else {
      return NULL;
    }
  }

}
