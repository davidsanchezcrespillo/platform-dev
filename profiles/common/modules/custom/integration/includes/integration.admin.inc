<?php

/**
 * @file
 * Contains administrative forms.
 */

use Drupal\integration\Backend\Configuration\BackendConfiguration;

/**
 * Generates the profile type editing form.
 */
function integration_backend_form($form, &$form_state, BackendConfiguration $backend, $op = 'edit') {

  $backend->form($form, $form_state, $op);

  $form['actions'] = array('#type' => 'actions');
  $form['actions']['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save'),
    '#weight' => 40,
  );
  return $form;
}


/**
 * Load backend entity given its machine name.
 *
 * @param string $machine_name
 *    Backend configuration entity machine name.
 *
 * @return BackendConfiguration
 *    Backend configuration entity.
 */
function integration_load_backend($machine_name) {
  return entity_load_single('integration_backend', $machine_name);
}

/**
 * Form API submit callback for the type form.
 *
 * @see integration_backend_form()
 */
function integration_backend_form_submit(&$form, &$form_state) {
  /** @var BackendConfiguration $backend */
  $backend = entity_ui_form_submit_build_entity($form, $form_state);
  $backend->save();

  drupal_set_message(t('Configuration has been saved.'));
  $form_state['redirect'] = 'admin/config/services/integration/backend';
}
