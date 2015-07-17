<?php
/**
 * @file
 * Contains \Drupal\nexteuropa_integration\Tests\Document\Formatter.
 */

namespace Drupal\nexteuropa_integration\Tests\Document\Formatter;

use Drupal\nexteuropa_integration\Document;
use Drupal\nexteuropa_integration\Document\Formatter\JsonFormatter;

/**
 * Class BackendTest.
 *
 * @package Drupal\nexteuropa_integration\Tests\BackendTest
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
