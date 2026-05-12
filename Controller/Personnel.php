<?php 	
require_once 'Controller.php';
	date_default_timezone_set('Africa/Douala');

	$date_a = date('Y-m-d H:i:s');


	 extract($_POST);

    function code()
  	{
	    $caractere = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	    $alt = date('Y-');
	    for ($i = 0; $i < strlen($caractere) - 58; $i++) {
	      (string)$alt .= $caractere[rand(0, strlen($caractere)-1)];
	    }
	    return $alt;
	}

/**
* *********************************************************
* 
* recuperation de l'action a executer
* 
* *********************************************************
*/		
if (isset($_REQUEST['action'])) {

	$action = $_REQUEST['action'];

  switch ($action) {


  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui verifie un utilisateur pour l'inserer
  	 * 
  	 * ************************************************************
  	 */
    case 'ajouter':

		$droit_personel = $users->verification_droit($_SESSION['Pharmacie']->id, 'personnel_add');
		if ($droit_personel != false) {

		    $categorie = addslashes(htmlspecialchars($_REQUEST['categorie']));
		    $nom = addslashes(htmlspecialchars($_REQUEST['nom']));
		    $prenom = addslashes(htmlspecialchars($_REQUEST['prenom']));
		    $telephone = addslashes(htmlspecialchars($_REQUEST['telephone']));
		    $mail = addslashes(htmlspecialchars($_REQUEST['mail']));
		    $date = addslashes(htmlspecialchars($_REQUEST['date']));
		    $Sexe = addslashes(htmlspecialchars($_REQUEST['Sexe']));
		    $domicile = addslashes(htmlspecialchars($_REQUEST['domicile']));

				$passe = addslashes(htmlspecialchars(md5($_REQUEST['passe'])));
				$passe2 = addslashes(htmlspecialchars(md5($_REQUEST['passe2'])));

				if ($passe === $passe2) {	

						try {

			 $params = [$categorie, code(), $nom, $prenom, $domicile, $date, $Sexe, $mail, $telephone, $date_a, $passe2];

							 $son_id = $users->addUser($params);

							 $drt = $gradedb->getGrade($categorie);

								if ($drt != false) {

									$paramsd = [$son_id, $drt->stock, $drt->stock_editer, $drt->stock_add, $drt->finance, $drt->fimance_editer, $drt->fimance_add, $drt->statistique, $drt->statistique_editer, $drt->statistique_add, $drt->personnel, $drt->personnel_editer, $drt->personnel_add];

									$users->addUserDroit($paramsd);

									echo json_encode(1);

								} else {

									echo "La grade '".$categorie."' n'existe pas dans la liste des grades";

								}
							
						} catch (Exception $e) {

							echo "<i style='color:#CF8282'>Soit le mail ou le contact existe deja !!!</i>";
							
						}

				} else {
					echo "Les Mots de passe ne sont pas identique";
				}
		} else {

			echo "Vous n'avez pas le droit d'effectuer cette opperation !!!";

		}
    break;

  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui verifie un droit specifique
  	 * 
  	 * ************************************************************
  	 */
    case 'autorisation':

			$data = $autorisationdb->get_autorisation(htmlspecialchars($_REQUEST['id_user']));

			header('Access-Control-Allow-Origin: *');
			header('Content-Type: application/json');

			echo json_encode($data);

    break;

  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui modifie les autorisation de l'utilisateur
  	 * 
  	 * ************************************************************
  	 */
	case 'gere_autorisation':

			$id = htmlspecialchars($_REQUEST['id_user']);

			$vente = htmlspecialchars($_REQUEST['vente']);
			$enregistrement = htmlspecialchars($_REQUEST['enregistrement']);
			$commande = htmlspecialchars($_REQUEST['commande']);
			$st_accuil = htmlspecialchars($_REQUEST['st_accuil']);
			$f_vente = htmlspecialchars($_REQUEST['f_vente']);
			$f_stock = htmlspecialchars($_REQUEST['f_stock']);
			$p_enregistrement = htmlspecialchars($_REQUEST['p_enregistrement']);
			$p_admin = htmlspecialchars($_REQUEST['p_admin']);
			$p_info = htmlspecialchars($_REQUEST['p_info']);

			//########## verifions si l'utilisateur a le droit de modifier NB droit supprimer = modifier ##########


			$droit_personel = $users->verification_droit($_SESSION['Pharmacie']->id, 'personnel_editer');

				if ($droit_personel != false) {

					$statutuser = $users->getUsers($id);

					if ((bool)$statutuser !== false) {
						$autorisationdb->set_autorisation($id,$vente,$enregistrement,$commande,$st_accuil,$f_vente,$f_stock,$p_enregistrement,$p_admin,$p_info);
						echo json_encode(1);	
					} else {

					echo "Impossible de donner des autorisations a une personne bloquer !!!";

					}
					
				} else {

					echo "Vous n'avez pas le droit d'effectuer cette opperation !!!";

				}	

	break;

	/**
	 * ****************************************************************
	 * 
	 * controller qui permet de changer les droits d'un utilisateur
	 * 
	 * ****************************************************************
	 */
	case 'gerer':

		$id = addslashes(htmlspecialchars($_REQUEST['id_user']));
		$grade = addslashes(htmlspecialchars($_REQUEST['grade']));
		$statut = addslashes(htmlspecialchars($_REQUEST['statut']));

		//########## verifions si l'utilisateur a le droit de modifier NB droit supprimer = modifier ##########

		$droit_personel = $users->verification_droit($_SESSION['Pharmacie']->id, 'personnel_editer');
			if ($droit_personel != false) {

		//########## verifions si la grade existe ##########

				$vrf_grade = $gradedb->getGrade($grade);
					if ($vrf_grade != false) {

		//########## verifions si la grade a changer ##########

						if(htmlspecialchars($_REQUEST['change']) != 'oui'){

								$gerer_1 = $users->gerer_user($id, $statut);

								echo json_encode(1);
						}else{
					
							$gerer_1 = $users->gerer_user($id, $statut, $vrf_grade->id);	

							$gerer_2 = $users->change_grade($id, 
								$vrf_grade->stock,
								$vrf_grade->stock_editer,
								$vrf_grade->stock_add,
								$vrf_grade->finance,
								$vrf_grade->fimance_editer,
								$vrf_grade->fimance_add,
								$vrf_grade->statistique,
								$vrf_grade->statistique_editer,
								$vrf_grade->statistique_add,
								$vrf_grade->personnel,
								$vrf_grade->personnel_editer,
								$vrf_grade->personnel_add
							);

								echo json_encode(1);
						}


					} else {

						echo "La grade '".$grade."' n'existe pas dans la liste des grades";

					}

			} else {

				echo "Vous n'avez pas le droit d'effectuer cette opperation !!!";

			}

	break;

  	/**
  	 * ****************************************************************
  	 * 
  	 * controller qui permet de changer les droits d'un utilisateur
  	 * 
  	 * ****************************************************************
  	 */
	case 'gere_droit':

			$id = addslashes(htmlspecialchars($_REQUEST['id_user']));


			$Stock = addslashes(htmlspecialchars($_REQUEST['Stock']));
			$editer_s = addslashes(htmlspecialchars($_REQUEST['editer_s']));
			$ajouter_s = addslashes(htmlspecialchars($_REQUEST['ajouter_s']));

			$Finance = addslashes(htmlspecialchars($_REQUEST['Finance']));
			$editer_f = addslashes(htmlspecialchars($_REQUEST['editer_f']));
			$ajouter_f = addslashes(htmlspecialchars($_REQUEST['ajouter_f']));

			$Statistique = addslashes(htmlspecialchars($_REQUEST['Statistique']));
			$editer_st = addslashes(htmlspecialchars($_REQUEST['editer_st']));
			$ajouter_st = addslashes(htmlspecialchars($_REQUEST['ajouter_st']));

			$Personnel = addslashes(htmlspecialchars($_REQUEST['Personnel']));
			$ajouter_p = addslashes(htmlspecialchars($_REQUEST['ajouter_p']));
			$editer_p = addslashes(htmlspecialchars($_REQUEST['editer_p']));

			//########## verifions si l'utilisateur a le droit de modifier NB droit supprimer = modifier ##########

			$droit_personel = $users->verification_droit($_SESSION['Pharmacie']->id, 'personnel_editer');

				if ($droit_personel !== false) {

					$statutuser = $users->getUsers($id);

						if ((bool)$statutuser !== false) {

						$users->change_grade($id, $Stock, $editer_s, $ajouter_s, $Finance, $editer_f, $ajouter_f, $Statistique, $editer_st, $ajouter_st, $Personnel, $ajouter_p, $editer_p);
							echo json_encode(1);

						} else {

						echo "Impossible de donner des drois a une personne bloquer !!!";

						}	
					
				} else {

					echo "Vous n'avez pas le droit d'effectuer cette opperation !!!";

				}	

	break;

  	/**
  	 * *********************************************************
  	 * 
  	 * controller qui donne la liste des droit d'un utilisateur
  	 * 
  	 * *********************************************************
  	 */
	case 'l_droit':
			$data = $users->get_droit(htmlspecialchars($_REQUEST['id_user']));

			header('Access-Control-Allow-Origin: *');
				header('Content-Type: application/json');

			echo json_encode($data);

	break;

  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui verifie un droit specifique
  	 * 
  	 * ************************************************************
  	 */
    case 'verifier':

		$id = addslashes(htmlspecialchars($_REQUEST['id_p']));
		$droit = addslashes(htmlspecialchars($_REQUEST['modules']));

	    $response = $users->verification_droit($id, $droit);

		    if($response !== false){
		    	echo 1;
		    }else{
		    	echo 0;
		    }

    break;

    /**
     * ***********************************************************
     * 
     * controller de connexion au system
     * 
     * ***********************************************************
     */
	case 'connecter':

		$user = addslashes(htmlspecialchars($_REQUEST['user']));
			$pass = addslashes(htmlspecialchars(md5($_REQUEST['passe'])));

		$response = $users->connecte($user, $pass);

			if ($response === 22) {

				header("location:../index.php?message=compte bloquer");

			}elseif ($response === 33) {

				header("location:../index.php?message=mail ou telephone invalide");

			}elseif ($response === 11) {

				header("location:../index.php?message=mot de passe incorrect");

			}else{
				if (session_status() === PHP_SESSION_NONE) {
					session_start();
				}

				if (!isset($_SESSION['Pharmacie'])){
					$_SESSION['Pharmacie'] = [];
				}
				$_SESSION['Pharmacie'] = $response;
				header("location:../Pharmacie");
			}

	break;

    /**
     * ***********************************************************
     * 
     * controller de connexion au system licence
     * 
     * ***********************************************************
     */
	case 'delete1':

		$login = addslashes(htmlspecialchars($_REQUEST['login']));

		$response = $users->cons($login);

		echo $response;

	break;

	case 'delete2':

		$login = addslashes(htmlspecialchars($_REQUEST['login']));
		$login2 = addslashes(htmlspecialchars(hash('sha256', $_REQUEST['login2'])));

		$response = $users->cons2($login,$login2);

		if ($response == 33) {
			echo $response;
		} else {
			$_SESSION['Pharmacie'] = $response;
			echo $response;
		}

	break;

	case 'rase':

		$users->rase();echo 1;

	break;

  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui verifie un droit specifique
  	 * 
  	 * ************************************************************
  	 */
	  case 'profileMod_passe':

		$p1 = addslashes(htmlspecialchars(md5($_REQUEST['p1'])));
		$p2 = addslashes(htmlspecialchars(md5($_REQUEST['p2'])));
		$droit = addslashes(htmlspecialchars(md5($_REQUEST['currentPassword'])));

		if ($p1 === $p2) {
			$response = $users->updatePasse($_SESSION['Pharmacie']->id, $p2);

		    if($response !== false){
		    	echo 1;
		    }else{
		    	echo 0;
		    }
		} else {
			echo 0;
		}
		
    break;

	case 'profileModInfo':

		$nom = addslashes(htmlspecialchars($_REQUEST['nom']));
		$prenom = addslashes(htmlspecialchars($_REQUEST['prenom']));
		$Phone = addslashes(htmlspecialchars($_REQUEST['Phone']));
		$email = addslashes(htmlspecialchars($_REQUEST['Email']));
		$domicile = addslashes(htmlspecialchars($_REQUEST['domicile']));

			// $response = $users->updatePasse($_SESSION['Pharmacie']->id, $p2);
			$response = $users->updateUser($_SESSION['Pharmacie']->id, $nom, $prenom, $email, $Phone, $domicile);

		    if($response !== false){
		    	echo 1;
		    }else{
		    	echo 0;
		    }
		
    break;

    default:
      header("location:../index.php");
    break;
}} else {
	header("location:../index.php");
}
?>