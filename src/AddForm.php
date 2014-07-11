<?php

namespace Drupal\bd_contact;

use Drupal\Core\Form\FormInterface;

class AddForm implements FormInterface {

  protected $id;

  function getFormId() {
    return 'bd_contact_add';
  }

  function buildForm(array $form, array &$form_state, $id = '') {
    $this->id = $id;
    $bd_contact = BdContactStorage::get($id);
    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => t('Name'),
      '#default_value' => ($bd_contact) ? $bd_contact->name : '',
    );
    $form['message'] = array(
      '#type' => 'textarea',
      '#title' => t('Message'),
      '#default_value' => ($bd_contact) ? $bd_contact->message : '',
    );
    $form['actions'] = array('#type' => 'actions');
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => ($bd_contact) ? t('Edit') : t('Add'),
    );
    return $form;
  }

  function validateForm(array &$form, array &$form_state) {
    /* Nothing to validate on this form */
  }

  function submitForm(array &$form, array &$form_state) {
    $name = $form_state['values']['name'];
    $message = $form_state['values']['message'];
    if (!empty($this->id)) {
      BdContactStorage::edit($this->id, check_plain($name), check_plain($message));

      watchdog('bd_contact', 'BD Contact message from %name has been edited.', array('%name' => $name));
      drupal_set_message(t('Your message has been edited'));
    }
    else {
      BdContactStorage::add(check_plain($name), check_plain($message));

      watchdog('bd_contact', 'BD Contact message from %name has been submitted.', array('%name' => $name));
      drupal_set_message(t('Your message has been submitted'));
    }
    $form_state['redirect'] = 'admin/content/bd_contact';
    return;
  }

}
