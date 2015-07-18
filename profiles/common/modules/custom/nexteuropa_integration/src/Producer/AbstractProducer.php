<?php

/**
 * @file
 * Contains \Drupal\nexteuropa_integration\Producer\AbstractProducer.
 */

namespace Drupal\nexteuropa_integration\Producer;

use Drupal\nexteuropa_integration\Document\DocumentInterface;
use Drupal\nexteuropa_integration\Document\Formatter\FormatterInterface;
use Drupal\nexteuropa_integration\Producer\EntityWrapper\DefaultEntityWrapper;
use Drupal\nexteuropa_integration\Producer\FieldHandlers\DefaultFieldHandler;
use Drupal\nexteuropa_integration\Producer\FieldHandlers\FieldHandlerInterface;

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
  public function getFormatter() {
    return $this->formatter;
  }

  /**
   * {@inheritdoc}
   */
  public function getProducerId() {
    // @todo: fetch this from system settings.
    return 'temp-producer-id';
  }

  /**
   * {@inheritdoc}
   */
  protected function getFieldHandler($field_name, $language) {
    // @todo: get field handler by type, atm only returns default.
    return new DefaultFieldHandler($field_name, $language, $this->getEntityWrapper(), $this->getDocument());
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    // Set document metadata.
    $this->getDocument()->setMetadata('type', $this->getDocumentType());
    $this->getDocument()->setMetadata('producer_id', $this->getProducerId());
    $this->getDocument()->setMetadata('producer_content_id', $this->getProducerContentId());
    $this->getDocument()->setMetadata('created', $this->getDocumentCreationDate());
    $this->getDocument()->setMetadata('changed', $this->getDocumentUpdateDate());

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

  /**
   * {@inheritdoc}
   */
  public function render() {
    $document = $this->build();
    return $this->formatter->format($document);
  }

}
