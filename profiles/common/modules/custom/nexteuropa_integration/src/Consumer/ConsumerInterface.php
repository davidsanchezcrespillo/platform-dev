<?php

/**
 * @file
 * Contains Drupal\nexteuropa_integration\Consumer\ConsumerInterface.
 */

namespace Drupal\nexteuropa_integration\Consumer;

use Drupal\nexteuropa_integration\Backend\BackendInterface;
use Drupal\nexteuropa_integration\Consumer\Configuration\ConsumerConfigurationInterface;
use Drupal\nexteuropa_integration\Document\DocumentInterface;

/**
 * Interface ConsumerInterface.
 *
 * @package Drupal\nexteuropa_integration\Consumer
 */
interface ConsumerInterface {

  /**
   * Define source key, to be used in setMap().
   *
   * @return array
   *    Get default source key definition.
   */
  public function getSourceKey();

  /**
   * Register a new consumer migration given its configuration.
   *
   * @param string $configuration
   *    Consumer configuration machine name.
   */
  public static function register($configuration);
}
