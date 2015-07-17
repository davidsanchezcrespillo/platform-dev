<?php

/**
 * @file
 * Contains Drupal\nexteuropa_integration\Tests\Producer\ProducerTest.
 */

namespace Drupal\nexteuropa_integration\Tests\Producer;

use Drupal\nexteuropa_integration\Producer\DefaultProducer;
use Drupal\nexteuropa_integration\DocumentInterface;
use Drupal\nexteuropa_integration\Document\Formatter\FormatterInterface;
use Drupal\nexteuropa_integration\Producer\FieldHandlers\FieldHandlerInterface;
use \Mockery as m;

/**
 * Class BackendTest.
 *
 * @package Drupal\nexteuropa_integration\Tests\Producer\ProducerTest
 */
class ProducerTest extends \PHPUnit_Framework_TestCase {

  private $entity;
  private $fieldHandler;
  private $document;
  private $formatter;

  /**
   * Setup PHPUnit hook.
   */
  public function setUp() {
    $this->entity = m::mock('EntityDrupalWrapper');
    $this->fieldHandler = m::mock('Drupal\nexteuropa_integration\Producer\FieldHandlers\FieldHandlerInterface');
    $this->document = m::mock('Drupal\nexteuropa_integration\DocumentInterface');
    $this->formatter = m::mock('Drupal\nexteuropa_integration\Document\Formatter\FormatterInterface');
  }

  /**
   * Test creation of a producer instance.
   */
  public function testProducerInstance() {

    $producer = new DefaultProducer('node', $this->entity, $this->fieldHandler, $this->document, $this->formatter);
    $reflection = new \ReflectionClass($producer);
    $this->assertEquals('Drupal\nexteuropa_integration\Producer\AbstractProducer', $reflection->getParentClass()->getName());
  }

  /**
   * Tear down PHPUnit hook.
   */
  public function tearDown() {
    m::close();
  }

}
