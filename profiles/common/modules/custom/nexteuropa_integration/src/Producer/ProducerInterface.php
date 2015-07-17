<?php

/**
 * @file
 * Contains Drupal\nexteuropa_integration\Producer\ProducerInterface.
 */

namespace Drupal\nexteuropa_integration\Producer;

use Drupal\nexteuropa_integration\DocumentInterface;
use Drupal\nexteuropa_integration\Producer\FieldHandlers\FieldHandlerInterface;
use Drupal\nexteuropa_integration\Document\Formatter\FormatterInterface;

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
   * @return \EntityDrupalWrapper
   *    Entity wrapper object.
   */
  public function getEntity();

  /**
   * Field handler the producer has been instantiated with.
   *
   * @return FieldHandlerInterface
   *    Field handler object.
   */
  public function getFieldHandler();

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
