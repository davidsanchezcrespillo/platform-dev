<?php

/**
 * @file
 * Contains BackendFactoryTest.
 */

namespace Drupal\nexteuropa_integration\Tests\Backend;

use Drupal\nexteuropa_integration\Backend\BackendFactory;
use Drupal\nexteuropa_integration\Tests\AbstractTest;

/**
 * Class BackendFactoryTest.
 *
 * @package Drupal\nexteuropa_integration\Tests\Backend
 */
class BackendFactoryTest extends AbstractTest {

  /**
   * Test create method.
   */
  public function testFactory() {
    $backend_info = nexteuropa_integration_backend_get_backend_info();
    $backend_class = $backend_info[$this->backendConfiguration->getType()]['class'];

    $backend = BackendFactory::getInstance('test_configuration');

    $reflection = new \ReflectionClass($backend);
    $this->assertEquals($backend_class, $reflection->getName());
  }

}
