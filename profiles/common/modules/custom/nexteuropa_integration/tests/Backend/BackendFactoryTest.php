<?php

/**
 * @file
 * Contains BackendFactoryTest.
 */

namespace Drupal\nexteuropa_integration\Tests\Backend;

use Drupal\nexteuropa_integration\Backend\BackendFactory;
use Drupal\nexteuropa_integration\Backend\Configuration\BackendConfiguration;
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
    $data = $this->getConfigurationFixture('backend', 'test_configuration');

    /** @var BackendConfiguration $configuration */
    $configuration = entity_create('integration_backend', (array) $data);
    $configuration->save();

    $backend = BackendFactory::getInstance('test_configuration');


    $configuration->delete();
  }

}
