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

   switch ($request) {
    case '/':
    case '/pajat':
      require_once MODEL_DIR . 'paja.php';
      $pajat = haePajat();
      echo $templates->render('pajat',['pajat' => $pajat]);
      break;
    case '/paja':
      require_once MODEL_DIR . 'paja.php';
      $paja = haePaja($_GET['id']);
      if ($paja) {
        echo $templates->render('paja',['paja' => $paja]);
      } else {
        echo $templates->render('pajanotfound');
      }
      break;
   case '/lisaa_tili':
      if (isset($_POST['laheta'])) {
        $formdata = cleanArrayData($_POST);
        require_once CONTROLLER_DIR . 'tili.php';
        $tulos = lisaaTili($formdata);
        if ($tulos['status'] == "200") {
          echo $templates->render('tili_luotu', ['formdata' => $formdata]);
          break;
        }
        echo $templates->render('lisaa_tili', ['formdata' => $formdata, 'error' => $tulos['error']]);
        break;
      } else {
        echo $templates->render('lisaa_tili', ['formdata' => [], 'error' => []]);
        break;
      }
      default:
      echo $templates->render('notfound');
  }


?> 