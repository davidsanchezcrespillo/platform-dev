<?php

/**
 * @file
 * Contains \Drupal\nexteuropa_integration\Backend\AbstractBackend.
 */

namespace Drupal\nexteuropa_integration\Backend;

/**
 * Class AbstractBackend.
 *
 * @package Drupal\nexteuropa_integration\Backend
 */
abstract class AbstractBackend implements BackendInterface {

  /**
   * Backend base path.
   *
   * @var string
   */
  private $base;

  /**
   * Set backend endpoint.
   *
   * @var string
   */
  private $endpoint;

  /**
   * Constructor.
   *
   * @param string $base
   *    Backend base path.
   * @param string $endpoint
   *    Backend endpoint.
   */
  public function __construct($base, $endpoint) {
    $this->setBase($base);
    $this->setEndpoint($endpoint);
  }

  /**
   * {@inheritdoc}
   */
  public function getBase() {
    return $this->base;
  }

  /**
   * {@inheritdoc}
   */
  public function setBase($base) {
    $this->base = $base;
  }

  /**
   * {@inheritdoc}
   */
  public function getEndpoint() {
    return $this->endpoint;
  }

  /**
   * {@inheritdoc}
   */
  public function setEndpoint($endpoint) {
    $this->endpoint = $endpoint;
  }

}
