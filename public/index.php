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
      $tapahtumat = haePajat();
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
         // ... switch-lauseen alku säilyy sellaisenaan
    case '/lisaa_tili':
      if (isset($_POST['laheta'])) {
        require_once MODEL_DIR . 'osallistuja.php';
        $salasana = password_hash($_POST['salasana1'], PASSWORD_DEFAULT);
        $id = lisaaOsallistuja($_POST['nimi'],$_POST['email'],$salasana);
        echo "Tili on luotu tunnisteella $id";
        break;
      } else {
        echo $templates->render('lisaa_tili');
        break;
      }    
    // ... switch-lauseen loppu säilyy sellaisenaan
    default:
      echo $templates->render('notfound');
  }    


?> 