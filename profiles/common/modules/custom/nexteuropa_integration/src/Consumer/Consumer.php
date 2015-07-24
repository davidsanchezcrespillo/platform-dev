<?php

/**
 * @file
 * Contains Drupal\nexteuropa_integration\Consumer\Consumer.
 */

namespace Drupal\nexteuropa_integration\Consumer;

use Drupal\nexteuropa_integration\Backend\BackendInterface;
use Drupal\nexteuropa_integration\Backend\Configuration\BackendConfiguration;
use Drupal\nexteuropa_integration\Configuration\AbstractConfiguration;
use Drupal\nexteuropa_integration\Configuration\ConfigurableInterface;
use Drupal\nexteuropa_integration\Configuration\ConfigurationFactory;
use Drupal\nexteuropa_integration\Consumer\Configuration\ConsumerConfiguration;
use Drupal\nexteuropa_integration\Consumer\Migrate\AbstractMigration;
use Drupal\nexteuropa_integration\Consumer\Migrate\MigrateItemJSON;
use Drupal\nexteuropa_integration\Consumer\Migrate\MigrateListJSON;

/**
 * Interface ConsumerInterface.
 *
 * @package Drupal\nexteuropa_integration\Consumer
 */
class Consumer extends AbstractMigration implements ConsumerInterface, ConfigurableInterface {

  /**
   * List supported entity destinations so far. To be expanded soon.
   * @var array
   */
  protected $supportedDestinations = array(
    'node' => '\MigrateDestinationNode',
    'taxonomy_term' => '\MigrateDestinationTerm',
  );

  /**
   * Configuration object.
   *
   * @var ConsumerConfiguration
   */
  protected $configuration;

  /**
   * Backend object.
   *
   * @var BackendInterface
   */
  protected $backend;

  /**
   * Current entity type info array.
   *
   * @var array
   */
  protected $entityInfo = array();

  /**
   * {@inheritdoc}
   */
  public function __construct(array $arguments) {
    // Will throw exceptions if arguments are not valid.
    self::validateArguments($arguments);
    parent::__construct($arguments);

    // @todo: make sure the following classes are passed via $argument.
    $configuration = ConfigurationFactory::load('integration_consumer', $arguments['consumer']['configuration']);
    $this->setConfiguration($configuration);
    $this->entityInfo = $configuration->entityInfo();

    $this->setMap($this->getMapInstance());
    $this->setDestination($this->getDestinationInstance());

    // Apply mapping.
    foreach ($this->getConfiguration()->getMapping() as $destination => $source) {
      $this->addFieldMapping($destination, $source);
    }

    // Mapping default language is necessary for correct translation handling.
    $this->addFieldMapping('language', 'default_language');

    // @todo: make the following an option set via UI.
    $this->addFieldMapping('promote')->defaultValue(FALSE);
    $this->addFieldMapping('status')->defaultValue(NODE_NOT_PUBLISHED);

    $this->setBackendSource();
  }

