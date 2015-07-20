<?php

/**
 * @file
 * Contains NextEuropaIntegrationTestAbstractMigration class.
 */

use Drupal\nexteuropa_integration\Consumer\Migrate\MigrateItemJSON;
use Drupal\nexteuropa_integration\Consumer\Migrate\AbstractMigration;

/**
 * Class NextEuropaIntegrationTestAbstractMigration.
 */
abstract class NextEuropaIntegrationTestAbstractMigration extends AbstractMigration {

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

  /**
   * Constructor.
   *
   * @param string $type
   *    Document type, used to identify the correct fixture directory.
   * @param mixed $arguments
   *    Default constructor arguments.
   */
  public function __construct($type, $arguments) {
    parent::__construct($arguments);

    $base_path = drupal_get_path('module', 'nexteuropa_integration_test') . '/fixtures/' . $type;
    $this->setSource(new MigrateSourceList(
      new \MigrateListJSON($base_path . '/list.json'),
      new MigrateItemJSON($base_path . '/document-:id.json', array()),
      array()
    ));
  }

}
