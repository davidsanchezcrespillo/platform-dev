<?php

/**
 * @file
 * Contains HttpAuthenticationConfiguration.
 */

namespace Drupal\integration\Backend\Authentication;

use Drupal\integration\Configuration\AbstractComponentConfiguration;

/**
 * Class HttpAuthenticationConfiguration.
 *
 * @package Drupal\integration\Backend\Authentication
 */
class HttpAuthenticationConfiguration extends AbstractComponentConfiguration {

  /**
   * {@inheritdoc}
   */
  public function form(array &$form, array &$form_state, $op) {
    $form['options'] = array(
      '#title' => t('Options'),
      '#type' => 'fieldset',
      '#tree' => TRUE,
      '#collapsed' => FALSE,
      '#collapsible' => TRUE,
    );
    $form['options']['base_path'] = array(
      '#title' => t('Base path'),
      '#type' => 'textfield',
      '#default_value' => $this->getOption('base_path'),
      '#required' => TRUE,
    );
    $form['options']['endpoint'] = array(
      '#title' => t('Endpoint'),
      '#type' => 'textfield',
      '#default_value' => $this->getOption('endpoint'),
      '#required' => TRUE,
    );
    $form['options']['list'] = array(
      '#title' => t('List endpoint'),
      '#type' => 'textfield',
      '#default_value' => $this->getOption('list'),
      '#required' => TRUE,
    );
  }

}
