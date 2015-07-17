<?php

/**
 * @file
 * Contains Drupal\nexteuropa_integration\Producer\ProducerInterface.
 */

namespace Drupal\nexteuropa_integration\Producer;

use Drupal\nexteuropa_integration\DocumentInterface;
use Drupal\nexteuropa_integration\Document\Formatter\FormatterInterface;
use Drupal\nexteuropa_integration\Producer\EntityWrapper\DefaultEntityWrapper;

/**
 * Interface ProducerInterface.
 *
 * @package Drupal\nexteuropa_integration\Producer
 */
interface ProducerInterface {

  /**
   * Build document object using the entity the producer was instantiated with.
   *
   * @return DocumentInterface
   *    Built document object.
   */
  public function build();

  /**
   * Entity wrapper the producer has been instantiated with.
   *
   * @return DefaultEntityWrapper
   *    Entity wrapper object.
   */
  public function getEntityWrapper();

  /**
   * Get document handler the producer has been instantiated with.
   *
   * @return DocumentInterface
   *    Document object.
   */
  public function getDocument();

  /**
   * Get Formatter the producer has been instantiated with.
   *
   * @return FormatterInterface
   *    Formatter object.
   */
  public function getFormatter();

}
