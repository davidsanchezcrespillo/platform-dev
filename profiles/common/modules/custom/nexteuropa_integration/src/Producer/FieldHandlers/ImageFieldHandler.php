<?php

/**
 * @file
 * Contains ImageFieldHandler.
 */

namespace Drupal\nexteuropa_integration\Producer\FieldHandlers;

use Drupal\nexteuropa_integration\Producer\FieldHandlers\FileFieldHandler;

/**
 * Class ImageFieldHandler.
 *
 * @package Drupal\nexteuropa_integration\Producer\FieldHandlers
 */
class ImageFieldHandler extends FileFieldHandler {

  /**
   * {@inheritdoc}
   */
  public function processField() {
    parent::processField();

    foreach ($this->getFieldValues() as $value) {
      $this->getDocument()->addFieldValue($this->fieldName . '_alt', $value['alt']);
      $this->getDocument()->addFieldValue($this->fieldName . '_title', $value['title']);
    }
  }

}
