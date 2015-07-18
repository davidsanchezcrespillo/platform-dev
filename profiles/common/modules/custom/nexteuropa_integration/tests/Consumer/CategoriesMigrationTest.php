<?php

/**
 * @file
 * Contains CategoriesMigrationTest class.
 */

namespace Drupal\nexteuropa_integration\Tests\Consumer;

use Drupal\nexteuropa_integration\Document\Document;

/**
 * Class CategoriesMigrationTest.
 *
 * @package Drupal\nexteuropa_integration\Tests\Consumer
 */
class CategoriesMigrationTest extends MigrateAbstractTest {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
    \Migration::getInstance('NextEuropaIntegrationTestCategories')->processImport();
  }

  /**
   * Testing Content migration.
   */
  public function testContentMigration() {
    $migration = \Migration::getInstance('NextEuropaIntegrationTestCategories');

    foreach ($this->fixtures['taxonomy_term'] as $id => $fixture) {
      $mapping_row = $migration->getMap()->getRowBySource(array('_id' => $id));

      $raw_document = $this->getDocument('taxonomy_term', $id);
      $source = new Document($raw_document);

      $taxonomy_term = taxonomy_term_load($mapping_row['destid1']);
      foreach (array('en', 'fr') as $language) {
        $source->setCurrentLanguage($language);

        // Assert that title has been imported correctly.
        $this->assertEquals($source->getFieldValue('name'), $taxonomy_term->name_field[$language][0]['value']);
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function tearDown() {
    parent::tearDown();
    \Migration::getInstance('NextEuropaIntegrationTestCategories')->processRollback();
  }

}
