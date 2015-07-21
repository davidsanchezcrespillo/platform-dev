<?php

/**
 * @file
 * Contains FileFieldHandler.
 */

namespace Drupal\nexteuropa_integration\Producer\FieldHandlers;

/**
 * Class DefaultFieldHandler.
 *
 * @package Drupal\nexteuropa_integration\Producer\FieldHandlers
 */
class FileFieldHandler extends AbstractFieldHandler {

  /**
   * {@inheritdoc}
   */
  public function processField() {

    foreach ($this->getFieldValues() as $value) {

      $uri = $value ? file_create_url($value['uri']) : '';
      $filesize = $value ? $value['filesize'] : '';
      $filemime = $value ? $value['filemime'] : '';
      $status = $value ? $value['status'] : '';

      $this->getDocument()->addFieldValue($this->fieldName . '_path', $uri);
      $this->getDocument()->addFieldValue($this->fieldName . '_size', $filesize);
      $this->getDocument()->addFieldValue($this->fieldName . '_mime', $filemime);
      $this->getDocument()->addFieldValue($this->fieldName . '_status', $status);
    }
  }

}
