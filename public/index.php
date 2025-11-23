<?php

// Suoritetaan projektin alustusskripti.
require_once '../src/init.php';


  // Siistitään polku urlin alusta ja mahdolliset parametrit urlin lopusta.
  // Siistimisen jälkeen osoite /~koodaaja/naytto/paja?id=1 on 
  // lyhentynyt muotoon /tapahtuma.
 $request = str_replace($config['urls']['baseUrl'],'',$_SERVER['REQUEST_URI']);


  $request = strtok($request, '?');



  // Selvitetään mitä sivua on kutsuttu ja suoritetaan sivua vastaava 

  // käsittelijä.

  if ($request === '/' || $request === '/pajat') {

    echo '<h1>Kaikki pajat</h1>';

  } else if ($request === '/paja') {

    echo '<h1>Yksittäisen pajan tiedot</h1>';

  } else {

    echo '<h1>Pyydettyä sivua ei löytynyt :(</h1>';

  }



?> 