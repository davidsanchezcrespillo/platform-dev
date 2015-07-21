<?php

/**
 * @file
 * Contains \Drupal\nexteuropa_integration\Backend\MemoryBackend.
 */

namespace Drupal\nexteuropa_integration\Backend;

use Drupal\nexteuropa_integration\Producer\ProducerInterface;
use Drupal\nexteuropa_integration\Document\DocumentInterface;

/**
 * Class MemoryBackend.
 *
 * @package Drupal\nexteuropa_integration\Backend
 */
class MemoryBackend extends AbstractBackend {

  /**
   * Backend data storage.
   *
   * @var array
   */
  private $storage = array();

  /**
   * {@inheritdoc}
   */
  public function create(DocumentInterface $document) {
    // TODO: Implement create() method.
  }

  /**
   * {@inheritdoc}
   */
  public function read($id) {
    // TODO: Implement read() method.
  }

  /**
   * {@inheritdoc}
   */
  public function update(DocumentInterface $document) {
    // TODO: Implement update() method.
  }

  /**
   * {@inheritdoc}
   */
  public function delete($id) {
    // TODO: Implement delete() method.
  }

  /**
   * {@inheritdoc}
   */
  public function getBackendId(ProducerInterface $producer) {
    // TODO: Implement getBackendId() method.
  }

}
