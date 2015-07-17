<?php

/**
 * @file
 * Contains \Drupal\nexteuropa_integration\Producer\AbstractProducer.
 */

namespace Drupal\nexteuropa_integration\Producer;

use Drupal\nexteuropa_integration\DocumentInterface;
use Drupal\nexteuropa_integration\Document\Formatter\FormatterInterface;
use Drupal\nexteuropa_integration\Producer\EntityWrapper\DefaultEntityWrapper;

/**
 * Class AbstractProducer.
 *
 * @package Drupal\nexteuropa_integration\Producer
 */
abstract class AbstractProducer implements ProducerInterface {

  /**
   * Entity wrapper.
   *
   * @var DefaultEntityWrapper
   */
  private $entityWrapper = NULL;

  /**
   * Document handler instance.
   *
   * @var DocumentInterface
   */
  private $document = NULL;

  /**
   * Formatter instance.
   *
   * @var FormatterInterface
   */
  private $formatter = NULL;

  /**
   * Constructor.
   *
   * @param DefaultEntityWrapper $entity_wrapper
   *    Entity object.
   * @param DocumentInterface $document
   *    Document object.
   * @param FormatterInterface $formatter
   *    Formatter object.
   */
  public function __construct(DefaultEntityWrapper $entity_wrapper, DocumentInterface $document, FormatterInterface $formatter) {
    $this->entityWrapper = $entity_wrapper;
    $this->document = $document;
    $this->formatter = $formatter;
  }

  /**
   * Entity wrapper the producer has been instantiated with.
   *
   * @return DefaultEntityWrapper
   *    Entity wrapper object.
   */
  public function getEntityWrapper() {
    return $this->entityWrapper;
  }

  /**
   * Get document handler the producer has been instantiated with.
   *
   * @return DocumentInterface
   *    Document object.
   */
  public function getDocument() {
    return $this->document;
  }

  /**
   * Get Formatter the producer has been instantiated with.
   *
   * @return FormatterInterface
   *    Formatter object.
   */
  public function getFormatter() {
    return $this->formatter;
  }

}
