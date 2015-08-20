<?php

/**
 * @file
 * Contains BackendConfiguration.
 */

namespace Drupal\integration\Backend\Configuration;

use Drupal\integration\Configuration\AbstractConfiguration;

/**
 * Class BackendConfiguration.
 *
 * @package Drupal\integration\Backend
 */
class BackendConfiguration extends AbstractConfiguration {

  /**
   * Backend type plugin.
   *
   * @see integration_backend_info()
   *
   * @var string
   */
  public $type = '';

  /**
   * Formatter handler machine name.
   *
   * @see hook_integration_backend_formatter_handler_info()
   *
   * @var string
   */
  public $formatter = '';

  /**
   * Response handler machine name.
   *
   * @see integration_backend_response_handler_info()
   *
   * @var string
   */
  public $response = '';

  /**
   * Contains backend options.
   *
   * @var array
   */
  public $options = array();

  /**
   * Get backend type.
   *
   * @return string
   *    Backend type.
   */
  public function getType() {
    return isset($this->type) ? $this->type : '';
  }

  /**
   * Set backend type.
   *
   * @param string $type
   *    Backend type.
   */
  public function setType($type) {
    $this->type = $type;
  }

  /**
   * Get formatter handler name.
   *
   * @return string
   *    Formatter handler name.
   */
  public function getFormatter() {
    return isset($this->formatter) ? $this->formatter : '';
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
   * @todo: This should actually be backend-type specific.
   *
   * @return string
   *     Backend base path.
   */
  public function getBasePath() {
    return isset($this->options['base_path']) ? $this->options['base_path'] : '';
  }

  /**
   * Set backend base path.
   *
   * @param string $base_path
   *    Backend base path.
   */
  public function setBasePath($base_path) {
    // @todo: This should actually be backend-type specific.
    $this->options['base_path'] = $base_path;
  }

  /**
   * Get backend endpoint.
   *
   * @return string
   *    Backend endpoint.
   */
  public function getEndpoint() {
    // @todo: This should actually be backend-type specific.
    return isset($this->options['endpoint']) ? $this->options['endpoint'] : '';
  }

  /**
   * Set resource endpoint.
   *
   * @param string $endpoint
   *    Backend resource endpoint.
   */
  public function setEndpoint($endpoint) {
    // @todo: This should actually be backend-type specific.
    $this->options['endpoint'] = $endpoint;
  }

  /**
   * Get backend resource list endpoint.
   *
   * @return string
   *    List endpoint.
   */
  public function getListEndpoint() {
    // @todo: This should actually be backend-type specific.
    return isset($this->options['list']) ? $this->options['list'] : '';
  }

  /**
   * Set backend resource list endpoint.
   *
   * @param string $list
   *    List endpoint.
   */
  public function setListEndpoint($list) {
    // @todo: This should actually be backend-type specific.
    $this->options['list'] = $list;
  }

}
