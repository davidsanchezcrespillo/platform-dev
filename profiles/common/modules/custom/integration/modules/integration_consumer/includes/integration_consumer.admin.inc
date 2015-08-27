<?php

/**
 * @file
 * Contains administrative forms.
 */

use Drupal\integration\Consumer\Configuration\ConsumerConfiguration;

/**
 * Generates the profile type editing form.
 */
function integration_consumer_form($form, &$form_state, ConsumerConfiguration $consumer, $op = 'edit') {

  if ($op == 'clone') {
    $consumer->name .= ' cloned';
  }

  $form['name'] = array(
    '#title' => t('Name'),
    '#type' => 'textfield',
    '#default_value' => $consumer->getName(),
    '#required' => TRUE,
  );
  $form['machine_name'] = array(
    '#type' => 'machine_name',
    '#default_value' => $consumer->getMachineName(),
    '#disabled' => $consumer->getEnabled(),
    '#machine_name' => array(
      'exists' => 'integration_consumer_load_consumer',
      'source' => array('name'),
    ),
    '#description' => t('A unique machine-readable name for this consumer. It must only contain lowercase letters, numbers, and underscores.'),
    '#required' => TRUE,
  );

  $entity_types = array();
  $entity_info = entity_get_info();
  unset($entity_info['integration_consumer']);
  unset($entity_info['integration_producer']);
  unset($entity_info['integration_backend']);
  foreach ($entity_info as $entity_type => $info) {
    $entity_types[$entity_type] = $info['label'];
  }
  $form['entity_type'] = array(
    '#title' => t('Entity type'),
    '#type' => 'select',
    '#options' => $entity_types,
    '#default_value' => $consumer->entityType(),
    '#required' => TRUE,
  );
  foreach ($entity_info as $entity_type => $info) {
    $bundles = array();
    foreach ($info['bundles'] as $bundle => $bundle_info) {
      $bundles[$bundle] = $bundle_info['label'];
    }
    $form['entity_bundle_' . $entity_type] = array(
      '#title' => t('Entity bundle'),
      '#type' => 'select',
      '#options' => $bundles,
      '#default_value' => $consumer->getEntityBundle(),
      '#states' => array(
        'visible' => array(
          ':input[name="entity_type"]' => array('value' => $entity_type),
        ),
      ),
      '#required' => TRUE,
    );
  }

  $form['enabled'] = array(
    '#title' => t('Enabled'),
    '#type' => 'checkbox',
    '#default_value' => ($op == 'add') ? TRUE : $consumer->getEnabled(),
  );
  $form['status'] = array(
    '#value' => ($op == 'add') ? ENTITY_CUSTOM : $consumer->getStatus(),
  );

  $form['mapping'] = array(
    '#tree' => TRUE,
    '#theme' => 'table',
    '#header' => array(t('Source'), t('Destination')),
    '#rows' => array(),
  );

  $fields = field_info_instances();
  foreach ($fields as $entity_type => $bundles) {
    foreach ($bundles as $bundle => $fields) {
      foreach ($fields as $field_name => $field) {
        $label = array();
        $label[] = $entity_info[$entity_type]['label'];
        $label[] = $entity_info[$entity_type]['bundles'][$bundle]['label'];
        $label[] = $field['label'];

        $destination = array('#markup' => implode(' - ', $label));
        $source = array('#type' => 'textfield');
        if ($bundle == $consumer->getEntityBundle() && $entity_type == $consumer->getEntityType()) {
          $source['#default_value'] = $consumer->getMappingSource($field_name);
        }
        $form['mapping'][] = array(
          "$entity_type-$bundle-$field_name" => &$source,
          'destination' => &$destination,
        );
        $form['mapping']['#rows'][] = array(
          array('data' => &$source),
          array('data' => &$destination),
        );
        unset($destination);
        unset($source);
      }
    }
  }

  $form['actions'] = array('#type' => 'actions');
  $form['actions']['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save'),
    '#weight' => 40,
  );
  return $form;
}

/**
 * Form API submit callback for the type form.
 *
 * @see integration_consumer_form()
 */
function integration_consumer_form_submit(&$form, &$form_state) {

  $entity_info = entity_get_info();
  $entity_type = $form_state['values']['entity_type'];
  $form_state['values']['entity_bundle'] = $form_state['values']['entity_bundle_' . $entity_type];
  $bundle = $form_state['values']['entity_bundle'];
  foreach ($entity_info as $_type => $info) {
    unset($form_state['values']['entity_bundle_' . $_type]);
  }

  // Sanitize mapping.
  $mapping = array();
  foreach ($form_state['values']['mapping'] as $mapping_row) {
    $keys = array_keys($mapping_row);
    $field_id = array_shift($keys);
    $field_value = trim(array_shift($mapping_row));
    list($_type, $_bundle, $_name) = explode('-', $field_id);
    if ($field_value && ($entity_type == $_type) && ($bundle == $_bundle)) {
      $mapping[$_name] = $field_value;
    }
  }
  $form_state['values']['mapping'] = $mapping;

  /** @var ConsumerConfiguration $consumer */
  $consumer = entity_ui_form_submit_build_entity($form, $form_state);
  $consumer->save();

  drupal_set_message(t('Configuration has been saved.'));
  $form_state['redirect'] = 'admin/config/services/integration/consumer';
}
