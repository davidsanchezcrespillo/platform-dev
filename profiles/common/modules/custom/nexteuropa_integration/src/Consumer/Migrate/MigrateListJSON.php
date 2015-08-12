<?php

/**
 * @file
 * Contains \Drupal\nexteuropa_integration\Consumer\Migrate\MigrateListJSON.
 */

namespace Drupal\nexteuropa_integration\Consumer\Migrate;

use Drupal\nexteuropa_integration\Document\Document;

// @codingStandardsIgnoreStart

/**
 * Class MigrateListJSON.
 *
 * @package Drupal\nexteuropa_integration\Consumer\Migrate
 *
 * @todo: move this class under Backend namespace.
 */
class MigrateListJSON extends \MigrateListJSON {

  /**
   * {@inheritdoc}
   */
  protected function getIDsFromJSON(array $data) {
    $return = array();
    foreach ($data['results'] as $item) {
      $return[] = $item['id'];
    }
    return $return;
  }

}
// @codingStandardsIgnoreEnd
