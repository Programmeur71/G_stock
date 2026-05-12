<?php 
require_once 'Controller.php';
	date_default_timezone_set('Africa/Douala');

	$date_actuele = date('Y-m-d H:i:s');


if (isset($_REQUEST['action'])) {

	$action = $_REQUEST['action'];

  switch ($action) {

  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui liste les commandes avec ssp.class
  	 * 
  	 * ************************************************************
  	 */
    case 'readAlls':

		header('Access-Control-Allow-Origin: *');
		header('Content-Type: application/json');

		echo json_encode($commandedb->getCommande());

    break;
	case 'readAlls_ancien':

		header('Access-Control-Allow-Origin: *');
		header('Content-Type: application/json');

		echo json_encode($commandedb->getCommandeAncien());

    break;
  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui liste les commandes
  	 * 
  	 * ************************************************************
  	 */
	    case 'readAll':

			$ok = $commandedb->getCommande($_POST['code']);

			header('Access-Control-Allow-Origin: *');
			header('Content-Type: application/json');

			echo json_encode($ok);

	    break;

		case 'readAllAncien':

			$ok = $commandedb->getCommandeAncien($_POST['code']);

			header('Access-Control-Allow-Origin: *');
			header('Content-Type: application/json');

			echo json_encode($ok);

	    break;

    /**
  	 * ***********************************************
  	 * 
  	 * controller qui supprime une commande
  	 * 
  	 * ***********************************************
  	 */
	    case 'drop':

				$droit = $users->verification_droit($_SESSION['Pharmacie']->id, 'stock_editer');
				if ($droit != false) {

						 $ok = $commandedb->getCommandeDrop($_POST['code']);

						foreach ($ok as $key) {

							$commandedb->DropCommande2($key->qte, $key->code, $key->id_medicament);

						}

						$ok = $commandedb->DropCommande1($_POST['code']);

						echo json_encode(1);

				} else {
					echo "Vous n'avez pas le droit d'effectuer cette opperation !!!";
				}

	    break;

  	/**
  	 * ************************************************************
  	 * 
  	 * 						VALIDER LA COMMANDE
  	 * 
  	 * ************************************************************
  	 */
    case 'valider_com':

			$code = htmlspecialchars($_REQUEST['code']);

			$droit = $users->verification_droit($_SESSION['Pharmacie']->id, 'stock_add');

			if ($droit != false) {

				if(isset($_SESSION['stock'])){ 

					$contenu=$_SESSION['stock'];


					for($i=0;$i<count($contenu['id']);$i++){

			                $id_medicament=$contenu['id'][$i];
			                $id_fournisseur=$contenu['id_fournisseur'][$i];
			                $prixa=$contenu['prixa'][$i];
			                $prixv=$contenu['prixv'][$i];
			                $qte=$contenu['qte'][$i];
			                $datep=$contenu['datep'][$i];
			                $id_statut=$contenu['id_statut'][$i];

			                $ok = $commandedb->create($code, $id_fournisseur, $id_medicament, $_SESSION['Pharmacie']->id, $date_actuele, $datep, $qte, $id_statut, $prixa, $prixv);

			                $commandedb->viderPanier();

					}

				}
				echo json_encode(1);	

			} else {

				echo "Vous n'avez pas le droit d'effectuer cette opperation !!!";

			}

    break;


  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui ajoute un produit dans le panier de commande 
  	 * 
  	 * ************************************************************
  	 */
    case 'panier':

		$data=array(
			 	'id' =>$_POST["id"],
			 	'id_fournisseur' =>$_POST["fourid"],
			 	'fournisseur' =>$_POST["four"],
			 	'medicament' =>$_POST["nom"],
			 	'prixa' =>$_POST["prix_a"],
			 	'prixv' =>$_POST["prix_v"],
			 	'qte' =>$_POST["qte"],
			 	'datep' =>$_POST["date_p"],
			 	'id_statut' =>$_POST["statid"],
			 	'statut' =>$_POST["stat"],
			 );

		$commandedb->ajouterArticle($data);

		$contenu=$_SESSION['stock'];

		echo json_encode($contenu);

    break;



  	/**
  	 * ************************************************************
  	 * 
  	 * Opperation sur le panier
  	 * 
  	 * ************************************************************
  	 */
    case 'vider_panier':

		if(isset($_SESSION['stock'])){

			$vider_panier = $commandedb->viderPanier();

			echo json_encode($vider_panier);

		}else{
			echo json_encode('vide');
		}

    break;


    case 'sup_ligne':

		$reponse = $commandedb->supprimerArticle2($_POST['id']);

		echo json_encode($reponse);

    break;


    case 'setDate':

		$reponse = $commandedb->setDate($_POST['id'], $_POST['date']);

		echo json_encode($reponse);

    break;


    case 'setQte':

		$reponse = $commandedb->setQte($_POST['id'], $_POST['qte']);

		echo json_encode($reponse);

    break;

    case 'info':

		$montant = $commandedb->montantPanier();
		$nombre = $commandedb->compterArticles();

		header('Access-Control-Allow-Origin: *');
		header('Content-Type: application/json');

		$reponse = [$montant,$nombre];

		echo json_encode($reponse);

    break;
  	/**
  	 * ************************************************************
  	 * 
  	 * 			Valider la commande
  	 * 
  	 * ************************************************************
  	 */
    case 'valider_com':

		if ($action == "valider_com"){

			echo "validation ok";

			if(isset($_SESSION['stock'])){ 

				$contenu=$_SESSION['stock'];

				for($i=0;$i<count($contenu['id']);$i++){

		                $id_p=$contenu['id_p'][$i];
		                $produit=$contenu['produit'][$i];
		                $pu=$contenu['pu'][$i];
		                $qte=$contenu['qte'][$i];
		                $id_client=$contenu['id_client'][$i];

		                $ok = $commandedb->create($code_com, $id_client, $id_p, $qte, $date);

		                $commandedb->viderPanier();

				}

			}
				echo json_encode($ok);		

		}

    break;





    default:
      header("location:../index.php");
    break;
}} else {
	header("location:../index.php");
}
?>
