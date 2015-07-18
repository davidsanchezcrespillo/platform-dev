<?php
/**
 * @file
 * Contains \Drupal\nexteuropa_integration\Document\Formatter.
 */

namespace Drupal\nexteuropa_integration\Document\Formatter;

use Drupal\nexteuropa_integration\Document\DocumentInterface;

/**
 * Class JsonFormatter.
 *
 * @package Drupal\nexteuropa_integration\Document\Formatter
 */
class JsonFormatter implements FormatterInterface {

  /**
   * {@inheritdoc}
   */
  public function format(DocumentInterface $document) {
    return json_encode($document->getDocument(), JSON_PRETTY_PRINT);
  }

}
