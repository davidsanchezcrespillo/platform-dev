<?php

/**
 * @file
 * Contains Drupal\nexteuropa_integration\Tests\BackendTest.
 */

namespace Drupal\nexteuropa_integration\Tests;

/**
 * Test nexteuropa_integration hook implementation and altering.
 *
 * @package Drupal\nexteuropa_integration\Tests\BackendTest
 */
class HooksTest extends \PHPUnit_Framework_TestCase {

  /**
   * Test hook_nexteuropa_integration_producer_info().
   */
  public function testInfoProducers() {

    $producers = nexteuropa_integration_producer_info_producers();
    $expected = array(
      'node' => 'NodeProducer',
      'taxonomy_term' => 'TaxonomyTermProducer',
    );
    foreach ($expected as $entity_type => $producer_class) {
      $this->assertTrue(isset($producers[$entity_type]));
      $this->assertTrue($producers[$entity_type]['class'] == '\Drupal\nexteuropa_integration\Producer\\' . $producer_class);
    }
  }

}
