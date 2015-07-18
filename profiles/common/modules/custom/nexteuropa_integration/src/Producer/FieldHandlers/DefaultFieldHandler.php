<?php

/**
 * @file
 * Contains DefaultFieldHandler.
 */

namespace Drupal\nexteuropa_integration\Producer\FieldHandlers;

use Drupal\nexteuropa_integration\Producer\EntityWrapper\DefaultEntityWrapper;
use Drupal\nexteuropa_integration\Document\Document;

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
    $value = $this->getFieldValue();
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
