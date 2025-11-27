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


  function haeKayttajanPajat($idosallistuja) {
    return DB::run("
        SELECT p.idpaja, p.nimi, p.kuvaus, p.paj_alkaa, p.paj_loppuu
        FROM osallistuminen o
        JOIN paja p ON o.idpaja = p.idpaja
        WHERE o.idosallistuja = ?
        ORDER BY p.paj_alkaa
    ", [$idosallistuja])->fetchAll();
}

?>
