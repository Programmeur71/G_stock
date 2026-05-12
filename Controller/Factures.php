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
  	 * controller qui supprime une facture
  	 * 
  	 * ************************************************************
  	 */
	    case 'drop':

				$droit = $users->verification_droit($_SESSION['Pharmacie']->id, 'fimance_editer');
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
  	 * controller qui modifier le client d'une facture
  	 * 
  	 * ************************************************************
  	 */
	    case 'edite_facture':

				 		// info client //
				 		$code = addslashes(htmlspecialchars($_REQUEST['code']));
				 		$id_cli = addslashes(htmlspecialchars($_REQUEST['id_cli']));
						$tel = addslashes(htmlspecialchars($_REQUEST['tel']));
						$sexe = addslashes(htmlspecialchars($_REQUEST['sexe']));
						$nom = addslashes(htmlspecialchars( strtoupper($_REQUEST['nom']) ));
						$prenom = addslashes(htmlspecialchars( strtoupper($_REQUEST['prenom']) ));
						$adresse = addslashes(htmlspecialchars( strtoupper($_REQUEST['adresse']) ));

						$droit1 = $users->verification_droit($_SESSION['Pharmacie']->id, 'fimance_editer');
						$droit2 = $users->verification_droit($_SESSION['Pharmacie']->id, 'fimance_add');
						if ($droit1 != false && $droit2 != false) {
								/*
								 * ***********************************************************
								 * 
								 * *************cas ou c'est un nouveau client****************
								 * 
								 * ***********************************************************
								 */
								if ($id_cli === 'new') {

										$id_clis = $clientdb->addClient2($nom, $prenom, $sexe, $adresse, $tel, $date_actuele);

										$ok = $facturesdb->setClientFacture($id_clis, $code);

										echo json_encode(1);

								} else {		
								/*
								 * ***********************************************************
								 * 
								 ***************cas ou c'est un ancien client*****************
								 * 
								 * ***********************************************************
								 */

									$ok = $facturesdb->setClientFacture($id_cli, $code);

									echo json_encode(1);

								}
						} else {
							echo "Vous n'avez pas le droit d'effectuer cette opperation !!!";
						}
	    break;

		case 'edite_facture2':

			// info client //
			$code = addslashes(htmlspecialchars($_REQUEST['code']));
			$id_cli = addslashes(htmlspecialchars($_REQUEST['id_cli']));
		   $tel = addslashes(htmlspecialchars($_REQUEST['tel']));
		   $sexe = addslashes(htmlspecialchars($_REQUEST['sexe']));
		   $nom = addslashes(htmlspecialchars( strtoupper($_REQUEST['nom']) ));
		   $prenom = addslashes(htmlspecialchars( strtoupper($_REQUEST['prenom']) ));
		   $adresse = addslashes(htmlspecialchars( strtoupper($_REQUEST['adresse']) ));

		   $droit1 = $users->verification_droit($_SESSION['Pharmacie']->id, 'stock_editer');
		   $droit2 = $users->verification_droit($_SESSION['Pharmacie']->id, 'stock_add');
		   if ($droit1 != false && $droit2 != false) {
				   /*
					* ***********************************************************
					* 
					* *************cas ou c'est un nouveau client****************
					* 
					* ***********************************************************
					*/
				   if ($id_cli === 'new') {

						   $id_clis = $clientdb->addClient2($nom, $prenom, $sexe, $adresse, $tel, $date_actuele);

						   $ok = $facturesdb->setClientFacture($id_clis, $code);

						   echo json_encode(1);

				   } else {		
				   /*
					* ***********************************************************
					* 
					***************cas ou c'est un ancien client*****************
					* 
					* ***********************************************************
					*/

					   $ok = $facturesdb->setClientFacture($id_cli, $code);

					   echo json_encode(1);

				   }
		   } else {
			   echo "Vous n'avez pas le droit d'effectuer cette opperation !!!";
		   }
			break;
  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui recupere les infos du client
  	 * 
  	 * ************************************************************
  	 */
	    case 'client':

				$ok = $facturesdb->getClientFacture($_POST['code']);

				header('Access-Control-Allow-Origin: *');
				header('Content-Type: application/json');

				echo json_encode($ok);

	    break;

  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui recupere les infos sur les ordonances
  	 * 
  	 * ************************************************************
  	 */
	    case 'ordo':

				$ok = $facturesdb->getOrdo($_POST['code']);

				$ok = explode(',,', $ok->ordonance);

				header('Access-Control-Allow-Origin: *');
				header('Content-Type: application/json');

				echo json_encode($ok);

	    break;

  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui filtre les ventes entre 2 code
  	 * 
  	 * ************************************************************
  	 */
	    case 'code':

			$code1 = $ventedb->getDate(addslashes(htmlspecialchars($_REQUEST['code1'])));
			$code2 = $ventedb->getDate(addslashes(htmlspecialchars($_REQUEST['code2'])));

			$a = $ventedb->setDate($_REQUEST['code1'],$code1->date_v);
			$b = $ventedb->setDate($_REQUEST['code2'],$code2->date_v);

			// var_dump($a);

		    header('Access-Control-Allow-Origin: *');
		    header('Content-Type: application/json');

			echo json_encode($facturesdb->filtre($code1->date_v, $code2->date_v));
			// echo json_encode($facturesdb->filtre2($_REQUEST['code1'], $_REQUEST['code2']));

	    break;

  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui filtre les ventes entre 2 date
  	 * 
  	 * ************************************************************
  	 */
	    case 'date':

				$date1 = addslashes(htmlspecialchars($_REQUEST['date1']));
				$date2 = addslashes(htmlspecialchars($_REQUEST['date2']));

		    header('Access-Control-Allow-Origin: *');
		    header('Content-Type: application/json');

				echo json_encode($facturesdb->filtre($date1.' 00:00', $date2.' 23:59'));

	    break;

  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui filtre les ventes entre 2 date
  	 * 
  	 * ************************************************************
  	 */
	    case 'm_date':

	   	  header('Access-Control-Allow-Origin: *');
		    header('Content-Type: application/json');

				$date = $ventedb->getDate();

				$date = explode(' ', $date->min_date);

				$date1 = $date[0];

				$date2 = $date[1];

				$date22 = explode(':', $date2);

				//$date = $date1.' '.$date22[0].':'.$date22[1];
				// $date = $date1.' 00:00';
				$date = $date1;

				echo json_encode($date);

	    break;

  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui filtre les ventes
  	 * 
  	 * ************************************************************
  	 */
				case 'filtrea':
		    header('Access-Control-Allow-Origin: *');
		    header('Content-Type: application/json');
		    
		    // Récupérer les paramètres DataTables
		    $_REQUEST = array_merge($_GET, $_POST);
		    
		    $result = $facturesdb->filtrea();
		    
		    if (!is_array($result)) {
		        $result = [
		            "draw" => isset($_REQUEST['draw']) ? intval($_REQUEST['draw']) : 0,
		            "recordsTotal" => 0,
		            "recordsFiltered" => 0,
		            "data" => []
		        ];
		    }
		    
		    echo json_encode($result, JSON_PRETTY_PRINT);
		    break;

			case 'filtre':
			    header('Access-Control-Allow-Origin: *');
			    header('Content-Type: application/json');
			    
			    // Appeler la méthode sans paramètres pour DataTables
			    $result = $facturesdb->filtre();
			    
			    // Vérifier si c'est bien un tableau
			    if (!is_array($result)) {
			        $result = [
			            "draw" => isset($_REQUEST['draw']) ? intval($_REQUEST['draw']) : 0,
			            "recordsTotal" => 0,
			            "recordsFiltered" => 0,
			            "data" => []
			        ];
			    }
			    
			    echo json_encode($result);
	    break;

  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui trouve les informations d'une facture
  	 * 
  	 * ************************************************************
  	 */


  		case 'readAlls':
		    header('Access-Control-Allow-Origin: *');
		    header('Content-Type: application/json; charset=utf-8');
		    
		    try {
		        // Activer l'affichage des erreurs temporairement
		        error_reporting(E_ALL);
		        ini_set('display_errors', 1);
		        
		        $result = $facturesdb->getFactures();
		        
		        // Debug: voir ce que retourne la méthode
		        error_log("Résultat de getFactures: " . print_r($result, true));
		        
		        if (!is_array($result)) {
		            $result = [
		                "draw" => isset($_REQUEST['draw']) ? intval($_REQUEST['draw']) : 0,
		                "recordsTotal" => 0,
		                "recordsFiltered" => 0,
		                "data" => []
		            ];
		        }
		        
		        echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
		        
		    } catch (Exception $e) {
		        error_log("Exception dans readAlls: " . $e->getMessage() . "\n" . $e->getTraceAsString());
		        
		        // Retourner une réponse DataTables valide même en cas d'erreur
		        echo json_encode([
		            "draw" => isset($_REQUEST['draw']) ? intval($_REQUEST['draw']) : 0,
		            "recordsTotal" => 0,
		            "recordsFiltered" => 0,
		            "data" => []
		        ]);
		    }
	    break;


  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui liste les factures
  	 * 
  	 * ************************************************************
  	 */
	    case 'readAll':

				$ok = $facturesdb->getFactures($_POST['code']);

				header('Access-Control-Allow-Origin: *');
				header('Content-Type: application/json');

				echo json_encode($ok);

	    break;

		case 'readAll_ancien':

				$ok = $facturesdb->getAncienFactures($_POST['code']);

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
