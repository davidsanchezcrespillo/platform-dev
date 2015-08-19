<?php

/**
 * @file
 * Contains \Drupal\integration\Backend\AbstractBackend.
 */

namespace Drupal\integration\Backend;

use Drupal\integration\Configuration\AbstractConfiguration;
use Drupal\integration\Configuration\ConfigurableInterface;

/**
 * Class AbstractBackend.
 *
 * @package Drupal\integration\Backend
 */
abstract class AbstractBackend implements BackendInterface, ConfigurableInterface {

  /**
   * Configuration object.
   *
   * @var Configuration\BackendConfiguration
   */
  private $configuration;

  /**
   * Response handler object.
   *
   * @var Response\ResponseInterface
   */
  private $response;

  /**
   * Formatter object.
   *
   * @var Formatter\FormatterInterface
   */
  private $formatter;

  /**
   * Constructor.
   *
   * @param Configuration\BackendConfiguration $configuration
   *    Configuration object.
   * @param Response\ResponseInterface $response
   *    Response handler object.
   * @param Formatter\FormatterInterface $formatter
   *    Formatter object.
   */
  public function __construct(Configuration\BackendConfiguration $configuration, Response\ResponseInterface $response, Formatter\FormatterInterface $formatter) {
    $this->setConfiguration($configuration);
    $this->setResponseHandler($response);
    $this->setFormatter($formatter);
  }

  /**
   * {@inheritdoc}
   */
  public function getConfiguration() {
    return $this->configuration;
  }

  /**
   * {@inheritdoc}
   */
  public function setConfiguration(AbstractConfiguration $configuration) {
    $this->configuration = $configuration;
  }

  /**
   * {@inheritdoc}
   */
  public function getResponseHandler() {
    return $this->response;
  }

  /**
   * {@inheritdoc}
   */
  public function setResponseHandler(Response\ResponseInterface $response) {
    $this->response = $response;
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

}
