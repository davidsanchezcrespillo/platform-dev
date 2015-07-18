<?php

/**
 * @file
 * Contains \Drupal\nexteuropa_integration\Producer\NodeProducer.
 */

namespace Drupal\nexteuropa_integration\Producer;

use Drupal\nexteuropa_integration\Document;
use Drupal\nexteuropa_integration\Document\Formatter\FormatterInterface;
use Drupal\nexteuropa_integration\DocumentInterface;
use Drupal\nexteuropa_integration\Producer\FieldHandlers\DefaultFieldHandler;
use Drupal\nexteuropa_integration\Producer\FieldHandlers\FieldHandlerInterface;

/**
 * Class NodeProducer.
 *
 * @package Drupal\nexteuropa_integration\Producer
 */
class NodeProducer extends AbstractProducer {

  /**
   * Build document object using the entity the producer was instantiated with.
   *
   * @return DocumentInterface
   *    Built document object.
   */
  public function build() {

    // Set document metadata.
    $properties = array(
      'type',
      'created',
      'changed',
    );
    foreach ($properties as $name) {
      $this->getDocument()->setMetadata($name, $this->getEntityWrapper()->getProperty($name));
    }

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
   * Returns field handler interface.
   *
   * @param string $field_name
   *    Current field name.
   * @param string $language
   *    Current field language code.
   *
   * @return FieldHandlerInterface
   *    Field handler instance.
   */
  protected function getFieldHandler($field_name, $language) {
    // @todo: get field handler by type, atm only returns default.
    return new DefaultFieldHandler($field_name, $language, $this->getEntityWrapper(), $this->getDocument());
  }

}
