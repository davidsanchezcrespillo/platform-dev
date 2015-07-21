<?php

/**
 * @file
 * Contains Drupal\nexteuropa_integration\Tests\Producer\ProducerTest.
 */

namespace Drupal\nexteuropa_integration\Tests\Producer;

use Drupal\nexteuropa_integration\Document\Document;
use Drupal\nexteuropa_integration\Producer\NodeProducer;
use Drupal\nexteuropa_integration\Document\DocumentInterface;
use Drupal\nexteuropa_integration\Document\Formatter\FormatterInterface;
use Drupal\nexteuropa_integration\Producer\EntityWrapper\EntityWrapper;
use Drupal\nexteuropa_integration\Producer\FieldHandlers\FieldHandlerInterface;
use Drupal\nexteuropa_integration\Document\Formatter\JsonFormatter;
use Drupal\nexteuropa_integration\Tests\AbstractTest;
use \Mockery as m;

/**
 * Class BackendTest.
 *
 * @package Drupal\nexteuropa_integration\Tests\Producer\ProducerTest
 */
class ProducerTest extends AbstractTest {

  /**
   * Entity wrapper mock.
   *
   * @var \Mockery\MockInterface
   */
  protected $entityWrapper;

  /**
   * Document mock.
   *
   * @var \Mockery\MockInterface
   */
  protected $document;

  /**
   * Formatter mock.
   *
   * @var \Mockery\MockInterface
   */
  protected $formatter;

  /**
   * Setup PHPUnit hook.
   */
  public function setUp() {
    $this->entityWrapper = m::mock('Drupal\nexteuropa_integration\Producer\EntityWrapper\EntityWrapper');
    $this->document = m::mock('Drupal\nexteuropa_integration\Document\DocumentInterface');
    $this->formatter = m::mock('Drupal\nexteuropa_integration\Document\Formatter\FormatterInterface');

    $GLOBALS['base_url'] = 'http://example.com';
  }

  /**
   * Tear down PHPUnit hook.
   */
  public function tearDown() {
    m::close();
  }

  /**
   * Test creation of a producer instance.
   */
  public function testInstance() {

    $producer = new NodeProducer($this->entityWrapper, $this->document, $this->formatter);
    $reflection = new \ReflectionClass($producer);
    $this->assertEquals('Drupal\nexteuropa_integration\Producer\AbstractProducer', $reflection->getParentClass()->getName());
  }

  /**
   * Test build method.
   */
  public function testBuild() {
    $node = $this->getExportedEntityFixture('integration_test', 1);

    $producer = $this->getNodeProducerInstance($node);
    $document = $producer->build();

    $this->assertEquals('integration_test', $document->getMetadata('type'));
    $this->assertEquals('2015-07-20 06:42:47', $document->getMetadata('created'));
    $this->assertEquals('2015-07-20 06:42:47', $document->getMetadata('changed'));
    $this->assertEquals('en', $document->getMetadata('default_language'));
    $this->assertEquals('temp-producer-id', $document->getMetadata('producer_id'));
    $this->assertEquals(array('en', 'fr'), $document->getAvailableLanguages());

    $this->assertEquals('2015-03-16 15:30:45', $document->getFieldValue('field_integration_test_dates_start'));
    $this->assertEquals('2015-03-16 15:30:45', $document->getFieldValue('field_integration_test_dates_end'));
    $this->assertEquals('UTC', $document->getFieldValue('field_integration_test_dates_timezone'));

    $document->setCurrentLanguage('en');
    $this->assertEquals('English title article 1', $document->getFieldValue('title_field'));
    $this->assertContains('http://example.com/sites/default/files/file-english-1.txt', $document->getFieldValue('field_integration_test_files_path'));
    $this->assertContains('http://example.com/sites/default/files/file-english-2.txt', $document->getFieldValue('field_integration_test_files_path'));
    $this->assertContains('<p>English abstract article 1</p>', $document->getFieldValue('body'));
    $this->assertEmpty($document->getFieldValue('body_summary'));

    $document->setCurrentLanguage('fr');
    $this->assertEquals('French title article 1', $document->getFieldValue('title_field'));
    $this->assertContains('http://example.com/sites/default/files/file-french-1.txt', $document->getFieldValue('field_integration_test_files_path'));
    $this->assertContains('http://example.com/sites/default/files/file-french-2.txt', $document->getFieldValue('field_integration_test_files_path'));
    $this->assertContains('<p>French abstract article 1</p>', $document->getFieldValue('body'));
    $this->assertEmpty($document->getFieldValue('body_summary'));
  }

  /**
   * Test render method.
   */
  public function testRender() {
    $node = $this->getExportedEntityFixture('node', 1);

    $entity_wrapper = new EntityWrapper('node', $node);
    $document = new Document();
    $formatter = new JsonFormatter();
    $producer = new NodeProducer($entity_wrapper, $document, $formatter);
    $output = $producer->render();

    $expected = $this->getRenderedEntityFixture('node', 1);
    $this->assertEquals(json_decode($expected), json_decode($output));
  }

  /**
   * Test entity wrapper.
   */
  public function testEntityWrapper() {
    $node = $this->getExportedEntityFixture('node', 1);
    $wrapper = new EntityWrapper('node', $node);

    $properties = array(
      'nid',
      'vid',
      'type',
      'title',
      'language',
      'status',
      'promote',
      'created',
      'changed',
      'author',
    );
    foreach ($properties as $property) {
      $this->assertTrue($wrapper->isProperty($property));
    }

    $this->assertEquals('article', $wrapper->getProperty('type'));
    $this->assertEquals('2015-07-17 12:00:52', $wrapper->getProperty('created'));

    $fields = array(
      'body',
      'field_tags',
      'field_image',
      'title_field',
    );
    foreach ($fields as $field) {
      $this->assertTrue($wrapper->isField($field));
    }

    $this->assertEquals(array('en', 'fr'), $wrapper->getAvailableLanguages());

    $this->assertEquals('Title EN', $wrapper->getField('title_field', 'en'));
    $this->assertEquals('Title FR', $wrapper->getField('title_field', 'fr'));
  }

}
