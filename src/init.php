<?php

  require_once '../config/config.php';
  require_once '../vendor/autoload.php';
  require_once HELPERS_DIR . 'form.php';
  require_once HELPERS_DIR . 'DB.php';
  require_once HELPERS_DIR . 'secret.php';  // <- tämä lisää funktiot generateResetCode() ja generateActivationCode

?>
