<?php

namespace Drupal\bd_contact;

use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\String;

class AddForm implements FormInterface {

  protected $id;

  function getFormId() {
    return 'bd_contact_add';
  }

  function buildForm(array $form, FormStateInterface $form_state, $id = '') {
    if ($id) {
      $this->id = $id;
      $bd_contact = BdContactStorage::get($this->id);
    }
    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => t('Name'),
      '#default_value' => isset($bd_contact) ? $bd_contact->name : '',
    );
    $form['message'] = array(
      '#type' => 'textarea',
      '#title' => t('Message'),
      '#default_value' => isset($bd_contact) ? $bd_contact->message : '',
    );
    $form['actions'] = array('#type' => 'actions');
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => ($bd_contact) ? t('Edit') : t('Add'),
    );
    return $form;
  }

  function validateForm(array &$form, FormStateInterface $form_state) {
    /* Nothing to validate on this form */
  }

  function submitForm(array &$form, FormStateInterface $form_state) {
    $form_values = $form_state->getValues();

    $name = $form_values['name'];
    $message = $form_values['message'];
    if (!empty($this->id)) {
      BdContactStorage::edit($this->id, String::checkPlain($name), String::checkPlain($message));

      \Drupal::logger('bd_contact')->notice('BD Contact message from %name has been edited.', array('%name' => $name));
      drupal_set_message(t('Your message has been edited'));
    }
    else {
      BdContactStorage::add(String::checkPlain($name), String::checkPlain($message));

      \Drupal::logger('bd_contact')->notice('BD Contact message from %name has been submitted.', array('%name' => $name));
      drupal_set_message(t('Your message has been submitted'));
    }
    $form_state->setRedirect('bd_contact_list');
  }

}
