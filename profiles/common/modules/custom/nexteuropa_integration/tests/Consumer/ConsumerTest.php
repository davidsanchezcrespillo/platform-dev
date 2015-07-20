<?php

/**
 * @file
 * Contains Drupal\nexteuropa_integration\Tests\Consumer\ConsumerTest.
 */

namespace Drupal\nexteuropa_integration\Tests\Consumer;

use Drupal\nexteuropa_integration\Consumer\Configuration\ConsumerConfiguration;
use Drupal\nexteuropa_integration\Consumer\Consumer;
use Drupal\nexteuropa_integration\Document\DocumentInterface;
use Drupal\nexteuropa_integration\Document\Formatter\FormatterInterface;
use Drupal\nexteuropa_integration\Producer\EntityWrapper\EntityWrapper;
use Drupal\nexteuropa_integration\Producer\FieldHandlers\FieldHandlerInterface;
use Drupal\nexteuropa_integration\Document\Formatter\JsonFormatter;
use \Mockery as m;

/**
 * Class ConsumerTest.
 *
 * @package Drupal\nexteuropa_integration\Tests\Consumer
 */
class ConsumerTest extends \PHPUnit_Framework_TestCase {

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
   * Test creation of a consumer instance.
   */
  public function testConsumerConfiguration() {

    $configuration = new ConsumerConfiguration('Label', 'name', 'node', 'article');

    $this->assertEquals('Label', $configuration->getLabel());
    $this->assertEquals('name', $configuration->getName());
    $this->assertEquals('node', $configuration->getEntityType());
    $this->assertEquals('article', $configuration->getBundle());
    $this->assertEquals(TRUE, $configuration->getStatus());

    $settings = new \stdClass();
    $settings->label = 'Label';
    $settings->name = 'name';
    $settings->status = TRUE;
    $settings->backend = 'backend';
    $settings->entity_type = 'node';
    $settings->bundle = 'article';
    $settings->mapping = array(
      'source1' => 'destination1',
      'source2' => 'destination2',
    );
    $settings->options = array(
      'option1' => 'value1',
      'option2' => 'value2',
    );

    $configuration = ConsumerConfiguration::getInstance($settings);

    $this->assertEquals($settings->label, $configuration->getLabel());
    $this->assertEquals($settings->name, $configuration->getName());
    $this->assertEquals($settings->entity_type, $configuration->getEntityType());
    $this->assertEquals($settings->bundle, $configuration->getBundle());
    $this->assertEquals($settings->status, $configuration->getStatus());
    $this->assertEquals($settings->mapping, $configuration->getMapping());
    $this->assertEquals($settings->options, $configuration->getOptions());
  }

}
