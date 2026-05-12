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
  	 * controller qui liste les commandes
  	 * 
  	 * ************************************************************
  	 */
    case 'readAll':

		$ok = $ventedb->getCommande($_POST['code']);

		header('Access-Control-Allow-Origin: *');
		header('Content-Type: application/json');

		echo json_encode($ok);

    break;

    /**
  	 * ************************************************************
  	 * 
  	 * controller qui supprime une facture
  	 * 
  	 * ************************************************************
  	 */
	    case 'drop':

				$droit = $users->verification_droit($_SESSION['Pharmacie']->id, 'stock_editer');
				if ($droit != false) {

						 $ok = $facturesdb->getFactureDrop($_POST['code']);

						foreach ($ok as $key) {

							$facturesdb->DropFacture2($key->qte, $key->id);

						}

						$ok = $facturesdb->DropFacture1($_SESSION['Pharmacie']->id, $date_actuele, $_POST['code']);

						echo json_encode(1);

				} else {
					echo "Vous n'avez pas le droit d'effectuer cette opperation !!!";
				}

	    break;

  	/**
  	 * ************************************************************
  	 * 
  	 * 											VALIDER LA COMMANDE
  	 * 
  	 * ************************************************************
  	 */
	    case 'Sell':

			$droit = $users->verification_droit($_SESSION['Pharmacie']->id, 'stock_add');
			if ($droit != false) {

				$code = addslashes(htmlspecialchars($_REQUEST['code']));
				$recu = addslashes(htmlspecialchars($_REQUEST['recu']));
				$total = addslashes(htmlspecialchars($_REQUEST['total']));
				// info ordo //	
				$code_o = addslashes(htmlspecialchars($_REQUEST['code_o']));
				$nom_o = addslashes(htmlspecialchars($_REQUEST['nom_o']));
				$hopital_o = addslashes(htmlspecialchars($_REQUEST['hopital_o']));

					if ($code_o === '' && $nom_o === '' && $hopital_o === '') {
						$ordo = 0;
					} else {
						$ordo = $code_o.',,'.$hopital_o.',,'.$nom_o;
					}

				// info client //
				$id_cli = addslashes(htmlspecialchars($_REQUEST['id_cli']));
				$tel = addslashes(htmlspecialchars($_REQUEST['tel']));
				$sexe = addslashes(htmlspecialchars($_REQUEST['sexe']));
				$nom = addslashes(htmlspecialchars( strtoupper($_REQUEST['nom']) ));
				$prenom = addslashes(htmlspecialchars( strtoupper($_REQUEST['prenom']) ));
				$adresse = addslashes(htmlspecialchars( strtoupper($_REQUEST['adresse']) ));

				$vendeur = $_SESSION['Pharmacie']->id;

					if ( $total <= $recu) {
						if ($_SESSION['vente']['type'][0] == "true") {
							/**
							 * ***********************************************************
							 * 
							 * *************cas ou c'est un nouveau client****************
							 * 
							 * ***********************************************************
							 */
							if ($id_cli === 'new') {
								$id_clis = $clientdb->addClient2($nom, $prenom, $sexe, $adresse, $tel, $date_actuele);

								$contenu=$_SESSION['vente'];

								for($i=0;$i<count($contenu['id']);$i++){

									$dife_id = explode('_', $contenu['id'][$i]);

									$produit=$dife_id[2];
									$fournisseur=$contenu['fournisseur'][$i];
									$prix=$contenu['prix'][$i];
									$demande=$contenu['qte'][$i];

									$dif_id = explode('_', $contenu['id'][$i]);

									$ok = $stockdb->getStockFour($dif_id[1], $dif_id[0]);

									foreach ($ok as $key) {

											if ($key->qte >= $demande )
											{

												$stockdb->setStock($demande, $key->id);

												$ventedb->create($code, $fournisseur, $produit, $vendeur, $id_clis, $demande, $recu, $total, $ordo, $key->type_l,1, $date_actuele);
												break;

											}else{

												$dispo_cal = $demande - $key->qte;
												$dispo = $demande - $dispo_cal;

												$stockdb->setStock($dispo, $key->id);

												$ventedb->create($code, $fournisseur, $produit, $vendeur, $id_clis, $dispo, $recu, $total, $ordo, $key->type_l,1, $date_actuele);

												$demande = $demande - $dispo;

											}
									}
								}
								$ventedb->viderPanier();
								echo json_encode(1);

							/**
							 * **********************************************************************
							 * 
							 ********************* cas ou c'est un ancien client*********************
							* 
							* ***********************************************************************
							*/
							} else {

								$contenu=$_SESSION['vente'];

								for($i=0;$i<count($contenu['id']);$i++){

									$dife_id = explode('_', $contenu['id'][$i]);

									$produit=$dife_id[2];
									$fournisseur=$contenu['fournisseur'][$i];
									$prix=$contenu['prix'][$i];
									$demande=$contenu['qte'][$i];

									$dif_id = explode('_', $contenu['id'][$i]);

									$ok = $stockdb->getStockFour($dif_id[1], $dif_id[0]);

									foreach ($ok as $key) {
										if ($key->qte >= $demande ){
											$stockdb->setStock($demande, $key->id);

											$ventedb->create($code, $fournisseur, $produit, $vendeur, $id_cli, $demande, $recu, $total, $ordo, $key->type_l,1, $date_actuele);

											break;

										}else{

											$dispo_cal = $demande - $key->qte;
											$dispo = $demande - $dispo_cal;

											$stockdb->setStock($dispo, $key->id);

											$ventedb->create($code, $fournisseur, $produit, $vendeur, $id_cli, $dispo, $recu, $total, $ordo, $key->type_l,1, $date_actuele);

											$demande = $demande - $dispo;

										}
									}

								}
								$ventedb->viderPanier();
								echo json_encode(1);

							}
						} else {
							/**
							 * ***********************************************************
							 * 
							 * *************cas ou c'est un nouveau client****************
							 * 
							 * ***********************************************************
							 */
							if ($id_cli === 'new') {
								$id_clis = $clientdb->addClient2($nom, $prenom, $sexe, $adresse, $tel, $date_actuele);

								$contenu=$_SESSION['vente'];

								for($i=0;$i<count($contenu['id']);$i++){

									$dife_id = explode('_', $contenu['id'][$i]);

									$produit=$dife_id[2];
									$fournisseur=$contenu['fournisseur'][$i];
									$prix=$contenu['prix'][$i];
									$demande=$contenu['qte'][$i];

									$dif_id = explode('_', $contenu['id'][$i]);

									$ok = $stockdb->getStockFournl($dif_id[1], $dif_id[0]);

									foreach ($ok as $key) {

										$ventedb->create($code, $fournisseur, $produit, $vendeur, $id_clis, $demande, $recu, $total, $ordo, $key->type_l,0, $date_actuele);
										break;

									}
								}
								$ventedb->viderPanier();
								echo json_encode(1);

							/**
							 * **********************************************************************
							 * 
							 ********************* cas ou c'est un ancien client*********************
							* 
							* ***********************************************************************
							*/
							} else {

								$contenu=$_SESSION['vente'];

								for($i=0;$i<count($contenu['id']);$i++){

									$dife_id = explode('_', $contenu['id'][$i]);

									$produit=$dife_id[2];
									$fournisseur=$contenu['fournisseur'][$i];
									$prix=$contenu['prix'][$i];
									$demande=$contenu['qte'][$i];

									$dif_id = explode('_', $contenu['id'][$i]);

									$ok = $stockdb->getStockFournl($dif_id[1], $dif_id[0]);

									foreach ($ok as $key) {
										// $stockdb->setStock($demande, $key->id);

										$ventedb->create($code, $fournisseur, $produit, $vendeur, $id_cli, $demande, $recu, $total, $ordo, $key->type_l,0, $date_actuele);

										break;
									}

								}
								$ventedb->viderPanier();
								echo json_encode(1);	

							}
						}
					} else {
						echo "Verifier le montant recu !!!";
					}
			} else {
				echo "Vous n'avez pas le droit d'effectuer cette opperation !!!";
			}

	    break;


  	/**
  	 * ************************************************************
  	 * 
  	 * 											VALIDER LA COMMANDE
  	 * 
  	 * ************************************************************
  	 */
	  case 'Sella':

		$droit = $users->verification_droit($_SESSION['Pharmacie']->id, 'stock_add');
		if ($droit != false) {

			$recu_date = addslashes(htmlspecialchars($_REQUEST['recu_date']));
			$recu_heure = addslashes(htmlspecialchars($_REQUEST['recu_heure']));
			$recu_datetime = date('Y-m-d H:i:s', strtotime($recu_date . ' ' . $recu_heure));
			$code = addslashes(htmlspecialchars($_REQUEST['code']));
			$recu = addslashes(htmlspecialchars($_REQUEST['recu']));
			$total = addslashes(htmlspecialchars($_REQUEST['total']));
			// info ordo //	
			$code_o = addslashes(htmlspecialchars($_REQUEST['code_o']));
			$nom_o = addslashes(htmlspecialchars($_REQUEST['nom_o']));
			$hopital_o = addslashes(htmlspecialchars($_REQUEST['hopital_o']));

				if ($code_o === '' && $nom_o === '' && $hopital_o === '') {
					$ordo = 0;
				} else {
					$ordo = $code_o.',,'.$hopital_o.',,'.$nom_o;
				}

			// info client //
			$id_cli = addslashes(htmlspecialchars($_REQUEST['id_cli']));
			$tel = addslashes(htmlspecialchars($_REQUEST['tel']));
			$sexe = addslashes(htmlspecialchars($_REQUEST['sexe']));
			$nom = addslashes(htmlspecialchars( strtoupper($_REQUEST['nom']) ));
			$prenom = addslashes(htmlspecialchars( strtoupper($_REQUEST['prenom']) ));
			$adresse = addslashes(htmlspecialchars( strtoupper($_REQUEST['adresse']) ));

			$vendeur = $_SESSION['Pharmacie']->id;

				if ( $total <= $recu) {
					if ($_SESSION['ventea']['type'][0] == "true") {
						/**
						 * ***********************************************************
						 * 
						 * *************cas ou c'est un nouveau client****************
						 * 
						 * ***********************************************************
						 */
						if ($id_cli === 'new') {
							$id_clis = $clientdb->addClient2($nom, $prenom, $sexe, $adresse, $tel, $date_actuele);

							$contenu=$_SESSION['ventea'];

							for($i=0;$i<count($contenu['id']);$i++){

								$dife_id = explode('_', $contenu['id'][$i]);

								$produit=$dife_id[2];
								$fournisseur=$contenu['fournisseur'][$i];
								$prix=$contenu['prix'][$i];
								$demande=$contenu['qte'][$i];

								$dif_id = explode('_', $contenu['id'][$i]);

								$ok = $stockdb->getStockFour($dif_id[1], $dif_id[0]);

								foreach ($ok as $key) {

									$ventedb->create($code, $fournisseur, $produit, $vendeur, $id_clis, $demande, $recu, $total, $ordo, $key->type_l,1, $recu_datetime);
											
								}
							}
							$ventedb->viderPaniera();
							echo json_encode(1);

						/**
						 * **********************************************************************
						 * 
						 ********************* cas ou c'est un ancien client*********************
						* 
						* ***********************************************************************
						*/
						} else {

							$contenu=$_SESSION['ventea'];

							for($i=0;$i<count($contenu['id']);$i++){

								$dife_id = explode('_', $contenu['id'][$i]);

								$produit=$dife_id[2];
								$fournisseur=$contenu['fournisseur'][$i];
								$prix=$contenu['prix'][$i];
								$demande=$contenu['qte'][$i];

								$dif_id = explode('_', $contenu['id'][$i]);

								$ok = $stockdb->getStockFour($dif_id[1], $dif_id[0]);

								foreach ($ok as $key) {

										$ventedb->create($code, $fournisseur, $produit, $vendeur, $id_cli, $demande, $recu, $total, $ordo, $key->type_l,1, $recu_datetime);

								}

							}
							$ventedb->viderPanier();
							echo json_encode(1);

						}
					} else {
						/**
						 * ***********************************************************
						 * 
						 * *************cas ou c'est un nouveau client****************
						 * 
						 * ***********************************************************
						 */
						if ($id_cli === 'new') {
							$id_clis = $clientdb->addClient2($nom, $prenom, $sexe, $adresse, $tel, $date_actuele);

							$contenu=$_SESSION['ventea'];

							for($i=0;$i<count($contenu['id']);$i++){

								$dife_id = explode('_', $contenu['id'][$i]);

								$produit=$dife_id[2];
								$fournisseur=$contenu['fournisseur'][$i];
								$prix=$contenu['prix'][$i];
								$demande=$contenu['qte'][$i];

								$dif_id = explode('_', $contenu['id'][$i]);

								$ok = $stockdb->getStockFournl($dif_id[1], $dif_id[0]);

								foreach ($ok as $key) {

									$ventedb->create($code, $fournisseur, $produit, $vendeur, $id_clis, $demande, $recu, $total, $ordo, $key->type_l,0, $recu_datetime);
									break;

								}
							}
							$ventedb->viderPanier();
							echo json_encode(1);

						/**
						 * **********************************************************************
						 * 
						 ********************* cas ou c'est un ancien client*********************
						* 
						* ***********************************************************************
						*/
						} else {

							$contenu=$_SESSION['ventea'];

							for($i=0;$i<count($contenu['id']);$i++){

								$dife_id = explode('_', $contenu['id'][$i]);

								$produit=$dife_id[2];
								$fournisseur=$contenu['fournisseur'][$i];
								$prix=$contenu['prix'][$i];
								$demande=$contenu['qte'][$i];

								$dif_id = explode('_', $contenu['id'][$i]);

								$ok = $stockdb->getStockFournl($dif_id[1], $dif_id[0]);

								foreach ($ok as $key) {
									// $stockdb->setStock($demande, $key->id);

									$ventedb->create($code, $fournisseur, $produit, $vendeur, $id_cli, $demande, $recu, $total, $ordo, $key->type_l,0, $recu_datetime);

									break;
								}

							}
							$ventedb->viderPanier();
							echo json_encode(1);	

						}
					}
				} else {
					echo "Verifier le montant recu !!!";
				}
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

			$data = [
				'id' =>$_POST["id"],
				'nom' =>$_POST["nom"],
				'prix' =>$_POST["prix"],
				'qte' =>$_POST["qte"],
				'fournisseur' =>$_POST["fournisseur"],
				'type' =>$_POST["type"],
			];

			$ventedb->ajouterArticle($data);

			$contenu=$_SESSION['vente'];

			echo json_encode($contenu);

	    break;

		  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui ajoute un produit dans le panier de commande 
  	 * 
  	 * ************************************************************
  	 */
	  case 'paniera':

		$data = [
			'id' =>$_POST["id"],
			'nom' =>$_POST["nom"],
			'prix' =>$_POST["prix"],
			'qte' =>$_POST["qte"],
			'fournisseur' =>$_POST["fournisseur"],
			'type' =>$_POST["type"],
		];

		$ventedb->ajouterArticlea($data);

		$contenu=$_SESSION['ventea'];

		// header('Access-Control-Allow-Origin: *');
		// header('Content-Type: application/json');

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

			if(isset($_SESSION['vente'])){

				$vider_panier = $ventedb->viderPanier();

				echo json_encode($vider_panier);

			}else{
				echo json_encode('vide');
			}

	    break;


	    case 'sup_ligne':

			$reponse = $ventedb->supprimerArticle2($_POST['id']);

			echo json_encode($reponse);

	    break;


	    case 'setQte':

			$reponse = $ventedb->setQte($_POST['id'], $_POST['qte']);

			echo json_encode($reponse);

	    break;


	    case 'info':

			$montant = $ventedb->montantPanier();
			$nombre = $ventedb->compterArticles();
			$type = $ventedb->typeArticles();

			header('Access-Control-Allow-Origin: *');
			header('Content-Type: application/json');

			$reponse = [$montant,$nombre,$type];

			echo json_encode($reponse);

	    break;

		case 'infoa':

			$montant = $ventedb->montantPaniera();
			$nombre = $ventedb->compterArticlesa();
			$type = $ventedb->typeArticlesa();

			header('Access-Control-Allow-Origin: *');
			header('Content-Type: application/json');

			$reponse = [$montant,$nombre,$type];

			echo json_encode($reponse);

	    break;

		case 'vider_paniera':

			if(isset($_SESSION['vente'])){

				$vider_panier = $ventedb->viderPaniera();

				echo json_encode($vider_panier);

			}else{
				echo json_encode('vide');
			}

	    break;


	    case 'sup_lignea':

			$reponse = $ventedb->supprimerArticle2a($_POST['id']);

			echo json_encode($reponse);

	    break;


	    case 'setQtea':

			$reponse = $ventedb->setQtea($_POST['id'], $_POST['qte']);

			echo json_encode($reponse);

	    break;

    default:
      header("location:../index.php");
    break;
}} else {
	header("location:../index.php");
}
?>
