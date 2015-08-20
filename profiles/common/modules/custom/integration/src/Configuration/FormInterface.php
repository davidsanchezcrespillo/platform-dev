<?php

/**
 * @file
 * Contains ConfigurableInterface.
 */

namespace Drupal\integration\Configuration;

/**
 * Interface ConfigurableInterface.
 *
 * @package Drupal\integration\Configuration
 */
interface FormInterface {

  /**
   * Build form array.
   *
   * @param array $form
   *    Form array.
   * @param array $form_state
   *    Form state array.
   */
  public function form(array &$form = array(), array &$form_state = array());

  /**
   * Handle form submission.
   *
   * @param array $form
   *    Form array.
   * @param array $form_state
   *    Form state array.
   */
  public function formSubmit(array $form, array &$form_state);

  /**
   * Handle form validation.
   *
   * @param array $form
   *    Form array.
   * @param array $form_state
   *    Form state array.
   */
  public function formValidate(array $form, array &$form_state);

}
