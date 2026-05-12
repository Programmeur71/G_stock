<?php 
require_once 'Controller.php';
	date_default_timezone_set('Africa/Douala');

	$date_actuele = date('Y-m-d H:i:s');


if (isset($_REQUEST['action'])) {

	$action = $_REQUEST['action'];

  switch ($action) {
//********************************************

  	/**
  	 * ************************
  	 * 
  	 * Ajouter un fournisseur
  	 * 
  	 * ************************
  	 */
    case 'ajouter':

			$droit = $users->verification_droit($_SESSION['Pharmacie']->id, 'stock_add');

				if ($droit != false) {

					$code = addslashes(htmlspecialchars(strtoupper($_REQUEST['code'])));
					$nom = addslashes(htmlspecialchars(strtoupper($_REQUEST['nom'])));
					$tel = addslashes(htmlspecialchars($_REQUEST['tel']));

					$ok = $fournisseurdb->setFournisseur($code, $nom, $tel);

					echo json_encode(1);

				} else {

				echo "Vous n'avez pas le droit d'effectuer cette opperation !!!";

				}

    break;


  	/**
  	 * ************************
  	 * 
  	 * Modifier un fournisseur
  	 * 
  	 * ************************
  	 */
    case 'modifier':

			$droit = $users->verification_droit($_SESSION['Pharmacie']->id, 'stock_editer');

				if ($droit != false) {

					$id = addslashes(htmlspecialchars($_REQUEST['id']));
					$code = addslashes(htmlspecialchars( strtoupper($_REQUEST['code']) ));
					$nom = addslashes(htmlspecialchars( strtoupper($_REQUEST['nom']) ));
					$tel = addslashes(htmlspecialchars($_REQUEST['tel']));

					$ok = $fournisseurdb->setFournisseur($code, $nom, $tel, $id);

					echo json_encode(1);

				} else {

				echo "Vous n'avez pas le droit d'effectuer cette opperation !!!";

				}

    break;

  	/**
  	 * ************************
  	 * 
  	 * Supprimer un fournisseur
  	 * 
  	 * ************************
  	 */
    case 'delete':

			$droit = $users->verification_droit($_SESSION['Pharmacie']->id, 'stock_editer');

				if ($droit != false) {

					$id = addslashes(htmlspecialchars($_REQUEST['id']));

					$ok = $fournisseurdb->delete($id);
					
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
