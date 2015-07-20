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
use Drupal\nexteuropa_integration\Producer\EntityWrapper\DefaultEntityWrapper;
use Drupal\nexteuropa_integration\Producer\FieldHandlers\FieldHandlerInterface;
use Drupal\nexteuropa_integration\Document\Formatter\JsonFormatter;
use \Mockery as m;

/**
 * Class BackendTest.
 *
 * @package Drupal\nexteuropa_integration\Tests\Producer\ProducerTest
 */
class ProducerTest extends \PHPUnit_Framework_TestCase {

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
    $this->entityWrapper = m::mock('Drupal\nexteuropa_integration\Producer\EntityWrapper\DefaultEntityWrapper');
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

    $entity_wrapper = new DefaultEntityWrapper('node', $node);
    $document = new Document();
    $formatter = new JsonFormatter();
    $producer = new NodeProducer($entity_wrapper, $document, $formatter);
    $document = $producer->build();

//    $this->assertEquals('article', $document->getMetadata('type'));
//    $this->assertEquals('2015-07-17 12:00:52', $document->getMetadata('created'));
//
//    $document->setCurrentLanguage('en');
//    $this->assertEquals('Title EN', $document->getFieldValues('title_field'));
//    $this->assertContains('Body EN', $document->getFieldValues('body_value'));
//
//    $document->setCurrentLanguage('fr');
//    $this->assertEquals('Title FR', $document->getFieldValues('title_field'));
//    $this->assertContains('Body FR', $document->getFieldValues('body_value'));

    return;
  }

  /**
   * Test render method.
   */
  public function testRender() {
    $node = $this->getExportedEntityFixture('node', 1);

    $entity_wrapper = new DefaultEntityWrapper('node', $node);
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
    $wrapper = new DefaultEntityWrapper('node', $node);

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

  /**
   * Get exported entity from fixture directory.
   *
   * @param string $type
   *    Entity type.
   * @param int $id
   *    Entity ID.
   *
   * @return \stdClass
   *    Entity object.
   */
  private function getExportedEntityFixture($type, $id) {
    static $entity_fixtures = array();
    if (!isset($entity_fixtures[$type][$id])) {
      $export = new \stdClass();
      include_once "fixtures/$type-$id.php";
      $entity_fixtures[$type][$id] = clone $export;
    }
    return $entity_fixtures[$type][$id];
  }

  /**
   * Get rendered entity from fixture directory.
   *
   * @param string $type
   *    Entity type.
   * @param int $id
   *    Entity ID.
   *
   * @return \stdClass
   *    Entity object.
   */
  protected function getRenderedEntityFixture($type, $id) {
    return file_get_contents(dirname(__FILE__) . "/fixtures/$type-$id.json");
  }

}
