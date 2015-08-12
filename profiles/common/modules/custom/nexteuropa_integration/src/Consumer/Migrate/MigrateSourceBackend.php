<?php

/**
 * @file
 * Contains \Drupal\nexteuropa_integration\Consumer\Migrate\MigrateSourceBackend
 */

namespace Drupal\nexteuropa_integration\Consumer\Migrate;

use Drupal\nexteuropa_integration\Backend\AbstractBackend;

/**
 * Class MigrateSourceBackend.
 *
 * @package Drupal\nexteuropa_integration\Consumer\Migrate
 */
class MigrateSourceBackend extends \MigrateSource {

  /**
   * Current backend.
   *
   * @var AbstractBackend
   */
  protected $backend;

  /**
   * Constructor.
   *
   * @param AbstractBackend $backend
   *    Backend instance.
   * @param array $options
   *    Migrate source options.
   */
  public function __construct(AbstractBackend $backend, array $options = array()) {
    parent::__construct($options);
    $this->backend = $backend;
  }

  /**
   * Return a string representing the source, for display in the UI.
   */
  public function __toString() {
    return t('Migrate source using %backend integration backend.', array('%backend' => $this->backend->getConfiguration()->getName()));
  }

  /**
   * Returns a list of fields available to be mapped from the source,
   * keyed by field name.
   */
  public function fields() {
    return array(
      'title' => t('Title'),
      'body' => t('Body'),
    );
  }

  /**
   * Return the number of available source records.
   */
  public function computeCount() {
//    return $this->numRows;
  }

  /**
   * Do whatever needs to be done to start a fresh traversal of the source data.
   *
   * This is always called at the start of an import, so tasks such as opening
   * file handles, running queries, and so on should be performed here.
   */
  public function performRewind() {
//    $this->currentId = 1;
  }

  /**
   * Fetch the next row of data, returning it as an object. Return FALSE
   * when there is no more data available.
   */
  public function getNextRow() {
//    if ($this->currentId <= $this->numRows) {
//      $row = new \stdClass;
//      $row->id = $this->currentId;
//      $row->title = 'Sample title ' . $row->id;
//      $row->body = 'Sample body';
//      $this->currentId++;
//      return $row;
//    }
//    else {
//      return NULL;
//    }
  }
}
