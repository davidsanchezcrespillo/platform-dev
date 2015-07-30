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
  public function testConfigurationEntityCrud($data) {
    $reflection = new \ReflectionClass($this->consumer_configuration);
    $this->assertEquals('Drupal\nexteuropa_integration\Consumer\Configuration\ConsumerConfiguration', $reflection->getName());

    $this->assertEquals($data->machine_name, $this->consumer_configuration->identifier());
    $this->assertEquals(ENTITY_CUSTOM, $this->consumer_configuration->getStatus());

    $this->assertNotEmpty($this->consumer_configuration->getMapping());

    $flipped = array_flip($data->mapping);
    foreach ($this->consumer_configuration->getMapping() as $destination => $source) {
      $this->assertEquals($data->mapping[$destination], $this->consumer_configuration->getMappingSource($destination));
      $this->assertEquals($flipped[$source], $this->consumer_configuration->getMappingDestination($source));
    }

    $machine_name = $this->consumer_configuration->identifier();
    $this->assertNotNull(ConfigurationFactory::load('integration_consumer', $machine_name));

    $this->assertEquals($this->backend_configuration->getBasePath(), $this->consumer_configuration->getBackendConfiguration()->getBasePath());
    $this->assertEquals($this->backend_configuration->getEndpoint(), $this->consumer_configuration->getBackendConfiguration()->getEndpoint());

    $this->consumer_configuration->delete();
    $this->assertFalse(ConfigurationFactory::load('integration_consumer', $machine_name));
  }

  /**
   * Test export entity.
   *
   * @dataProvider configurationProvider
   */
  public function testExportImport($data) {

    /** @var ConsumerConfiguration $configuration */
    $configuration = entity_create('integration_consumer', (array) $data);

    $json = entity_export('integration_consumer', $configuration);
    $decoded = json_decode($json);
    $this->assertNotNull($decoded);
    $this->assertEquals($data->machine_name, $decoded->machine_name);

    /** @var ConsumerConfiguration $entity */
    $entity = entity_import('integration_consumer', $json);
    $this->assertEquals($data->machine_name, $entity->identifier());
  }

  /**
   * Data provider.
   *
   * @return array
   *    Configuration objects.
   */
  public function configurationProvider() {
    return array(
      array($this->getConfigurationFixture('consumer', 'test_configuration')),
    );
  }

}
