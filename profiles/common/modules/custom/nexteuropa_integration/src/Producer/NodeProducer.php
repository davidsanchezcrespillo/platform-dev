<?php

/**
 * @file
 * Contains \Drupal\nexteuropa_integration\Producer\NodeProducer.
 */

namespace Drupal\nexteuropa_integration\Producer;

use Drupal\nexteuropa_integration\Document;
use Drupal\nexteuropa_integration\Document\Formatter\FormatterInterface;
use Drupal\nexteuropa_integration\DocumentInterface;

/**
 * Class NodeProducer.
 *
 * @package Drupal\nexteuropa_integration\Producer
 */
class NodeProducer extends AbstractProducer {

  /**
   * Build document object using the entity the producer was instantiated with.
   *
   * @return DocumentInterface
   *    Built document object.
   */
  public function build() {
    return new Document();
  }

}
