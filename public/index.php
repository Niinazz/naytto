<?php

  // Aloitetaan istunnot.
  session_start();

// Suoritetaan projektin alustusskripti.
require_once '../src/init.php';

  // Haetaan kirjautuneen käyttäjän tiedot.
  if (isset($_SESSION['user'])) {
    require_once MODEL_DIR . 'osallistuja.php';
    $loggeduser = haeOsallistuja($_SESSION['user']);
  } else {
    $loggeduser = NULL;
  }



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
      require_once MODEL_DIR . 'osallistuminen.php';
      $paja = haePaja($_GET['id']);
      if ($paja) {
        if ($loggeduser) {
          $osallistuminen = haeOsallistuminen($loggeduser['idosallistuja'],$paja['idpaja']);
        } else {
          $osallistuminen = NULL;
        }
        echo $templates->render('paja',['paja' => $paja,
                                             'osallistuminen' => $osallistuminen,
                                             'loggeduser' => $loggeduser]);
      } else {
        echo $templates->render('pajanotfound');
      }
      break;
          case '/osallistu':
      if ($_GET['id']) {
        require_once MODEL_DIR . 'osallistuminen.php';
        $idpaja = $_GET['id'];
        if ($loggeduser) {
          lisaaOsallistuminen($loggeduser['idosallistuja'],$idpaja);
        }
        header("Location: paja?id=$idpaja");
      } else {
        header("Location: pajat");
      }
      break;
          case '/peru':
      if ($_GET['id']) {
        require_once MODEL_DIR . 'osallistuminen.php';
        $idpaja = $_GET['id'];
        if ($loggeduser) {
          poistaOsallistuminen($loggeduser['idosallistuja'],$idpaja);
        }
        header("Location: paja?id=$idpaja");
      } else {
        header("Location: pajat");  
      }
      break;

   case '/lisaa_tili':
      if (isset($_POST['laheta'])) {
        $formdata = cleanArrayData($_POST);
        require_once CONTROLLER_DIR . 'tili.php';
         $tulos = lisaaTili($formdata,$config['urls']['baseUrl']);
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
               case "/kirjaudu":
      if (isset($_POST['laheta'])) {
        require_once CONTROLLER_DIR . 'kirjaudu.php';
        if (tarkistaKirjautuminen($_POST['email'],$_POST['salasana'])) {
          session_regenerate_id();
          $_SESSION['user'] = $_POST['email'];
          header("Location: " . $config['urls']['baseUrl']);
        } else {
          echo $templates->render('kirjaudu', [ 'error' => ['virhe' => 'Väärä käyttäjätunnus tai salasana!']]);
        }
      } else {
        echo $templates->render('kirjaudu', [ 'error' => []]);
      }
      break;
    case "/logout":
      require_once CONTROLLER_DIR . 'kirjaudu.php';
      logout();
      header("Location: " . $config['urls']['baseUrl']);
      break;
      default:
      echo $templates->render('notfound');
  }


?> 