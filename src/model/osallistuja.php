<?php

  require_once HELPERS_DIR . 'DB.php';

  function lisaaOsallistuja($nimi,$email,$salasana) {
    DB::run('INSERT INTO osallistuja (nimi, email,salasana) VALUE  (?,?,?);',[$nimi,$email,$salasana]);
    return DB::lastInsertId();
  }

  function haeOsallistujaSahkopostilla($email) {
    return DB::run('SELECT * FROM osallistuja WHERE email = ?;', [$email])->fetchAll();
  }

    function haeOsallistuja($email) {
    return DB::run('SELECT * FROM osallistuja WHERE email = ?;', [$email])->fetch();
  }

    function paivitaVahvavain($email,$avain) {
    return DB::run('UPDATE osallistuja SET vahvavain = ? WHERE email = ?', [$avain,$email])->rowCount();
  }

  function vahvistaTili($avain) {
    return DB::run('UPDATE osallistuja SET vahvistettu = TRUE WHERE vahvavain = ?', [$avain])->rowCount();
  }

  function asetaVaihtoavain($email,$avain) {
    return DB::run('UPDATE osallistuja SET nollausavain = ?, nollausaika = NOW() + INTERVAL 30 MINUTE WHERE email = ?', [$avain,$email])->rowCount();
  }

  function tarkistaVaihtoavain($avain) {
    return DB::run('SELECT nollausavain, nollausaika-NOW() AS aikaikkuna FROM osallistuja WHERE nollausavain = ?', [$avain])->fetch();
  }

  function vaihdaSalasanaAvaimella($salasana,$avain) {
    return DB::run('UPDATE osallistuja SET salasana = ?, nollausavain = NULL, nollausaika = NULL WHERE nollausavain = ?', [$salasana,$avain])->rowCount();
  }

?>
