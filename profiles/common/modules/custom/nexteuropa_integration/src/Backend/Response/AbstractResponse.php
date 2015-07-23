<?php

/**
 * @file
 * Contains AbstractResponse
 */

namespace Drupal\nexteuropa_integration\Backend\Response;

/**
 * Class AbstractResponse.
 *
 * @package Drupal\nexteuropa_integration\Backend\Response
 */
abstract class AbstractResponse implements ResponseInterface {

  /**
   * Response object, text or array.
   *
   * @var mixed
   */
  private $response;

  /**
   * {@inheritdoc}
   */
  public function getResponse() {
    return $this->response;
  }

  /**
   * {@inheritdoc}
   */
  public function setResponse($response) {
    $this->response = $response;
  }

}
