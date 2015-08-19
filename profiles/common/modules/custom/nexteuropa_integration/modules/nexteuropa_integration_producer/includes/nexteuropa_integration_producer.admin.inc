<?php

/**
 * @file
 * Contains administrative forms.
 */

use Drupal\integration\Producer\Configuration\ProducerConfiguration;

/**
 * Generates the profile type editing form.
 */
function integration_producer_form($form, &$form_state, ProducerConfiguration $producer, $op = 'edit') {

  if ($op == 'clone') {
    $producer->name .= ' cloned';
  }

  $form['name'] = array(
    '#title' => t('Name'),
    '#type' => 'textfield',
    '#default_value' => $producer->getName(),
    '#required' => TRUE,
  );
  $form['machine_name'] = array(
    '#type' => 'machine_name',
    '#default_value' => $producer->getMachineName(),
    '#disabled' => $producer->getEnabled(),
    '#machine_name' => array(
      'exists' => 'integration_producer_load_producer',
      'source' => array('name'),
    ),
    '#description' => t('A unique machine-readable name for this producer. It must only contain lowercase letters, numbers, and underscores.'),
    '#required' => TRUE,
  );

  $types = integration_producer_get_producer_info();
  $form['type'] = array(
    '#title' => t('Producer type'),
    '#type' => 'select',
    '#options' => array_combine(array_keys($types), array_keys($types)),
    '#default_value' => $producer->getType(),
    '#required' => TRUE,
  );
  $form['producer_id'] = array(
    '#title' => t('Producer ID'),
    '#type' => 'textfield',
    '#default_value' => $producer->getProducerId(),
    '#element_validate' => array(
      'integration_producer_element_producer_id_validate',
    ),
    '#required' => TRUE,
  );
  $form['enabled'] = array(
    '#title' => t('Enabled'),
    '#type' => 'checkbox',
    '#default_value' => ($op == 'add') ? TRUE : $producer->getEnabled(),
  );
  $form['status'] = array(
    '#value' => ($op == 'add') ? ENTITY_CUSTOM : $producer->getStatus(),
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
 * Form API callback to validate a machine readable name.
 *
 * @see integration_producer_form()
 */
function integration_producer_element_producer_id_validate($element, &$form_state, $form) {
  if ($element['#value'] && !preg_match('!^[a-z\-]+$!', $element['#value'])) {
    form_error($element, t('Producer ID can contain only lowercase letters and dashes.'));
  }
}

/**
 * Load producer entity given its machine name.
 *
 * @param string $machine_name
 *    Producer configuration entity machine name.
 *
 * @return ProducerConfiguration
 *    Producer configuration entity.
 */
function integration_producer_load_producer($machine_name) {
  return entity_load_single('integration_producer', $machine_name);
}

/**
 * Form API submit callback for the type form.
 *
 * @see integration_producer_form()
 */
function integration_producer_form_submit(&$form, &$form_state) {
  /** @var ProducerConfiguration $producer */
  $producer = entity_ui_form_submit_build_entity($form, $form_state);
  $producer->save();

  drupal_set_message(t('Configuration has been saved.'));
  $form_state['redirect'] = 'admin/config/services/integration/producer';
}
