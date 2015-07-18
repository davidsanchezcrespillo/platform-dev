<?php

/**
 * @file
 * Contains \Drupal\nexteuropa_integration\Consumer\Migrate\MigrateItemJSON.
 */

namespace Drupal\nexteuropa_integration\Consumer\Migrate;

use Drupal\nexteuropa_integration\Document\Document;

/**
 * Class MigrateItemJSON.
 *
 * @package Drupal\nexteuropa_integration\Consumer\Migrate
 */
class MigrateItemJSON extends \MigrateItemJSON {

  /**
   * {@inheritdoc}
   */
  public function getItem($id) {
    $current_item = parent::getItem($id);
    $document = new Document($current_item);
    return new DocumentWrapper($document);
  }

}
