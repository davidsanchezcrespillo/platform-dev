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
   * {@inheritdoc}
   */
  public function getUri() {
    return $this->getConfiguration()->getBasePath() . '/' . $this->getConfiguration()->getEndpoint();
  }

  /**
   * {@inheritdoc}
   */
  public function create(DocumentInterface $document) {
    $options = array();
    $options['method'] = 'POST';
    $options['data'] = $this->getFormatter()->format($document);
    $response = $this->httpRequest($this->getUri(), $options);
    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function read(DocumentInterface $document) {
    $options = array();
    $options['method'] = 'GET';
    $response = $this->httpRequest($this->getUri() . '/' . $this->getBackendId($document), $options);

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
    $response = $this->httpRequest($this->getUri() . '/' . $this->getBackendId($document), $options);

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
    $response = $this->httpRequest($this->getUri() . '/' . $this->getBackendId($document), $options);

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
    $response = $this->httpRequest($this->getConfiguration()->getBasePath() . '/uuid/' . $producer . '/' . $producer_content_id, $options);

    if ($response->code == 200) {
      $data = json_decode($response->data);
      return $data->rows[0]->id;
    }
    else {
      return NULL;
    }
  }

  /**
   * Forwards HTTP requests to drupal_http_request().
   *
   * @param $url
   *    A string containing a fully qualified URI.
   * @param array $options
   *    Array of options.
   *
   * @return object
   *    Response object, as returned by drupal_http_request().
   *
   * @see drupal_http_request()
   */
  protected function httpRequest($url, array $options = array()) {
    return drupal_http_request($url, $options);
  }

}
