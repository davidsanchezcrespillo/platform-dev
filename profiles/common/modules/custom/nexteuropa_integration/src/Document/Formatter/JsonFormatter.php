<?php
/**
 * @file
 * Contains \Drupal\nexteuropa_integration\Document\Formatter.
 */

namespace Drupal\nexteuropa_integration\Document\Formatter;

use Drupal\nexteuropa_integration\DocumentInterface;

/**
 * Class JsonFormatter.
 *
 * @package Drupal\nexteuropa_integration\Document\Formatter
 */
class JsonFormatter implements FormatterInterface {

  /**
   * Format and return a Document object in textual output.
   *
   * @param DocumentInterface $document
   *    Document handler object.
   *
   * @return string
   *    Textual representation of the Document object.
   */
  public function format(DocumentInterface $document) {
    return json_encode($document->getDocument(), JSON_PRETTY_PRINT);
  }

}
