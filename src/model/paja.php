<?php

  require_once HELPERS_DIR . 'DB.php';

  function haePajat() {
    return DB::run('SELECT * FROM paja ORDER BY paj_alkaa;')->fetchAll();
  }


    function haePaja($id) {
    return DB::run('SELECT * FROM paja WHERE idpaja = ?;',[$id])->fetch();
  }

?>
