<?php

/**
 * @file
 * Contains \Drupal\nexteuropa_integration\Backend\MemoryBackend.
 */

namespace Drupal\nexteuropa_integration\Backend;

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
    $document->setMetadata('_id', $this->getBackendId($document));
    $this->storage[$document->getId()] = $document->getDocument();
    return $document;
  }

  /**
   * {@inheritdoc}
   */
  public function read($id) {
    return $this->storage[$id];
  }

  /**
   * {@inheritdoc}
   */
  public function update(DocumentInterface $document) {
    $this->storage[$document->getId()] = $document->getDocument();
    return $document;
  }

  /**
   * {@inheritdoc}
   */
  public function delete($id) {
    unset($this->storage[$id]);
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function getBackendId(DocumentInterface $document) {
    return $document->getMetadata('producer_content_id');
  }

}
