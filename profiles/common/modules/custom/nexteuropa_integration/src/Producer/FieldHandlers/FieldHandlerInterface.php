<?php

/**
 * @file
 * Contains FieldHandlers.
 */

namespace Drupal\nexteuropa_integration\Producer\FieldHandlers;

use Drupal\nexteuropa_integration\Document\DocumentInterface;
use Drupal\nexteuropa_integration\Producer\EntityWrapper\DefaultEntityWrapper;
use Drupal\nexteuropa_integration\Document\Document;

/**
 * Interface FieldHandlerInterface.
 *
 * @package Drupal\nexteuropa_integration\Producer\FieldHandlers
 */
interface FieldHandlerInterface {

  /**
   * Return field values for current language.
   *
   * Values will be normalized to array of values, even for single fields.
   *
   * @return array
   *    Current, normalized field values.
   */
  public function getFieldValues();

  /**
   * Entity wrapper the producer has been instantiated with.
   *
   * @return DefaultEntityWrapper
   *    Entity wrapper object.
   */
  public function getEntityWrapper();

  /**
   * Get document handler the producer has been instantiated with.
   *
   * @return DocumentInterface
   *    Document object.
   */
  public function getDocument();

  /**
   * Process and assign current field to document.
   */
  public function processField();

  /**
   * Process current field.
   */
  public function process();

}
