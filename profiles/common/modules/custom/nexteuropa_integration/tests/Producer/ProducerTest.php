<?php

/**
 * @file
 * Contains Drupal\nexteuropa_integration\Tests\Producer\ProducerTest.
 */

namespace Drupal\nexteuropa_integration\Tests\Producer;

use Drupal\nexteuropa_integration\Document\Document;
use Drupal\nexteuropa_integration\Producer\NodeProducer;
use Drupal\nexteuropa_integration\Document\DocumentInterface;
use Drupal\nexteuropa_integration\Producer\EntityWrapper\EntityWrapper;
use Drupal\nexteuropa_integration\Producer\FieldHandlers\FieldHandlerInterface;
use Drupal\nexteuropa_integration\Producer\ProducerFactory;
use Drupal\nexteuropa_integration\Tests\AbstractTest;
use \Mockery as m;

/**
 * Class BackendTest.
 *
 * @package Drupal\nexteuropa_integration\Tests\Producer\ProducerTest
 */
class ProducerTest extends AbstractTest {
  
  /**
   * Test creation of a producer instance.
   */
  public function testInstance() {

    $entity_wrapper = m::mock('Drupal\nexteuropa_integration\Producer\EntityWrapper\EntityWrapper');
    $document = m::mock('Drupal\nexteuropa_integration\Document\DocumentInterface');

    $producer = new NodeProducer($this->producer_configuration, $entity_wrapper, $document);
    $reflection = new \ReflectionClass($producer);
    $this->assertEquals('Drupal\nexteuropa_integration\Producer\AbstractProducer', $reflection->getParentClass()->getName());
  }

  /**
   * Test build method.
   */
  public function testBuild() {
    $node = $this->getExportedEntityFixture('node', 'integration_test', 3);
    $producer = ProducerFactory::getInstance('test_configuration', $node);

    $document = $producer->build();

    $this->assertEquals('integration_test', $document->getMetadata('type'));
    $this->assertEquals('2015-07-28 09:04:40', $document->getMetadata('created'));
    $this->assertEquals('2015-07-28 09:04:40', $document->getMetadata('updated'));
    $this->assertEquals('en', $document->getMetadata('default_language'));
    $this->assertEquals('producer-id', $document->getMetadata('producer'));
    $this->assertEquals(array('en', 'fr'), $document->getAvailableLanguages());

    $this->assertEquals('2015-03-16 15:30:45', $document->getFieldValue('field_integration_test_dates_start'));
    $this->assertEquals('2015-03-16 15:30:45', $document->getFieldValue('field_integration_test_dates_end'));
    $this->assertEquals('UTC', $document->getFieldValue('field_integration_test_dates_timezone'));

    $document->setCurrentLanguage('en');
    $this->assertEquals('English title article 1', $document->getFieldValue('title_field'));
    $this->assertContains('http://example.com/sites/default/files/file-english-1.txt', $document->getFieldValue('field_integration_test_files_path'));
    $this->assertContains('http://example.com/sites/default/files/file-english-2.txt', $document->getFieldValue('field_integration_test_files_path'));
    $this->assertContains('English abstract article 1', $document->getFieldValue('body'));
    $this->assertEmpty($document->getFieldValue('body_summary'));

    $document->setCurrentLanguage('fr');
    $this->assertEquals('French title article 1', $document->getFieldValue('title_field'));
    $this->assertContains('http://example.com/sites/default/files/file-french-1.txt', $document->getFieldValue('field_integration_test_files_path'));
    $this->assertContains('http://example.com/sites/default/files/file-french-2.txt', $document->getFieldValue('field_integration_test_files_path'));
    $this->assertContains('French abstract article 1', $document->getFieldValue('body'));
    $this->assertEmpty($document->getFieldValue('body_summary'));
  }

  /**
   * Test entity wrapper.
   */
  public function testEntityWrapper() {
    $node = $this->getExportedEntityFixture('node', 'integration_test', 1);
    $wrapper = new EntityWrapper('node', $node);

    $properties = array(
      'nid',
      'vid',
      'type',
      'title',
      'promote',
    );
    foreach ($properties as $property) {
      $this->assertTrue($wrapper->isProperty($property));
      $this->assertEquals($node->{$property}, $wrapper->getProperty($property));
    }
    $this->assertEquals(date(EntityWrapper::DEFAULT_DATE_FORMAT, $node->created), $wrapper->getProperty('created'));

    $fields = array(
      'body',
      'field_integration_test_dates',
      'field_integration_test_files',
      'title_field',
    );
    foreach ($fields as $field) {
      $this->assertTrue($wrapper->isField($field));
    }

    $this->assertEquals(array('en', 'fr'), $wrapper->getAvailableLanguages());
    foreach (array('en', 'fr') as $language) {
      $this->assertEquals($node->title_field[$language][0]['value'], $wrapper->getField('title_field', $language));
    }
  }

}
