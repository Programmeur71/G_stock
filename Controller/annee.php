<?php 
require_once 'Controller.php';
	date_default_timezone_set('Africa/Douala');

	$date_actuele = date('Y-m-d H:i:s');


if (isset($_REQUEST['action'])) {

	$action = $_REQUEST['action'];

  switch ($action) {
//********************************************

  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui return les annees
  	 * 
  	 * ************************************************************
  	 */
    case 'getannee':

		$result = $anneedb->getAnnee();

		header('Access-Control-Allow-Origin: *');
		header('Content-Type: application/json');

		echo json_encode($result);

    break;


//*******************************************
    default:
      header("location:../index.php");
    break;
}} else {
	header("location:../index.php");
}
?>
