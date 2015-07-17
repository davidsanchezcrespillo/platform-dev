<?php

/**
 * @file
 * Contains DefaultEntityWrapper.
 */

namespace Drupal\nexteuropa_integration\Producer\EntityWrapper;

/**
 * Class DefaultEntityWrapper.
 *
 * @package Drupal\nexteuropa_integration\Producer\EntityWrapper
 */
class DefaultEntityWrapper extends \EntityDrupalWrapper implements EntityWrapperInterface {

  /**
   * Default Entity Wrapper date format.
   *
   * Date format can be overridden by setting the 'default_date_format' value
   * on the $info array, to be passed in the object constructor.
   *
   * @see parent::__construct()
   */
  const DEFAULT_DATE_FORMAT = 'Y-m-d H:i:s';

  /**
   * Translation handler instance.
   *
   * @var \EntityTranslationHandlerInterface
   *   A class implementing EntityTranslationHandlerInterface.
   */
  protected $translationHandler = NULL;

  /**
   * Construct a new EntityDrupalWrapper object.
   *
   * @param $type
   *   The type of the passed data.
   * @param $data
   *   Optional. The entity to wrap or its identifier.
   * @param $info
   *   Optional. Used internally to pass info about properties down the tree.
   */
  public function __construct($type, $data = NULL, $info = array()) {
    parent::__construct($type, $data, $info);
    $this->translationHandler = entity_translation_get_handler($type, $data);
    $this->setUp();
  }

  /**
   * Check weather $name is a property or not.
   *
   * @param string $name
   *    Property name.
   *
   * @return bool
   *    TRUE if property, FALSE otherwise.
   */
  public function isProperty($name) {
    return in_array($name, $this->getPropertyList());
  }

  /**
   * Get property value.
   *
   * @param string $name
   *    Property name.
   *
   * @return string
   *    Property value.
   */
  public function getProperty($name) {
    if ($this->isProperty($name)) {
      $info = $this->getPropertyInfo($name);
      switch ($info['type']) {

        // Format and return a date properties.
        case 'date':
          $format = isset($this->info['default_date_format']) ? $this->info['default_date_format'] : self::DEFAULT_DATE_FORMAT;
          return date($format, $this->get($name)->value());

        // By default simply return all other property types.
        default:
          return $this->get($name)->value();
      }
    }
    return '';
  }

  /**
   * Return list of all entity's properties.
   *
   * @return array[string]
   *    Array of property names.
   */
  public function getPropertyList() {
    $properties = array();
    foreach ($this->propertyInfo['properties'] as $name => $info) {
      if (!isset($info['field'])) {
        $properties[] = $name;
      }
    }
    return $properties;
  }

  /**
   * Return list of all entity's fields.
   *
   * @return array[string]
   *    Array of field names.
   */
  public function getFieldList() {

    $fields = array();
    foreach ($this->propertyInfo['properties'] as $name => $info) {
      if (isset($info['field']) && $info['field']) {
        $fields[] = $name;
      }
    }
    return $fields;
  }

  /**
   * Check weather $name is a field or not.
   *
   * @param string $name
   *    Field name.
   *
   * @return bool
   *    TRUE if property, FALSE otherwise.
   */
  public function isField($name) {
    return in_array($name, $this->getFieldList());
  }

  /**
   * Get field value, given a certain language.
   *
   * @param string $name
   *    Field name.
   * @param string $language
   *    Language code.
   *
   * @return array
   *    String values, in selected language.
   */
  public function getField($name, $language = NULL) {
    $this->language($language);
    $value = $this->{$name}->value();
    $this->language($this->translationHandler->getDefaultLanguage());
    return $value;
  }

  /**
   * Get available languages for current entity.
   *
   * @return array
   *    Array of language codes.
   */
  public function getAvailableLanguages() {
    $translations = $this->translationHandler->getTranslations();
    return array_keys($translations->data);
  }

  /**
   * Get default language for current entity.
   *
   * @return string
   *    Default language code.
   */
  public function getDefaultLanguage() {
    return $this->translationHandler->getDefaultLanguage();
  }

}
