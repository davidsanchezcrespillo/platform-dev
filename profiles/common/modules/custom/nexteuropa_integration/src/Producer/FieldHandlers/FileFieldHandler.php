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
      $this->getDocument()->setField($this->fieldName . '_path', file_create_url($value['uri']));
      $this->getDocument()->setField($this->fieldName . '_size', $value['filesize']);
      $this->getDocument()->setField($this->fieldName . '_mime', $value['filemime']);
      $this->getDocument()->setField($this->fieldName . '_status', $value['status']);
    }
  }

}