  /**
   * {@inheritdoc}
   */
  public function getSourceKey() {
    return array(
      '_id' => array(
        'type' => 'varchar',
        'length' => 255,
        'not null' => TRUE,
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function addFieldMapping($destination_field, $source_field = NULL, $warn_on_override = TRUE) {
    $mapping = parent::addFieldMapping($destination_field, $source_field, $warn_on_override);

    // @todo: add other processors. Maybe implement hook/plugin system for that.
    $this->processTitleFieldMapping($destination_field, $source_field);
    $this->processFileFieldMapping($destination_field, $source_field);
    $this->processTextWithSummaryMapping($destination_field, $source_field);

    return $mapping;
  }

  /**
   * Handle replacements from Title module when mapping fields.
   *
   * @param string $destination_field
   *    Destination field name.
   * @param string|null $source_field
   *    Source field name.
   */
  protected function processTitleFieldMapping($destination_field, $source_field = NULL) {
    // Handle Title replacements.
    $source_field = !$source_field ? $destination_field : $source_field;

    $entity_type = $this->getConfiguration()->entityType();
    $bundle = $this->getConfiguration()->bundle();
    $legacy_field = $this->getConfiguration()->getEntityKey('label');

    if ($destination_field == $legacy_field && title_field_replacement_enabled($entity_type, $bundle, $legacy_field)) {
      $field_replacement = title_field_replacement_get_label_field($entity_type, $bundle);
      parent::addFieldMapping($field_replacement['field_name'], $source_field, FALSE);
    }
  }

  /**
   * Process file fields mapping.
   *
   * @param string $destination_field
   *    Destination field name.
   * @param string|null $source_field
   *    Source field name.
   */
  protected function processFileFieldMapping($destination_field, $source_field = NULL) {
    $field_info = field_info_field($destination_field);
    if (in_array($field_info['type'], array('image', 'file'))) {
      parent::addFieldMapping("$destination_field:file_replace")->defaultValue(FILE_EXISTS_REPLACE);
    }
  }

  /**
   * Process text with summary fields mapping.
   *
   * @param string $destination_field
   *    Destination field name.
   * @param string|null $source_field
   *    Source field name.
   */
  protected function processTextWithSummaryMapping($destination_field, $source_field = NULL) {
    $field_info = field_info_field($destination_field);
    if (in_array($field_info['type'], array('text_with_summary'))) {
      parent::addFieldMapping("$destination_field:format")->defaultValue('full_html');
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getConfiguration() {
    return $this->configuration;
  }

  /**
   * {@inheritdoc}
   */
  public function setConfiguration(AbstractConfiguration $configuration) {
    $this->configuration = $configuration;
  }

  /**
   * {@inheritdoc}
   */
  public function getBackend() {
    return $this->backend;
  }

  /**
   * {@inheritdoc}
   */
  public function setBackend(BackendInterface $backend) {
    $this->backend = $backend;
  }

  /**
   * Register a new consumer migration given its configuration object.
   *
   * @param \stdClass $settings
   *    Consumer configuration setting.
   */
  public static function register(\stdClass $settings) {
    $arguments = array();
    $arguments['consumer']['settings'] = $settings;
    self::validateArguments($arguments);
    \Migration::registerMigration(__CLASS__, $settings->name, $arguments);
  }

  /**
   * Get map object instance depending on entity type setting.
   *
   * @return \MigrateMap
   *    Map object instance.
   */
  protected function getMapInstance() {
    /** @var \MigrateDestinationNode $destination_class */
    $destination_class = $this->getDestinationClass();
    return new \MigrateSQLMap($this->getMachineName(), $this->getSourceKey(), $destination_class::getKeySchema());
  }


  /**
   * @param $name
   */
  public function setBackendSource() {
    // @todo: properly implement backend configuration loading.
    $name = $this->getConfiguration()->getBackend();
    /** @var BackendConfiguration $backend */
    $backend = ConfigurationFactory::load('integration_backend', $name);

    $base_path = $backend->getBasePath();
    $list_path = "$base_path/changes/" .  $backend->getEndpoint();
    $item_path = $backend->getUri() . '/:id';
    $this->setSource(new \MigrateSourceList(
      new MigrateListJSON($list_path),
      new MigrateItemJSON($item_path, array()),
      array()
    ));
  }

  /**
   * Get destination object instance depending on entity type setting.
   *
   * @return \MigrateDestination
   *    Destination object instance.
   */
  protected function getDestinationInstance() {
    $destination_class = $this->getDestinationClass();
    $bundle = $this->getConfiguration()->bundle();
    return new $destination_class($bundle);
  }

  /**
   * Return migration destination class depending on entity type setting.
   *
   * @return string
   *    Destination class name.
   */
  protected function getDestinationClass() {
    $entity_type = $this->getConfiguration()->entityType();
    if (isset($this->supportedDestinations[$entity_type])) {
      return $this->supportedDestinations[$entity_type];
    }
    throw new \InvalidArgumentException("Entity destination $entity_type not supported.");
  }

  /**
   * Make sure required arguments are present and valid.
   *
   * @param array $arguments
   *    Constructor's $arguments array.
   */
  static private function validateArguments(array $arguments) {

    if (!isset($arguments['consumer'])) {
      throw new \InvalidArgumentException(t('Consumer argument missing: "consumer".'));
    }
    if (!isset($arguments['consumer']['configuration'])) {
      throw new \InvalidArgumentException('Consumer sub-argument missing: "configuration".');
    }
  }

}
