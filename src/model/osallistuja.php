<?php

  require_once HELPERS_DIR . 'DB.php';

  function lisaaOsallistuja($nimi,$email,$salasana) {
    DB::run('INSERT INTO osallistuja (nimi, email,salasana) VALUE  (?,?,?);',[$nimi,$email,$salasana]);
    return DB::lastInsertId();
  }

?>
