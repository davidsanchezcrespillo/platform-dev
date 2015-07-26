<?php

/**
 * @file
 * Contains BackendConfiguration.
 */

namespace Drupal\nexteuropa_integration\Backend\Configuration;

use Drupal\nexteuropa_integration\Configuration\AbstractConfiguration;

/**
 * Class BackendConfiguration.
 *
 * @package Drupal\nexteuropa_integration\Backend
 */
class BackendConfiguration extends AbstractConfiguration {

  /**
   * Contains backend options.
   *
   * @var array
   */
  public $options = array();

  /**
   * Formatter handler machine name.
   *
   * @see hook_nexteuropa_integration_backend_formatter_handler_info()
   *
   * @var string
   */
  public $formatter = '';

  /**
   * Response handler machine name.
   *
   * @see nexteuropa_integration_backend_response_handler_info()
   *
   * @var string
   */
  public $response = '';

  /**
   * Get formatter handler name.
   *
   * @return string
   *    Formatter handler name.
   */
  public function getFormatter() {
    return $this->formatter;
  }

  /**
   * Set formatter handler name.
   *
   * @param string $formatter
   *    Formatter handler name.
   */
  public function setFormatter($formatter) {
    $this->formatter = $formatter;
  }

  /**
   * Get response handler name.
   *
   * @return string
   *    Response handler name.
   */
  public function getResponse() {
    return $this->response;
  }

  /**
   * Set response handler name.
   *
   * @param string $response
   *    Response handler name.
   */
  public function setResponse($response) {
    $this->response = $response;
  }

  /**
   * Get backend base path.
   *
   * @return string
   *     Backend base path.
   */
  public function getBasePath() {
    return $this->options['base_path'];
  }

  /**
   * Set backend base path.
   *
   * @param string $base_path
   *    Backend base path.
   */
  public function setBasePath($base_path) {
    $this->options['base_path'] = $base_path;
  }

  /**
   * Get backend endpoint.
   *
   * @return string
   *    Backend endpoint.
   */
  public function getEndpoint() {
    return $this->options['endpoint'];
  }

  /**
   * Set resource endpoint.
   *
   * @param string $endpoint
   *    Backend resource endpoint.
   */
  public function setEndpoint($endpoint) {
    $this->options['endpoint'] = $endpoint;
  }

  /**
   * Get backend resource list endpoint.
   *
   * @return string
   *    List endpoint.
   */
  public function getListEndpoint() {
    return $this->options['list'];
  }

  /**
   * Set backend resource list endpoint.
   *
   * @param string $list
   *    List endpoint.
   */
  public function setListEndpoint($list) {
    $this->options['list'] = $list;
  }

}
