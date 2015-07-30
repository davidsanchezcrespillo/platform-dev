<?php

/**
 * @file
 * Contains ConfigurationTest.
 */

namespace Drupal\nexteuropa_integration\Tests\Producer;

use Drupal\nexteuropa_integration\Producer\Configuration\ProducerConfiguration;
use Drupal\nexteuropa_integration\Configuration\ConfigurationFactory;
use Drupal\nexteuropa_integration\Tests\AbstractTest;

/**
 * Class ConfigurationTest.
 *
 * @package Drupal\nexteuropa_integration\Tests\Producer
 */
class ConfigurationTest extends AbstractTest {

  /**
   * Test configuration entity CRUD operations.
   *
   * @dataProvider configurationProvider
   */
  public function testConfigurationEntityCrud($data) {
    $reflection = new \ReflectionClass($this->producer_configuration);
    $this->assertEquals('Drupal\nexteuropa_integration\Producer\Configuration\ProducerConfiguration', $reflection->getName());

    $this->assertEquals($data->machine_name, $this->producer_configuration->identifier());
    $this->assertEquals(ENTITY_CUSTOM, $this->producer_configuration->getStatus());
    $this->assertEquals($data->producer_id, $this->producer_configuration->getProducerId());

    $this->assertEquals($data->options['username'], $this->producer_configuration->getOptionValue('username'));
    $this->assertEquals($data->options['password'], $this->producer_configuration->getOptionValue('password'));
    $this->assertEquals($data->type, $this->producer_configuration->getType());

    $machine_name = $this->producer_configuration->identifier();
    $this->assertNotNull(ConfigurationFactory::load('integration_producer', $machine_name));

    $this->producer_configuration->delete();
    $this->assertFalse(ConfigurationFactory::load('integration_producer', $machine_name));
  }

  /**
   * Test export entity.
   *
   * @dataProvider configurationProvider
   */
  public function testExportImport($data) {

    /** @var ProducerConfiguration $configuration */
    $configuration = entity_create('integration_producer', (array) $data);

    $json = entity_export('integration_producer', $configuration);
    $decoded = json_decode($json);
    $this->assertNotNull($decoded);
    $this->assertEquals($data->machine_name, $decoded->machine_name);

    /** @var ProducerConfiguration $entity */
    $entity = entity_import('integration_producer', $json);
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
      array($this->getConfigurationFixture('producer', 'test_configuration')),
    );
  }

}
