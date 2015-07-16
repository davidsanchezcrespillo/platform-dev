<?php

/**
 * @file
 * Contains \Drupal\nexteuropa_integration\Producer\AbstractProducer
 */

namespace Drupal\nexteuropa_integration\Producer;

use Drupal\nexteuropa_integration\Producer\FieldHandlers\FieldHandlerInterface;

/**
 * Class AbstractProducer.
 *
 * @package Drupal\nexteuropa_integration\Producer
 */
class AbstractProducer implements ProducerInterface {


  function __construct($entity_type, $entity, FieldHandlerInterface $field_handler) {

  }


}
