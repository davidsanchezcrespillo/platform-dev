<?php

/**
 * @file
 * Contains DateFieldHandler.
 */

namespace Drupal\nexteuropa_integration\Producer\FieldHandlers;

/**
 * Class DefaultFieldHandler.
 *
 * @package Drupal\nexteuropa_integration\Producer\FieldHandlers
 */
class DateFieldHandler extends AbstractFieldHandler {

  /**
   * Default Entity Wrapper date format.
   */
  const DEFAULT_DATE_FORMAT = 'Y-m-d H:i:s';

  /**
   * {@inheritdoc}
   */
  public function processField() {

    foreach ($this->getFieldValues() as $value) {

      // Make sure we always have an end date, same as start date if none given.
      $value['value2'] = isset($value['value2']) ? $value['value'] : NULL;

      // Make sure we convert timestamp into default date format.
      if ($value['date_type'] == 'datestamp') {
        $value['value'] = date(self::DEFAULT_DATE_FORMAT, $value['value']);
        $value['value2'] = date(self::DEFAULT_DATE_FORMAT, $value['value2']);
      }

      // Set field values on document.
      $this->getDocument()->addFieldValue($this->fieldName . '_start', $value['value']);
      $this->getDocument()->addFieldValue($this->fieldName . '_end', $value['value2']);
      $this->getDocument()->addFieldValue($this->fieldName . '_timezone', $value['timezone']);
    }
  }

}
