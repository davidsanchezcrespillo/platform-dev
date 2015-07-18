<?php

/**
 * @file
 * Contains \Drupal\nexteuropa_integration\Producer\NodeProducer.
 */

namespace Drupal\nexteuropa_integration\Producer;

/**
 * Class NodeProducer.
 *
 * @package Drupal\nexteuropa_integration\Producer
 */
class NodeProducer extends AbstractProducer {

  /**
   * {@inheritdoc}
   */
  public function getProducerContentId() {
    return 'node-' . $this->getEntityWrapper()->getBundle() . '-' . $this->getEntityWrapper()->nid->value();
  }

  /**
   * {@inheritdoc}
   */
  public function getDocumentType() {
    return $this->getEntityWrapper()->getProperty('type');
  }

  /**
   * {@inheritdoc}
   */
  public function getDocumentCreationDate() {
    return $this->getEntityWrapper()->getProperty('created');
  }

  /**
   * {@inheritdoc}
   */
  public function getDocumentUpdateDate() {
    return $this->getEntityWrapper()->getProperty('changed');
  }

}
