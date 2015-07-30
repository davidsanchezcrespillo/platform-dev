<?php

/**
 * @file
 * Contains \Drupal\nexteuropa_integration\Consumer\MappingHandler\FileFieldMappingHandler
 */

namespace Drupal\nexteuropa_integration\Consumer\MappingHandler;

/**
 * Class FileFieldMappingHandler.
 *
 * @package Drupal\nexteuropa_integration\Consumer\MappingHandler
 */
class FileFieldMappingHandler extends AbstractMappingHandler {

  /**
   * {@inheritdoc}
   */
  public function process($destination_field, $source_field = NULL) {
    $field_info = field_info_field($destination_field);
    if (in_array($field_info['type'], array('image', 'file'))) {
      $this->getConsumer()->addFieldMapping("$destination_field:file_replace")->defaultValue(FILE_EXISTS_REPLACE);
    }
  }

}
