<?php

/**
 * @file
 * Contains DefaultFieldHandler.
 */

namespace Drupal\nexteuropa_integration\Producer\FieldHandlers;

/**
 * Class DefaultFieldHandler.
 *
 * @package Drupal\nexteuropa_integration\Producer\FieldHandlers
 */
class DefaultFieldHandler extends AbstractFieldHandler {

  /**
   * {@inheritdoc}
   */
  public function processField() {

    foreach ($this->getFieldValues() as $value) {
      if (is_array($value)) {
        foreach ($value as $column_name => $column_value) {
          $this->getDocument()->setField($this->fieldName . '_' . $column_name, $column_value);
        }
      }
      else {
        $this->getDocument()->setField($this->fieldName, $value);
      }
    }
  }

}
