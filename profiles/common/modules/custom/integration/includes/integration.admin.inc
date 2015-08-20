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

  if ($op == 'clone') {
    $backend->name .= ' cloned';
  }

  $form['name'] = array(
    '#title' => t('Name'),
    '#type' => 'textfield',
    '#default_value' => $backend->getName(),
    '#required' => TRUE,
  );
  $form['machine_name'] = array(
    '#type' => 'machine_name',
    '#default_value' => $backend->getMachineName(),
    '#disabled' => $backend->getEnabled(),
    '#machine_name' => array(
      'exists' => 'integration_load_backend',
      'source' => array('name'),
    ),
    '#description' => t('A unique machine-readable name for this backend. It must only contain lowercase letters, numbers, and underscores.'),
    '#required' => TRUE,
  );

  $types = integration_backend_get_backend_info();
  $form['type'] = array(
    '#title' => t('Backend type'),
    '#type' => 'select',
    '#options' => array_combine(array_keys($types), array_keys($types)),
    '#default_value' => $backend->getType(),
    '#required' => TRUE,
  );
  $formatters = integration_backend_get_formatter_handler_info();
  $form['formatter'] = array(
    '#title' => t('Formatter type'),
    '#type' => 'select',
    '#options' => array_combine(array_keys($formatters), array_keys($formatters)),
    '#default_value' => $backend->getFormatter(),
    '#required' => TRUE,
  );

  $form['enabled'] = array(
    '#title' => t('Enabled'),
    '#type' => 'checkbox',
    '#default_value' => ($op == 'add') ? TRUE : $backend->getEnabled(),
  );
  $form['status'] = array(
    '#value' => ($op == 'add') ? ENTITY_CUSTOM : $backend->getStatus(),
  );

  // @todo: derive these from chosen backend type.
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
    '#default_value' => $backend->getBasePath(),
    '#required' => TRUE,
  );
  $form['options']['endpoint'] = array(
    '#title' => t('Endpoint'),
    '#type' => 'textfield',
    '#default_value' => $backend->getEndpoint(),
    '#required' => TRUE,
  );
  $form['options']['list'] = array(
    '#title' => t('List endpoint'),
    '#type' => 'textfield',
    '#default_value' => $backend->getListEndpoint(),
    '#required' => TRUE,
  );

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
