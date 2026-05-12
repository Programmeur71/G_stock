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
  	 * controller qui trouve un client
  	 * 
  	 * ************************************************************
  	 */
	    case 'trouver':

			$result = $clientdb->trouver(htmlspecialchars($_POST["keyword"]));

			if(!empty($result)) {?>

				<ul id="result-list">
					<?php
					foreach($result as $desc) {?>

						<li onClick="selectMedic(<?=$desc->id?>)"><b><?=$desc->tel?></b></li>

					<?php }?>
				</ul>

			<?php }else{ ?>			

			<ul id="result-list">
			
			</ul>

			<?php }

	    break;
  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui trouve les informations d'un medicament 
  	 * 
  	 * ************************************************************
  	 */
    case 'info':

		$result = $clientdb->getClient($_POST["id"]);

		header('Access-Control-Allow-Origin: *');
		header('Content-Type: application/json');

		echo json_encode($result);

    break;

  	/**
  	 * ************************
  	 * 
  	 * Ajouter un client
  	 * 
  	 * ************************
  	 */
    case 'ajouter':

			$droit = $users->verification_droit($_SESSION['Pharmacie']->id, 'stock_add');

				if ($droit != false) {

					$nom = addslashes(htmlspecialchars( strtoupper($_REQUEST['nom']) ));
					$prenom = addslashes(htmlspecialchars( strtoupper($_REQUEST['prenom']) ));
					$sexe = addslashes(htmlspecialchars($_REQUEST['sexe']));
					$adresse = addslashes(htmlspecialchars($_REQUEST['adresse']));
					$tel = addslashes(htmlspecialchars($_REQUEST['tel']));

						try {

							$ok = $clientdb->addClient($nom, $prenom, $sexe, $adresse, $tel, $date_actuele);

							echo json_encode(1);
							
						} catch (Exception $e) {

							echo 'un autre client a deja ce numero';
							
						}

				} else {

				echo "Vous n'avez pas le droit d'effectuer cette opperation !!!";

				}

    break;


  	/**
  	 * ************************
  	 * 
  	 * Modifier un client
  	 * 
  	 * ************************
  	 */
    case 'modifier':

			$droit = $users->verification_droit($_SESSION['Pharmacie']->id, 'stock_editer');

				if ($droit != false) {

					$id = addslashes(htmlspecialchars($_REQUEST['id']));
					$nom = addslashes(htmlspecialchars( strtoupper($_REQUEST['nom']) ));
					$prenom = addslashes(htmlspecialchars( strtoupper($_REQUEST['prenom']) ));
					$sexe = addslashes(htmlspecialchars($_REQUEST['sexe']));
					$adresse = addslashes(htmlspecialchars($_REQUEST['adresse']));
					$tel = addslashes(htmlspecialchars($_REQUEST['tel']));

						try {

							$ok = $clientdb->setClient($nom, $prenom, $sexe, $adresse, $tel, $date_actuele, $id);

							echo json_encode(1);
							
						} catch (Exception $e) {

							echo 'un autre client a deja ce numero';
							
						}

				} else {

				echo "Vous n'avez pas le droit d'effectuer cette opperation !!!";

				}

    break;

  	/**
  	 * ************************
  	 * 
  	 * Supprimer un client
  	 * 
  	 * ************************
  	 */
    case 'delete':

		$droit = $users->verification_droit($_SESSION['Pharmacie']->id, 'stock_editer');

			if ($droit != false) {

				$id = addslashes(htmlspecialchars($_REQUEST['id']));

				$ok = $clientdb->delete($id);
				
				echo json_encode($ok);

			} else {

				echo "Vous n'avez pas le droit d'effectuer cette opperation !!!";

			}

    break;
//*******************************************
    default:
      header("location:../index.php");
    break;
}} else {
	header("location:../index.php");
}
?>
