<?php

/**
 * @file
 * Contains ConfigurationTest.
 */

namespace Drupal\nexteuropa_integration\Tests\Backend;

use Drupal\nexteuropa_integration\Backend\Configuration\BackendConfiguration;
use Drupal\nexteuropa_integration\Configuration\ConfigurationFactory;
use Drupal\nexteuropa_integration\Tests\AbstractTest;

/**
 * Class ConfigurationTest.
 *
 * @package Drupal\nexteuropa_integration\Tests\Backend
 */
class ConfigurationTest extends AbstractTest {

  /**
   * Test configuration entity CRUD operations.
   *
   * @dataProvider configurationProvider
   */
  public function testConfigurationEntityCrud($data) {

    $reflection = new \ReflectionClass($this->backendConfiguration);
    $this->assertEquals('Drupal\nexteuropa_integration\Backend\Configuration\BackendConfiguration', $reflection->getName());

    $this->assertEquals($data->machine_name, $this->backendConfiguration->identifier());
    $this->assertEquals(ENTITY_CUSTOM, $this->backendConfiguration->getStatus());
    $this->assertEquals($data->options['endpoint'], $this->backendConfiguration->getEndpoint());
    $this->assertEquals($data->options['base_path'], $this->backendConfiguration->getBasePath());

    $machine_name = $this->backendConfiguration->identifier();
    $this->assertNotNull(ConfigurationFactory::load('integration_backend', $machine_name));

    $this->backendConfiguration->delete();
    $this->assertFalse(ConfigurationFactory::load('integration_backend', $machine_name));
  }

  /**
   * Test export entity.
   *
   * @param object $data
   *    Configuration data.
   *
   * @dataProvider configurationProvider
   */
  public function testExportImport($data) {

    /** @var BackendConfiguration $configuration */
    $configuration = entity_create('integration_backend', (array) $data);

    $json = entity_export('integration_backend', $configuration);
    $decoded = json_decode($json);
    $this->assertNotNull($decoded);
    $this->assertEquals($data->machine_name, $decoded->machine_name);

    /** @var BackendConfiguration $entity */
    $entity = entity_import('integration_backend', $json);
    $this->assertEquals($data->machine_name, $entity->identifier());
    $this->assertEquals($data->options['endpoint'], $entity->getEndpoint());
    $this->assertEquals($data->options['base_path'], $entity->getBasePath());
  }

  /**
   * Data provider.
   *
   * @return array
   *    Configuration objects.
   */
  public function configurationProvider() {
    return array(
      array($this->getConfigurationFixture('backend', 'test_configuration')),
    );
  }

}
