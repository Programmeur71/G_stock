<?php
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }
// include('Controller/securite.php');
// require_once 'Model/Model.php';
// $session = isset($_SESSION['Pharmacie']) ? $_SESSION['Pharmacie'] : null;
date_default_timezone_set('Africa/Douala');


if (isset($_GET['route'])) {

  $route = str_replace("/", "-", $_GET['route']);

  $route = explode("-", $route);

}

if (count($route) > 3) {

  header("location:404.php");

}


if (count($route) == 1) {

  switch ($route[0]) {

    case 'Historique':

      require_once 'Vue/templete/headerP.php';
         echo"Historique";//include 'Vue/personnel/profile.php';
      require_once 'Vue/templete/footer.php';

    break;

    case 'login':
         require_once 'Vue/pages/auth/login.php';
    break;

    case 'register':
         require_once 'Vue/pages/auth/register.php';
    break;

    case 'dashbord':
      require_once 'Vue/templates/header.php';
        require_once 'Vue/pages/dashbord.php';
      require_once 'Vue/templates/footer.php';
    break;

    case 'client':
      require_once 'Vue/templates/header.php';
        echo $route[0];
      require_once 'Vue/templates/footer.php';
    break;

    case 'fournisseur':
      require_once 'Vue/templates/header.php';
        echo $route[0];
      require_once 'Vue/templates/footer.php';
    break;

    case 'produit':
      require_once 'Vue/templates/header.php';
        echo $route[0];
      require_once 'Vue/templates/footer.php';
    break;

    case 'commande':
      require_once 'Vue/templates/header.php';
        echo $route[0];
      require_once 'Vue/templates/footer.php';
    break;

    case 'vente':
      require_once 'Vue/templates/header.php';
        echo $route[0];
      require_once 'Vue/templates/footer.php';
    break;

    case 'users':
      require_once 'Vue/templates/header.php';
        echo $route[0];
      require_once 'Vue/templates/footer.php';
    break;

    case 'groupe':
      require_once 'Vue/templates/header.php';
        echo $route[0];
      require_once 'Vue/templates/footer.php';
    break;

    case 'permissions':
      require_once 'Vue/templates/header.php';
        echo $route[0];
      require_once 'Vue/templates/footer.php';
    break;

    case 'profile':
      require_once 'Vue/templates/header.php';
        echo $route[0];
      require_once 'Vue/templates/footer.php';
    break;

    default:
      header("location:404.php");
    break;
  }
}
?>