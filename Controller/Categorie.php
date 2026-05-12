<?php
	require_once 'Controller.php';

	date_default_timezone_set('Africa/Douala');

	$date = date('Y-m-d H:i:s');

	extract($_POST);

if (isset($_REQUEST['action'])) {

	$action = $_REQUEST['action'];

switch ($action) {

    case 'droit':

		$data = $gradedb->getGrade(htmlspecialchars($_REQUEST['id_user']));

		header('Access-Control-Allow-Origin: *');
		header('Content-Type: application/json');

		echo json_encode($data);

    break;

    case 'update':

		$droit_personel = $users->verification_droit($_SESSION['Pharmacie']->id, 'stock_editer');
		
		if ($droit_personel != false) {

				$id = htmlspecialchars($_REQUEST['id_grade']);  
				$grades = htmlspecialchars($_REQUEST['grades']);  

				$Stock = htmlspecialchars($_REQUEST['Stock']);  
				$editer_s = htmlspecialchars($_REQUEST['editer_s']);  
				$ajouter_s = htmlspecialchars($_REQUEST['ajouter_s']);  

				$Statistique = htmlspecialchars($_REQUEST['Statistique']);  
				$editer_st = htmlspecialchars($_REQUEST['editer_st']);  
				$ajouter_st = htmlspecialchars($_REQUEST['ajouter_st']); 

				$Finance = htmlspecialchars($_REQUEST['Finance']);  
				$editer_f = htmlspecialchars($_REQUEST['editer_f']);  
				$ajouter_f = htmlspecialchars($_REQUEST['ajouter_f']);  

				$Personnel = htmlspecialchars($_REQUEST['Personnel']);  
				$editer_p = htmlspecialchars($_REQUEST['editer_p']);  
				$ajouter_p = htmlspecialchars($_REQUEST['ajouter_p']); 


				$ok = $gradedb->Updates($id, $grades, $Stock, $editer_s, $ajouter_s, $Statistique, $editer_st, $ajouter_st, $Finance, $editer_f, $ajouter_f, $Personnel, $editer_p, $ajouter_p);

			  echo json_encode(1);
			
		} else {

			echo "Vous n'avez pas le droit d'effectuer cette opperation !!!";

		}

    break;

    case 'create':

		$droit_personel = $users->verification_droit($_SESSION['Pharmacie']->id, 'stock_add');
		if ($droit_personel != false) {

		    try {

				$Stock = htmlspecialchars($_REQUEST['Stock']);  
				$editer_s = htmlspecialchars($_REQUEST['editer_s']);  
				$ajouter_s = htmlspecialchars($_REQUEST['ajouter_s']);  

				$Statistique = htmlspecialchars($_REQUEST['Statistique']);  
				$editer_st = htmlspecialchars($_REQUEST['editer_st']);  
				$ajouter_st = htmlspecialchars($_REQUEST['ajouter_st']); 

				$Finance = htmlspecialchars($_REQUEST['Finance']);  
				$editer_f = htmlspecialchars($_REQUEST['editer_f']);  
				$ajouter_f = htmlspecialchars($_REQUEST['ajouter_f']);  

				$Personnel = htmlspecialchars($_REQUEST['Personnel']);  
				$editer_p = htmlspecialchars($_REQUEST['editer_p']);  
				$ajouter_p = htmlspecialchars($_REQUEST['ajouter_p']);  

				$grades = htmlspecialchars($_REQUEST['grades']);

				 $ok =$gradedb->Create($grades, $Stock, $editer_s, $ajouter_s, $Statistique, $editer_st, $ajouter_st, $Finance, $editer_f, $ajouter_f, $Personnel, $editer_p, $ajouter_p);

				 echo json_encode(1);
		
			} catch (Exception $e) {
				echo " impossible d'enregistrer cette grade !!!";
			}

		} else {

			echo "Vous n'avez pas le droit d'effectuer cette opperation !!!";

		}

    break;

    case 'delete':

		$droit_personel = $users->verification_droit($_SESSION['Pharmacie']->id, 'stock_editer');
		if ($droit_personel != false) {

			 $responce = $gradedb->Delete(htmlspecialchars($_REQUEST['id_user']));

			 echo json_encode($responce);

		} else {

			echo 0;

		}

    break;


    default:
      header("location:../index.php");
    break;
}}else {
	header("location:../index.php");
}	

?>
