<?php

namespace Drupal\bd_contact;

class AdminController {

  function content() {
    $add_link = '<p>' . l(t('New message'), 'admin/content/bd_contact/add') . '</p>';

    // Table header.
    $header = array(
      'id' => t('Id'),
      'name' => t('Submitter name'),
      'message' => t('Message'),
      'operations' => t('Delete'),
    );

    $rows = array();

    foreach (BdContactStorage::getAll() as $id => $content) {
      // Row with attributes on the row and some of its cells.
      $rows[] = array(
        'data' => array($id, $content->name, $content->message, l('Delete', "admin/content/bd_contact/delete/$id")),
      );
    }

    $table = array(
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#attributes' => array(
        'id' => 'bd-contact-table',
      ),
    );

    return $add_link . drupal_render($table);

  }

}
