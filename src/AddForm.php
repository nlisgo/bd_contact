<?php

namespace Drupal\bd_contact;

use Drupal\Core\Form\FormInterface;

class AddForm implements FormInterface {

  protected $id;

  function getFormId() {
    return 'bd_contact_add';
  }

  function buildForm(array $form, array &$form_state) {
    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => t('Name'),
    );
    $form['message'] = array(
      '#type' => 'textarea',
      '#title' => t('Message'),
    );
    $form['actions'] = array('#type' => 'actions');
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Add'),
    );
    return $form;
  }

  function validateForm(array &$form, array &$form_state) {
    /* Nothing to validate on this form */
  }

  function submitForm(array &$form, array &$form_state) {
    $name = $form_state['values']['name'];
    $message = $form_state['values']['message'];
    BdContactStorage::add(check_plain($name), check_plain($message));

    watchdog('bd_contact', 'BD Contact message from %name has been submitted.', array('%name' => $name));
    drupal_set_message(t('Your message has been submitted'));
    $form_state['redirect'] = 'admin/content/bd_contact';
    return;
  }

}
