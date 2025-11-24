<?php

  require_once HELPERS_DIR . 'DB.php';

  function haeOsallistuminen($idosallistuja,$idpaja) {
    return DB::run('SELECT * FROM osallistuminen WHERE idosallistuja = ? AND idpaja = ?',
                   [$idosallistuja, $idpaja])->fetchAll();
  }

  function lisaaOsallistuminen($idosallistuja,$idpaja) {
    DB::run('INSERT INTO osallistuminen (idosallistuja, idpaja) VALUE (?,?)',
            [$idosallistuja, $idpaja]);
    return DB::lastInsertId();
  }

  function poistaOsallistuminen($idosallistuja, $idpaja) {
    return DB::run('DELETE FROM osallistuminen  WHERE idosallistuja = ? AND idpaja = ?',
                   [$idosallistuja, $idpaja])->rowCount();
  }

?>
