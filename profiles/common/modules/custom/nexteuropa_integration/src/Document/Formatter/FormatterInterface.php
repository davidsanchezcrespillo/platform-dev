<?php
/**
 * @file
 * Contains \Drupal\nexteuropa_integration\Document\Formatter.
 */

namespace Drupal\nexteuropa_integration\Document\Formatter;

use Drupal\nexteuropa_integration\Document\DocumentInterface;

/**
 * Interface FormatterInterface.
 *
 * @package Drupal\nexteuropa_integration\Document\Formatter
 */
interface FormatterInterface {

  /**
   * Format and return a Document object in textual output.
   *
   * @param DocumentInterface $document
   *    Document handler object.
   *
   * @return string
   *    Textual representation of the Document object.
   */
  public function format(DocumentInterface $document);

}
