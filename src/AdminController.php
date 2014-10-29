<?php

namespace Drupal\bd_contact;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;

class AdminController extends ControllerBase {

  function content() {

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
        'data' => array(\Drupal::l($id, new Url('bd_contact_edit', array('id' => $id))), $content->name, $content->message, \Drupal::l(t('Delete'), new Url('bd_contact_delete', array('id' => $id)))),
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
