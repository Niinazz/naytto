<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//virheet selaimessa näkyviin!


  // Aloitetaan istunnot.
  session_start();

// Suoritetaan projektin alustusskripti.

require_once '../src/init.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);




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
          case "/vahvista":
      if (isset($_GET['key'])) {
        $key = $_GET['key'];
        require_once MODEL_DIR . 'osallistuja.php';
        if (vahvistaTili($key)) {
          echo $templates->render('tili_aktivoitu');
        } else {
          echo $templates->render('tili_aktivointi_virhe');
        }
      } else {
        header("Location: " . $config['urls']['baseUrl']);
      }
      break;

                   case "/kirjaudu":
      if (isset($_POST['laheta'])) {
        require_once CONTROLLER_DIR . 'kirjaudu.php';
        if (tarkistaKirjautuminen($_POST['email'],$_POST['salasana'])) {
          require_once MODEL_DIR . 'osallistuja.php';
          $user = haeOsallistuja($_POST['email']);
          if ($user['vahvistettu']) {
            session_regenerate_id();
            $_SESSION['user'] = $user['email'];
            header("Location: " . $config['urls']['baseUrl']);
          } else {
            echo $templates->render('kirjaudu', [ 'error' => ['virhe' => 'Tili on vahvistamatta! Ole hyvä, ja vahvista tili sähköpostissa olevalla linkillä.']]);
          }
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

       case "/tilaa_vaihtoavain":
    // Puhdistetaan lomaketiedot
    $formdata = cleanArrayData($_POST);
   

    // Tarkistetaan, onko lomake lähetetty
    if (isset($formdata['laheta'])) {

      

        // Haetaan käyttäjä sähköpostilla
        require_once MODEL_DIR . 'osallistuja.php';
        $user = haeOsallistuja($formdata['email'] ?? '');
       

        

        if ($user) {
            // 1. Luodaan satunnainen reset-avain
            require_once HELPERS_DIR . 'secret.php'; // generateResetCode()
            $avain = generateResetCode($user['email']);

            // 2. Tallennetaan avain tietokantaan ja asetetaan voimassaoloaika
            asetaVaihtoavain($user['email'], $avain);

            // 3. Luodaan sähköpostilinkki salasanan vaihtoon
            $linkki = BASEURL . "/vaihda_salasana?key=" . $avain;
            $viesti = "Klikkaa tästä linkistä vaihtaaksesi salasanasi: $linkki";

            // 4. Lähetetään sähköposti
            // Kommentoi mail() testivaiheessa ja käytä echo nähdäksesi linkin
             mail($user['email'], "Salasanan vaihtolinkki", $viesti);
            
            
        }

        // 5. Näytetään aina sama vahvistusnäkymä
        echo $templates->render('tilaa_vaihtoavain_lahetetty');

    } else {
        // Lomaketta ei lähetetty → näytetään lomake
        echo $templates->render('tilaa_vaihtoavain_lomake');
    }
    break;


      default:
      echo $templates->render('notfound');
  }


?> 