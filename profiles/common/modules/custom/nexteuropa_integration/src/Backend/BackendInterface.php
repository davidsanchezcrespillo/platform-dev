<?php

/**
 * @file
 * Contains Drupal\nexteuropa_integration\Backend\BackendInterface.
 */

namespace Drupal\nexteuropa_integration\Backend;
use Drupal\nexteuropa_integration\Document\DocumentInterface;
use Drupal\nexteuropa_integration\Producer\ProducerInterface;

/**
 * Interface BackendInterface.
 *
 * @package Drupal\nexteuropa_integration\Backend
 */
interface BackendInterface {

  /**
   * Create a new document and populate its backend ID.
   *
   * @param DocumentInterface $document
   *    Document object.
   *
   * @return DocumentInterface
   *    Document object with backend ID.
   */
  public function create(DocumentInterface $document);

  /**
   * Get a document from the backend, given its backend ID.
   *
   * @param string $id
   *    Backend ID.
   *
   * @return DocumentInterface|false
   *    Document fetched from backend or FALSE if not found.
   */
  public function read($id);

  /**
   * Update an existing document.
   *
   * @param DocumentInterface $document
   *    Document object.
   *
   * @return DocumentInterface
   *    Updated document object.
   */
  public function update(DocumentInterface $document);

  /**
   * Delete a document from the backend, given its backend ID.
   *
   * @param string $id
   *    Backend ID.
   *
   * @return bool
   *    TRUE if deleted FALSE if not found.
   */
  public function delete($id);

  /**
   * Get backend ID using local producer content ID.
   *
   * @param ProducerInterface $producer
   *    Producer object.
   *
   * @return string
   *    Backend ID.
   */
  public function getBackendId(ProducerInterface $producer);

  /**
   * Get backend base path.
   *
   * @return string
   *     Backend base path.
   */
  public function getBase();

  /**
   * Set backend base path.
   *
   * @param string $base
   *    Backend base path.
   */
  public function setBase($base);

  /**
   * Get backend endpoint.
   *
   * @return string
   *    Endpoint value.
   */
  public function getEndpoint();

  /**
   * Set backend endpoint.
   *
   * @param string $endpoint
   *    Backend base path.
   */
  public function setEndpoint($endpoint);

  /**
   * Get formatter object.
   *
   * @return Formatter\FormatterInterface
   *    Formatter object instance.
   */
  public function getFormatter();

  /**
   * Set formatter object.
   *
   * @param Formatter\FormatterInterface $formatter
   *    Formatter object instance.
   */
  public function setFormatter(Formatter\FormatterInterface $formatter);

}
