<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$public_routes = ['login', 'register'];
$current_route = $_GET['route'] ?? '';

if (!in_array($current_route, $public_routes)) {
    include('Controller/securite.php');
}

require_once 'Model/Model.php';

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
      if ($_SESSION['user']->id_client !== null) {
          require_once 'Vue/templates/header_client.php';
          require_once 'Vue/pages/historique_client.php';
          require_once 'Vue/templates/footer.php';
      } else {
          require_once 'Vue/templates/header.php';
          require_once 'Vue/pages/liste_ventes.php';
          require_once 'Vue/templates/footer.php';
      }
    break;

    case 'Approvisionnement':
      require_once 'Vue/templates/header.php';
      require_once 'Vue/pages/liste_appro.php';
      require_once 'Vue/templates/footer.php';
    break;

    case 'login':
         require_once 'Vue/pages/auth/login.php';
    break;

    case 'register':
         require_once 'Vue/pages/auth/register.php';
    break;

    case 'ecommerce':
      require_once 'Vue/templates/header_client.php';
        require_once 'Vue/pages/ecommerce.php';
      require_once 'Vue/templates/footer.php';
    break;

    case 'dashbord':
      require_once 'Vue/templates/header.php';
        require_once 'Vue/pages/dashbord.php';
      require_once 'Vue/templates/footer.php';
    break;

    case 'client':
      require_once 'Vue/templates/header.php';
        require_once 'Vue/pages/client.php';
      require_once 'Vue/templates/footer.php';
    break;

    case 'fournisseur':
      require_once 'Vue/templates/header.php';
        require_once 'Vue/pages/fournisseur.php';
      require_once 'Vue/templates/footer.php';
    break;

    case 'produit':
      require_once 'Vue/templates/header.php';
        require_once 'Vue/pages/produit.php';
      require_once 'Vue/templates/footer.php';
    break;

    case 'stock':
      require_once 'Vue/templates/header.php';
        require_once 'Vue/pages/stock.php';
      require_once 'Vue/templates/footer.php';
    break;

    case 'commande':
      require_once 'Vue/templates/header.php';
        require_once 'Vue/pages/commande.php';
      require_once 'Vue/templates/footer.php';
    break;

    case 'vente':
      require_once 'Vue/templates/header.php';
        require_once 'Vue/pages/vente.php';
      require_once 'Vue/templates/footer.php';
    break;

    case 'users':
      require_once 'Vue/templates/header.php';
        require_once 'Vue/pages/users.php';
      require_once 'Vue/templates/footer.php';
    break;

    case 'groupe':
      require_once 'Vue/templates/header.php';
        require_once 'Vue/pages/groupe.php';
      require_once 'Vue/templates/footer.php';
    break;

    case 'permissions':
      require_once 'Vue/templates/header.php';
        require_once 'Vue/pages/permissions.php';
      require_once 'Vue/templates/footer.php';
    break;

    case 'profile':
      if ($_SESSION['user']->id_client !== null) {
          require_once 'Vue/templates/header_client.php';
      } else {
          require_once 'Vue/templates/header.php';
      }
        require_once 'Vue/pages/profile.php';
      require_once 'Vue/templates/footer.php';
    break;

    default:
      header("location:404.php");
    break;
  }
}
?>