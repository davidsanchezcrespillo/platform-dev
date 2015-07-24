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
   * Get backend object.
   *
   * @return BackendInterface
   *    Backend object.
   */
  public function getBackend();

  /**
   * Set configuration object.
   *
   * @param BackendInterface $backend
   *    Backend object.
   */
  public function setBackend(BackendInterface $backend);

}
