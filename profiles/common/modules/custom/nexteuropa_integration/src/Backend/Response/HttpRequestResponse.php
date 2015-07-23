<?php

/**
 * @file
 * Contains HttpRequestResponse
 */

namespace Drupal\nexteuropa_integration\Backend\Response;

/**
 * Class HttpRequestResponse.
 *
 * @package Drupal\nexteuropa_integration\Backend\Response
 */
class HttpRequestResponse extends AbstractResponse {

  /**
   * {@inheritdoc}
   */
  public function hasErrors() {
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function getStatusCode() {
    return '200';
  }

  /**
   * {@inheritdoc}
   */
  public function getErrorMessage() {
    return '';
  }

  /**
   * {@inheritdoc}
   */
  public function getData() {
    return array();
  }

}
