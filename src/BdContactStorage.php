<?php

namespace Drupal\bd_contact;

class BdContactStorage {

  static function getAll() {
    $result = db_query('SELECT * FROM {bd_contact}')->fetchAllAssoc('id');
    return $result;
  }

  static function exists($id) {
    return (bool) $this->get($id);
  }

  static function add($name, $message) {
    db_insert('bd_contact')->fields(array(
      'name' => $name,
      'message' => $message,
    ))->execute();
  }

  static function delete($id) {
    db_delete('bd_contact')->condition('id', $id)->execute();
  }

}
