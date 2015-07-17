<?php

/**
 * @file
 * Contains \Drupal\nexteuropa_integration\Producer\NodeProducer.
 */

namespace Drupal\nexteuropa_integration\Producer;

use Drupal\nexteuropa_integration\Document;
use Drupal\nexteuropa_integration\Document\Formatter\FormatterInterface;
use Drupal\nexteuropa_integration\DocumentInterface;

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
    // @todo: improve this part by using field handlers, name altering, etc.
    foreach ($this->getEntityWrapper()->getAvailableLanguages() as $language) {
      $this->getDocument()->setCurrentLanguage($language);
      foreach ($this->getEntityWrapper()->getFieldList() as $field_name) {
        $value = $this->getEntityWrapper()->getField($field_name, $language);
        if (is_array($value)) {
          foreach ($value as $column_name => $column_value) {
            $this->getDocument()->setField($field_name . '_' . $column_name, $column_value);
          }
        }
        else {
          $this->getDocument()->setField($field_name, $value);
        }
      }
    }

    $document = $this->getDocument();
    drupal_alter('nexteuropa_integration_producer_document_build', $document);
    return $document;
  }

}
