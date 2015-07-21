<?php

/**
 * @file
 * Contains \Drupal\nexteuropa_integration\Backend\AbstractBackend.
 */

namespace Drupal\nexteuropa_integration\Backend;
use Drupal\nexteuropa_integration\Backend\Formatter\JsonFormatter;

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
   * Formatter object.
   *
   * @var Formatter\FormatterInterface
   *    Formatter object instance.
   */
  private $formatter;

  /**
   * Constructor.
   *
   * @param string $base
   *    Backend base path.
   * @param string $endpoint
   *    Backend endpoint.
   */
  public function __construct($base, $endpoint, Formatter\FormatterInterface $formatter) {
    $this->setBase($base);
    $this->setEndpoint($endpoint);
    $this->setFormatter($formatter);
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

  /**
   * {@inheritdoc}
   */
  public function getFormatter() {
    return $this->formatter;
  }

  /**
   * {@inheritdoc}
   */
  public function setFormatter(Formatter\FormatterInterface $formatter) {
    $this->formatter = $formatter;
  }

  /**
   * @todo: Include actual configuration loading.
   */
  public static function loadSettings($name) {
    global $conf;
    if (isset($conf['integration']['backend'][$name])) {
      return $conf['integration']['backend'][$name];
    }
    else {
      throw new \InvalidArgumentException("No settings for $name");
    }
  }

  /**
   * @todo: Include backend instantiation using hooks, as done on producers.
   */
  public static function getInstance($name) {
    $backend_settings = RestBackend::loadSettings($name);
    return new RestBackend($backend_settings->base, $backend_settings->endpoint, new JsonFormatter());
  }

}
