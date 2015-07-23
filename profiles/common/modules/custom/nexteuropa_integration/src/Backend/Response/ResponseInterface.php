<?php

/**
 * @file
 * Contains ResponseInterface
 */

namespace Drupal\nexteuropa_integration\Backend\Response;

/**
 * Class AbstractResponse.
 *
 * @package Drupal\nexteuropa_integration\Backend\Response
 */
interface ResponseInterface {

  /**
   * Get raw response.
   *
   * @return mixed
   *    Raw response object, array or string.
   */
  public function getResponse();

  /**
   * Set raw response.
   *
   * @return mixed
   *    Raw response object, array or string.
   */
  public function setResponse($response);

  /**
   * Check whereas response has got errors or not.
   *
   * @return bool
   *    TRUE if errors, FALSE otherwise.
   */
  public function hasErrors();

  /**
   * Return current response status code.
   *
   * Even though a response object is not necessarily dealing with an HTTP
   * response we use HTTP status codes to determine a response status.
   *
   * @return string
   *    HTTP-like status code.
   */
  public function getStatusCode();

  /**
   * Get error message, if any.
   *
   * @return string
   *    Error message.
   */
  public function getErrorMessage();

  /**
   * Get response data.
   *
   * @return mixed|null
   *    Response data if response was successful, NULL otherwise.
   */
  public function getData();

}
