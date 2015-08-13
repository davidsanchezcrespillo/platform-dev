<?php

/**
 * @file
 * Contains \Drupal\nexteuropa_integration\Backend\MemoryBackend.
 */

namespace Drupal\nexteuropa_integration\Backend;

use Drupal\nexteuropa_integration\Document\Document;
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
  public function getDocumentList($max = 0) {
    return array_keys($this->storage);
  }

  /**
   * {@inheritdoc}
   */
  public function create(DocumentInterface $document) {
    $document->setMetadata('_id', $this->getBackendContentId($document));
    $this->storage[$document->getId()] = $document->getDocument();
    return $document;
  }

  /**
   * {@inheritdoc}
   */
  public function read($id) {
    if (isset($this->storage[$id])) {
      return new Document($this->storage[$id]);
    }
    return FALSE;
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
  public function getBackendContentId(DocumentInterface $document) {
    return $document->getMetadata('producer_content_id');
  }

}
