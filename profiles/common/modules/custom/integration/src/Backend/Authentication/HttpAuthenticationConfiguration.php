<?php

/**
 * @file
 * Contains HttpAuthenticationConfiguration.
 */

namespace Drupal\integration\Backend\Authentication;

use Drupal\integration\Configuration\AbstractComponentConfiguration;
use Drupal\integration\Configuration\FormInterface;

/**
 * Class HttpAuthenticationConfiguration.
 *
 * @package Drupal\integration\Backend\Authentication
 */
class HttpAuthenticationConfiguration extends AbstractComponentConfiguration implements FormInterface {

  /**
   * {@inheritdoc}
   */
  public function form(array &$form, array &$form_state, $op) {
  }

}
