<?php

/**
 * @file
 * Contains AbstractFieldHandler.
 */

namespace Drupal\nexteuropa_integration\Producer\FieldHandlers;

use Drupal\nexteuropa_integration\Document\DocumentInterface;
use Drupal\nexteuropa_integration\Producer\EntityWrapper\DefaultEntityWrapper;
use Drupal\nexteuropa_integration\Document\Document;

/**
 * Class AbstractFieldHandler.
 *
 * @package Drupal\nexteuropa_integration\Producer\FieldHandlers
 */
abstract class AbstractFieldHandler implements FieldHandlerInterface {

  /**
   * Field name the handler is instantiated with.
   *
   * @var string
   */
  protected $fieldName = NULL;

  /**
   * Language the handler is instantiated with.
   *
   * @var string
   */
  protected $language = NULL;

  /**
   * Entity wrapper.
   *
   * @var DefaultEntityWrapper
   */
  protected $entityWrapper = NULL;

  /**
   * Document handler instance.
   *
   * @var DocumentInterface
   */
  protected $document = NULL;

  /**
   * Constructor.
   *
   * @param DefaultEntityWrapper $entity_wrapper
   *    Entity object.
   * @param DocumentInterface $document
   *    Document object.
   */
  public function __construct($field_name, $language, DefaultEntityWrapper $entity_wrapper, DocumentInterface $document) {
    $this->language = $language;
    $this->fieldName = $field_name;
    $this->entityWrapper = $entity_wrapper;
    $this->document = $document;
  }

  /**
   * {@inheritdoc}
   */
  public function getFieldValue() {
    return $this->getEntityWrapper()->getField($this->fieldName, $this->language);
  }

  /**
   * {@inheritdoc}
   */
  public function process() {
    $this->getDocument()->setCurrentLanguage($this->language);
    $this->processField();
    $this->getDocument()->setCurrentLanguage($this->getDocument()->getDefaultLanguage());
  }

  /**
   * {@inheritdoc}
   */
  public function getEntityWrapper() {
    return $this->entityWrapper;
  }

  /**
   * {@inheritdoc}
   */
  public function getDocument() {
    return $this->document;
  }

}
