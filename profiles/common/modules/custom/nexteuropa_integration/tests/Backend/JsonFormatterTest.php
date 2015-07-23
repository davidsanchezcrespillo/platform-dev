<?php
/**
 * @file
 * Contains JsonFormatterTest.
 */

namespace Drupal\nexteuropa_integration\Tests\Backend;

use Drupal\nexteuropa_integration\Document\Document;
use Drupal\nexteuropa_integration\Backend\Formatter\JsonFormatter;

/**
 * Class JsonFormatterTest.
 *
 * @package Drupal\nexteuropa_integration\Tests\Backend
 */
class JsonFormatterTest extends \PHPUnit_Framework_TestCase {

  /**
   * Test Json formatter.
   */
  public function testFormatter() {

    $document = new Document();
    $formatter = new JsonFormatter();
    $expected = <<<EOD
{
    "_id": null,
    "default_language": "en",
    "languages": [
        "en"
    ],
    "fields": {}
}
EOD;
    $this->assertEquals($expected, $formatter->format($document));
  }

}
