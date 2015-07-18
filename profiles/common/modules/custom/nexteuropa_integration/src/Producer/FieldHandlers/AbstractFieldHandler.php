<?php

/**
 * @file
 * Contains AbstractFieldHandler.
 */

namespace Drupal\nexteuropa_integration\Producer\FieldHandlers;

use Drupal\nexteuropa_integration\DocumentInterface;
use Drupal\nexteuropa_integration\Producer\EntityWrapper\DefaultEntityWrapper;
use Drupal\nexteuropa_integration\Document;

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
   * Return field value for current language.
   *
   * @return array|string
   *    Current field value.
   */
  public function getFieldValue() {
    return $this->getEntityWrapper()->getField($this->fieldName, $this->language);
  }

  /**
   * Process current field.
   */
  public function process() {
    $this->getDocument()->setCurrentLanguage($this->language);
    $this->processField();
    $this->getDocument()->setCurrentLanguage($this->getDocument()->getDefaultLanguage());
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

}
