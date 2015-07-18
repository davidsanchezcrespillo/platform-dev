<?php

/**
 * @file
 * Contains \Drupal\nexteuropa_integration\Consumer\Migrate\DocumentWrapperInterface.
 */

namespace Drupal\nexteuropa_integration\Consumer\Migrate;

/**
 * Interface DocumentWrapperInterface.
 *
 * @package Drupal\nexteuropa_integration\Consumer\Migrate
 */
interface DocumentWrapperInterface {

  /**
   * Get current document.
   *
   * Request is forwarded to Drupal\nexteuropa_integration\Document\DocumentInterface.
   *
   * @return \Drupal\nexteuropa_integration\Document\DocumentInterface
   *    Document object.
   */
  public function getDocument();

  /**
   * Get current document's available languages.
   *
   * Request is forwarded to Drupal\nexteuropa_integration\Document\DocumentInterface.
   *
   * @return array
   *    Document's available languages.
   */
  public function getAvailableLanguages();

  /**
   * Get current document's default language.
   *
   * Request is forwarded to Drupal\nexteuropa_integration\Document\DocumentInterface.
   *
   * @return string
   *    Document's default language.
   */
  public function getDefaultLanguage();

  /**
   * Set field values on current document for the specified language.
   *
   * Request is forwarded to Drupal\nexteuropa_integration\Document\DocumentInterface.
   *
   * @param string $language
   *    Lang code in ISO 639-1 format, falls back to current language if NULL.
   */
  public function setSourceValues($language = NULL);

}
