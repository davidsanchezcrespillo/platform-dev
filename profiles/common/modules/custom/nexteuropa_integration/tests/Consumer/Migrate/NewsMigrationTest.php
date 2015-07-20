<?php

/**
 * @file
 * Contains NewsMigrationTest class.
 */

namespace Drupal\nexteuropa_integration\Tests\Consumer\Migrate;

use Drupal\nexteuropa_integration\Document\Document;

/**
 * Class NewsMigrationTest.
 *
 * @package Drupal\nexteuropa_integration\Tests\Consumer\Migrate
 */
class NewsMigrationTest extends AbstractMigrateTest {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
    \Migration::getInstance('NextEuropaIntegrationTestNews')->processImport();
  }

  /**
   * Testing Content migration.
   */
  public function testContentMigration() {
    $migration = \Migration::getInstance('NextEuropaIntegrationTestNews');

    foreach ($this->fixtures['news'] as $id => $fixture) {
      $mapping_row = $migration->getMap()->getRowBySource(array('_id' => $id));

      $raw_document = $this->getDocument('news', $id);
      $source = new Document($raw_document);

      $node = node_load($mapping_row['destid1']);
      foreach (array('en', 'fr') as $language) {
        $source->setCurrentLanguage($language);

        // Assert that title has been imported correctly.
        $this->assertEquals($source->getFieldValue('title'), $node->title_field[$language][0]['value']);

        // Assert that body has been imported correctly.
        // @see: NextEuropaIntegrationTestNewsMigration::prepareRow().
        $abstract = 'Processed ' . $source->getFieldValue('abstract');
        $this->assertEquals($abstract, $node->body[$language][0]['value']);
      }

      // Assert that default language has been imported correctly.
      $this->assertEquals($source->getDefaultLanguage(), $node->language);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function tearDown() {
    parent::tearDown();
    \Migration::getInstance('NextEuropaIntegrationTestNews')->processRollback();
  }

}
