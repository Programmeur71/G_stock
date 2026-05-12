<?php 
require_once 'Controller.php';
	date_default_timezone_set('Africa/Douala');

	$date_a = date('Y-m-d H:i:s');


if (isset($_REQUEST['action'])) {

	$action = $_REQUEST['action'];

  switch ($action) {

  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui les mois ou on a effectuer les ventes dans une annee 
  	 * 
  	 * ************************************************************
  	 */
    case 'getAnnee':

    	 $annee = addslashes(htmlspecialchars($_REQUEST['annee']));


		    header('Access-Control-Allow-Origin: *');
		    header('Content-Type: application/json');

    	$ok = $statistiquedb->getMoiVente($annee);

			echo json_encode($ok);

    break;

  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui les ventes d'un moi dans une annee 
  	 * 
  	 * ************************************************************
  	 */
    case 'getAnnee_moi':

    	 $annee = addslashes(htmlspecialchars($_REQUEST['annee']));
    	 $moi = addslashes(htmlspecialchars($_REQUEST['moi']));


		    header('Access-Control-Allow-Origin: *');
		    header('Content-Type: application/json');

    	$ok = $statistiquedb->VenteMoi($annee, $moi);

			echo json_encode($ok);

    break;

  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui liste les ventes de toute les annees
  	 * 
  	 * ************************************************************
  	 */
    case 'VenteAnnee':

		    header('Access-Control-Allow-Origin: *');
		    header('Content-Type: application/json');

    	$ok = $statistiquedb->VenteAnnee();

			echo json_encode($ok);

    break;

  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui liste les ventes annuler
  	 * 
  	 * ************************************************************
  	 */
    case 'readAlls':


	    header('Access-Control-Allow-Origin: *');
	    header('Content-Type: application/json');

			echo json_encode($statistiquedb->getVenteAnnuler());

    break;

  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui liste les detail d'une ventes annuler
  	 * 
  	 * ************************************************************
  	 */
    case 'readAll':

			$ok = $statistiquedb->getVenteAnnuler($_POST['code']);

			header('Access-Control-Allow-Origin: *');
			header('Content-Type: application/json');

			echo json_encode($ok);

    break;
//********************************************************
    default:
      header("location:../index.php");
    break;
}} else {
	header("location:../index.php");
}
?>
