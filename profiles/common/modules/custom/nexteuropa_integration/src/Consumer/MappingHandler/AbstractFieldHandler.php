<?php

/**
 * @file
 * Contains AbstractMappingHandler.
 */

namespace Drupal\nexteuropa_integration\Consumer\MappingHandler;

use Drupal\nexteuropa_integration\Consumer\Consumer;

/**
 * Class AbstractMappingHandler.
 *
 * @package Drupal\nexteuropa_integration\Consumer
 */
abstract class AbstractMappingHandler implements MappingHandlerInterface {

  /**
   * Current consumer object.
   *
   * @var Consumer
   */
  protected $consumer = NULL;

  /**
   * Constructor.
   *
   * @param Consumer $consumer
   *    Consumer object.
   */
  public function __construct(Consumer $consumer) {
    $this->consumer = $consumer;
  }

  /**
   * {@inheritdoc}
   */
  public function getConsumer() {
    return $this->consumer;
  }

}
