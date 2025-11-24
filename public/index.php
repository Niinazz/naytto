<?php

// Suoritetaan projektin alustusskripti.
require_once '../src/init.php';


  // Siistitään polku urlin alusta ja mahdolliset parametrit urlin lopusta.
  // Siistimisen jälkeen osoite /~koodaaja/naytto/paja?id=1 on 
  // lyhentynyt muotoon /tapahtuma.
 $request = str_replace($config['urls']['baseUrl'],'',$_SERVER['REQUEST_URI']);


  $request = strtok($request, '?');

  // Luodaan uusi Plates-olio ja kytketään se sovelluksen sivupohjiin.
  $templates = new League\Plates\Engine(TEMPLATE_DIR);



  


  // Selvitetään mitä sivua on kutsuttu ja suoritetaan sivua vastaava

  // käsittelijä.

  if ($request === '/' || $request === '/pajat') {
    require_once MODEL_DIR . 'paja.php';
    $pajat = haePajat();
    echo $templates->render('pajat',['pajat' => $pajat]);
     // ... ehtolauseen alku säilyy sellaisenaan
  } else if ($request === '/paja') {
    require_once MODEL_DIR . 'paja.php';
    $paja = haePaja($_GET['id']);
    if ($paja) {
      echo $templates->render('paja',['paja' => $paja]);
    } else {
      echo $templates->render('pajanotfound');
    }
  // ... loput ehtolauseesta säilyy sellaisenaan
  } else {
    echo $templates->render('notfound');
  }

?> 