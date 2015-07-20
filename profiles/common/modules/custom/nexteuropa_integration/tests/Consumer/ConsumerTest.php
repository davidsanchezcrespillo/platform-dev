<?php

/**
 * @file
 * Contains Drupal\nexteuropa_integration\Tests\Consumer\ConsumerTest.
 */

namespace Drupal\nexteuropa_integration\Tests\Consumer;

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
  public function testInstance() {

    $settings = new \stdClass();
    $settings->label = 'Test consumer';
    $settings->name = 'test_consumer';
    $settings->status = TRUE;
    $settings->backend = 'filesystem';
    $settings->entity_type = 'node';
    $settings->bundle = 'article';
    $settings->mapping = array(
      'title_field' => array('title', 'title_field'),
      'body' => array('body'),
    );

    $arguments = array();
    $arguments['consumer_settings'] = $settings;

    \Migration::registerMigration('Drupal\nexteuropa_integration\Consumer\Consumer', 'test_migration', $arguments);

    $migration = \Migration::getInstance('test_migration');

    return;
  }

}
