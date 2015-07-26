<?php

/**
 * @file
 * Contains \Drupal\nexteuropa_integration\Producer\AbstractProducer.
 */

namespace Drupal\nexteuropa_integration\Producer;

use Drupal\nexteuropa_integration\Configuration\ConfigurableInterface;
use Drupal\nexteuropa_integration\Document\DocumentInterface;
use Drupal\nexteuropa_integration\Producer\EntityWrapper\EntityWrapper;

/**
 * Class AbstractProducer.
 *
 * @package Drupal\nexteuropa_integration\Producer
 */
abstract class AbstractProducer implements ProducerInterface, ConfigurableInterface {

  /**
   * Current schema version.
   */
  const SCHEMA_VERSION = 'v1';

  /**
   * Producer settings.
   *
   * @var null|object
   *    Producer settings object.
   */
  private $settings = NULL;

  /**
   * Entity wrapper.
   *
   * @var EntityWrapper
   */
  private $entityWrapper = NULL;

  /**
   * Document handler instance.
   *
   * @var DocumentInterface
   */
  private $document = NULL;

  /**
   * List of field handler definitions keyed by field type.
   *
   * @see nexteuropa_integration_producer_get_field_handlers()
   *
   * @var array[FieldHandlerInterface]
   */
  private $fieldHandlers = array();

  /**
   * Constructor.
   *
   * @param object $settings
   *    Producer settings.
   * @param EntityWrapper $entity_wrapper
   *    Entity object.
   * @param DocumentInterface $document
   *    Document object.
   */
  public function __construct($settings, EntityWrapper $entity_wrapper, DocumentInterface $document) {
    // @todo: make a proper object, in line with what done for the consumer.
    $this->settings = $settings;
    $this->entityWrapper = $entity_wrapper;
    $this->document = $document;
    $this->fieldHandlers = nexteuropa_integration_producer_get_field_handler_info();
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

  /**
   * {@inheritdoc}
   */
  public function getProducerId() {
    return $this->settings->name;
  }

  /**
   * {@inheritdoc}
   */
  protected function getFieldHandler($field_name, $language) {
    $field_info = field_info_field($field_name);
    $class = isset($this->fieldHandlers[$field_info['type']]) ? $this->fieldHandlers[$field_info['type']]['class'] : $this->fieldHandlers['default']['class'];
    return new $class($field_name, $language, $this->getEntityWrapper(), $this->getDocument());
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    // Set document metadata.
    $this->getDocument()->setMetadata('type', $this->getDocumentType());
    $this->getDocument()->setMetadata('producer', $this->getProducerId());
    $this->getDocument()->setMetadata('producer_content_id', $this->getProducerContentId());
    $this->getDocument()->setMetadata('created', $this->getDocumentCreationDate());
    $this->getDocument()->setMetadata('updated', $this->getDocumentUpdateDate());
    $this->getDocument()->setMetadata('version', self::SCHEMA_VERSION);

    // Set multilingual-related metadata.
    $this->getDocument()->setMetadata('languages', $this->getEntityWrapper()->getAvailableLanguages());
    $this->getDocument()->setMetadata('default_language', $this->getEntityWrapper()->getDefaultLanguage());

    // Set field values.
    foreach ($this->getEntityWrapper()->getAvailableLanguages() as $language) {
      foreach ($this->getEntityWrapper()->getFieldList() as $field_name) {
        $this->getFieldHandler($field_name, $language)->process();
      }
    }

    $document = $this->getDocument();
    drupal_alter('nexteuropa_integration_producer_document_build', $document);
    return $document;
  }

}
