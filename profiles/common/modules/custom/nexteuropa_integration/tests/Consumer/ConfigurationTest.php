<?php

/**
 * @file
 * Contains ConfigurationTest.
 */

namespace Drupal\nexteuropa_integration\Tests\Consumer;

use Drupal\nexteuropa_integration\Backend\Configuration\BackendConfiguration;
use Drupal\nexteuropa_integration\Consumer\Configuration\ConsumerConfiguration;
use Drupal\nexteuropa_integration\Configuration\ConfigurationFactory;
use Drupal\nexteuropa_integration\Tests\AbstractTest;

/**
 * Class ConfigurationTest.
 *
 * @package Drupal\nexteuropa_integration\Tests\Consumer
 */
class ConfigurationTest extends AbstractTest {

  /**
   * Test configuration entity CRUD operations.
   *
   * @dataProvider configurationProvider
   */
  public function testConfigurationEntityCrud($data, $backend) {
    $backend_configuration = $this->ensureBackend($data);

    /** @var ConsumerConfiguration $configuration */
    $configuration = entity_create('integration_consumer', (array) $data);
    $configuration->save();

    $reflection = new \ReflectionClass($configuration);
    $this->assertEquals('Drupal\nexteuropa_integration\Consumer\Configuration\ConsumerConfiguration', $reflection->getName());

    $this->assertEquals($data->machine_name, $configuration->identifier());
    $this->assertEquals(ENTITY_CUSTOM, $configuration->getStatus());

    $this->assertNotEmpty($configuration->getMapping());

    $flipped = array_flip($data->mapping);
    foreach ($configuration->getMapping() as $destination => $source) {
      $this->assertEquals($data->mapping[$destination], $configuration->getMappingSource($destination));
      $this->assertEquals($flipped[$source], $configuration->getMappingDestination($source));
    }

    $machine_name = $configuration->identifier();
    $this->assertNotNull(ConfigurationFactory::load('integration_consumer', $machine_name));

    $this->assertEquals($backend_configuration->getBasePath(), $configuration->getBackendConfiguration()->getBasePath());
    $this->assertEquals($backend_configuration->getEndpoint(), $configuration->getBackendConfiguration()->getEndpoint());

    $configuration->delete();
    $backend_configuration->delete();
    $this->assertFalse(ConfigurationFactory::load('integration_consumer', $machine_name));
  }

  /**
   * Test export entity.
   *
   * @dataProvider configurationProvider
   */
  public function testExportImport($data) {

    /** @var ConsumerConfiguration $configuration */
    $configuration = entity_create('integration_backend', (array) $data);

    $json = entity_export('integration_backend', $configuration);
    $decoded = json_decode($json);
    $this->assertNotNull($decoded);
    $this->assertEquals($data->machine_name, $decoded->machine_name);

    $entity = entity_import('integration_backend', $json);
    $this->assertEquals($data->machine_name, $entity->identifier());
    $this->assertEquals($data->options['endpoint'], $entity->getEndpoint());
    $this->assertEquals($data->options['base_path'], $entity->getBasePath());
  }

  /**
   * Data provider.
   *
   * @return array
   */
  public function configurationProvider() {
    return array(
      array($this->getConfigurationFixture('consumer', 'test_configuration')),
    );
  }

  /**
   * Make sure backend entity exists before creating related consumer entity.
   *
   * @param $data
   *    Consumer configuration data.
   *
   * @return BackendConfiguration
   *    Backend entity.
   */
  protected function ensureBackend($data) {
    $backend_data = $this->getConfigurationFixture('backend', $data->backend);
    $backend = entity_create('integration_backend', (array) $backend_data);
    $backend->save();
    return $backend;
  }
}
