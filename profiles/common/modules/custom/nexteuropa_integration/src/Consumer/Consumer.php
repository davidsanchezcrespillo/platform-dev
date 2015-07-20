<?php

/**
 * @file
 * Contains Drupal\nexteuropa_integration\Consumer\Consumer.
 */

namespace Drupal\nexteuropa_integration\Consumer;
use Drupal\nexteuropa_integration\Consumer\Migrate\AbstractMigration;

/**
 * Interface ConsumerInterface.
 *
 * @package Drupal\nexteuropa_integration\Consumer
 */
class Consumer extends AbstractMigration implements ConsumerInterface {

  /**
   * Define source key, to be used in setMap().
   *
   * @return array
   *    Get default source key definition.
   */
  public function getSourceKey() {
    return array(
      '_id' => array(
        'type' => 'varchar',
        'length' => 255,
        'not null' => TRUE,
      ),
    );
  }

}
