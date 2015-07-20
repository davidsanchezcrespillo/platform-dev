<?php

/**
 * @file
 * Contains TextWithSummaryFieldHandler.
 */

namespace Drupal\nexteuropa_integration\Producer\FieldHandlers;

/**
 * Class DefaultFieldHandler.
 *
 * @package Drupal\nexteuropa_integration\Producer\FieldHandlers
 */
class TextWithSummaryFieldHandler extends AbstractFieldHandler {

  /**
   * {@inheritdoc}
   */
  public function processField() {

    foreach ($this->getFieldValues() as $value) {
      $this->getDocument()->setField($this->fieldName, $value['safe_value']);
      $this->getDocument()->setField($this->fieldName . '_summary', $value['safe_summary']);
    }
  }

}
