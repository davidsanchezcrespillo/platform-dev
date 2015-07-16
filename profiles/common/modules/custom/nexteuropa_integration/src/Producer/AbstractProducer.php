<?php

/**
 * @file
 * Contains \Drupal\nexteuropa_integration\Producer\AbstractProducer.
 */

namespace Drupal\nexteuropa_integration\Producer;

use Drupal\nexteuropa_integration\Document\Formatter\FormatterInterface;
use Drupal\nexteuropa_integration\DocumentInterface;
use Drupal\nexteuropa_integration\Producer\FieldHandlers\FieldHandlerInterface;

/**
 * Class AbstractProducer.
 *
 * @package Drupal\nexteuropa_integration\Producer
 */
abstract class AbstractProducer implements ProducerInterface {

  /**
   * Field handler instance.
   *
   * @var FieldHandlerInterface
   */
  private $fieldHandler = NULL;

  /**
   * Document handler instance.
   *
   * @var DocumentInterface
   */
  private $document = NULL;

  /**
   * Constructor.
   *
   * @param string $entity_type
   *    Entity type.
   * @param object $entity
   *    Entity object.
   * @param FieldHandlerInterface $field_handler
   *    Field handler object.
   * @param DocumentInterface $document
   *    Document object.
   * @param FormatterInterface $formatter
   *    Formatter object.
   */
  public function __construct($entity_type, $entity, FieldHandlerInterface $field_handler, DocumentInterface $document, FormatterInterface $formatter) {

  }

}
