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
 * Simple REST backend using standard drupal_http_request(), without overrides.
 *
 * @package Drupal\nexteuropa_integration\Backend
 */
class RestBackend extends AbstractBackend {

  /**
   * {@inheritdoc}
   */
  public function getResourceUri() {
    return $this->getConfiguration()->getBasePath() . '/' . $this->getConfiguration()->getEndpoint();
  }

  /**
   * {@inheritdoc}
   */
  public function getListUri() {
    return $this->getConfiguration()->getBasePath() . '/' . $this->getConfiguration()->getListEndpoint();
  }

  /**
   * {@inheritdoc}
   */
  public function create(DocumentInterface $document) {
    $options = array();
    $options['method'] = 'POST';
    $options['data'] = $this->getFormatter()->format($document);
    $response = $this->httpRequest($this->getResourceUri(), $options);

    $this->getResponseHandler()->setResponse($response);
    if (!$this->getResponseHandler()->hasErrors()) {
      return new Document($this->getResponseHandler()->getData());
    }
  }

  /**
   * {@inheritdoc}
   */
  public function read(DocumentInterface $document) {
    $options = array();
    $options['method'] = 'GET';
    $response = $this->httpRequest($this->getResourceUri() . '/' . $this->getBackendId($document), $options);

    $this->getResponseHandler()->setResponse($response);
    if (!$this->getResponseHandler()->hasErrors()) {
      return new Document($this->getResponseHandler()->getData());
    }
  }

  /**
   * {@inheritdoc}
   */
  public function update(DocumentInterface $document) {
    $options = array();
    $options['method'] = 'PUT';
    $options['data'] = $this->getFormatter()->format($document);
    $response = $this->httpRequest($this->getResourceUri() . '/' . $this->getBackendId($document), $options);

    $this->getResponseHandler()->setResponse($response);
    if (!$this->getResponseHandler()->hasErrors()) {
      return new Document($this->getResponseHandler()->getData());
    }
  }

  /**
   * {@inheritdoc}
   */
  public function delete(DocumentInterface $document) {
    $options = array();
    $options['method'] = 'DELETE';
    $response = $this->httpRequest($this->getResourceUri() . '/' . $this->getBackendId($document), $options);

    $this->getResponseHandler()->setResponse($response);
    if (!$this->getResponseHandler()->hasErrors()) {
      return TRUE;
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
    if ($producer && $producer_content_id) {
      $response = $this->httpRequest($this->getConfiguration()->getBasePath() . '/uuid/' . $producer . '/' . $producer_content_id, $options);

      $this->getResponseHandler()->setResponse($response);
      if (!$this->getResponseHandler()->hasErrors()) {
        $data = $this->getResponseHandler()->getData();
        return $data->rows[0]->id;
      }
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
    global $conf;
    // Make sure we use standard drupal_http_request(), without overrides.
    $conf['drupal_http_request_function'] = FALSE;
    return drupal_http_request($url, $options);
  }

}
