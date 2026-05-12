<?php 
require_once 'Controller.php';
	date_default_timezone_set('Africa/Douala');

	$date_a = date('Y-m-d H:i:s');


if (isset($_REQUEST['action'])) {

	$action = $_REQUEST['action'];

  switch ($action) {


    case 'readAlls':

		$offset = addslashes(htmlspecialchars($_REQUEST['offset']));
		$limit = addslashes(htmlspecialchars($_REQUEST['limit']));

		$ok = $medicamentdb->readAll($offset, $limit);

		//header('Access-Control-Allow-Origin: *');
		header('Content-Type: application/json');

		echo json_encode($ok);

    break;

  	/**
  	 * ************************
  	 * 
  	 * Modifier un Produit
  	 * 
  	 * ************************
  	 */
    case 'modifier':

			$droit = $users->verification_droit($_SESSION['Pharmacie']->id, 'stock_editer');

				if ($droit != false) {

					$id = addslashes(htmlspecialchars($_REQUEST['id']));
					$nom = addslashes(htmlspecialchars( strtoupper($_REQUEST['nom']) ));
					$code = addslashes(htmlspecialchars( strtoupper($_REQUEST['code']) ));
					$dosage = addslashes(htmlspecialchars($_REQUEST['dosage']));
					//$forme = addslashes(htmlspecialchars($_REQUEST['forme']));
					$pa = addslashes(htmlspecialchars($_REQUEST['pa']));
					$pv = addslashes(htmlspecialchars($_REQUEST['pv']));
					$qtem = addslashes(htmlspecialchars($_REQUEST['qtem']));

						try {

							$ok = $medicamentdb->setProduit($code, $nom, $dosage, $pa, $pv, $qtem, $id);

							echo json_encode(1);
							
						} catch (Exception $e) {

							echo "Le code ou le nom de ce medicament existe deja";
							
						}

				} else {

				echo "Vous n'avez pas le droit d'effectuer cette opperation !!!";

				}

    break;

  	/**
  	 * ************************
  	 * 
  	 * Supprimer un Produit
  	 * 
  	 * ************************
  	 */
    case 'delete':

		$droit = $users->verification_droit($_SESSION['Pharmacie']->id, 'stock_editer');

			if ($droit != false) {

				$id = addslashes(htmlspecialchars($_REQUEST['id']));

				$ok = $medicamentdb->delete($id);
				
				echo json_encode($ok);

			} else {

				echo "Vous n'avez pas le droit d'effectuer cette opperation !!!";

			}

    break;
  	/**
  	 * ************************
  	 * 
  	 * Ajouter un Produit
  	 * 
  	 * ************************
  	 */
    case 'ajouter':

			$droit = $users->verification_droit($_SESSION['Pharmacie']->id, 'stock_add');

				if ($droit != false) {

					$nom = addslashes(htmlspecialchars( strtoupper($_REQUEST['nom']) ));
					$code = addslashes(htmlspecialchars( strtoupper($_REQUEST['code']) ));
					$dosage = addslashes(htmlspecialchars($_REQUEST['dosage']));
					$forme = addslashes(htmlspecialchars($_REQUEST['forme']));
					$pa = addslashes(htmlspecialchars($_REQUEST['pa']));
					$pv = addslashes(htmlspecialchars($_REQUEST['pv']));
					$qtem = addslashes(htmlspecialchars($_REQUEST['qtem']));

						try {

							$ok = $medicamentdb->addProduit($code, $forme, $nom, $dosage, $pa, $pv, $qtem);

							echo json_encode(1);
							
						} catch (Exception $e) {

							echo $e;
							
						}

				} else {

				echo "Vous n'avez pas le droit d'effectuer cette opperation !!!";

				}

    break;


  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui liste les medicament
  	 * 
  	 * ************************************************************
  	 */
	case 'readAll':

		// Configuration de la base de données
		$dbConfig = [
			'host' => getenv('DB_HOST') ?: 'localhost',
			'user' => getenv('DB_USER') ?: 'root',
			'pass' => getenv('DB_PASS') ?: '',
			'db' => getenv('DB_NAME') ?: 'pharmacie'
		];
		
		$dbDetails = array( 
			'host' => $dbConfig['host'],
			'user' => $dbConfig['user'],
			'pass' => $dbConfig['pass'],
			'db'   => $dbConfig['db'],
		);  

		// DB table to use 
		$table = 'medicaments';

		// Table's primary key  
		$primaryKey = 'id';

		// Array of database columns which should be read and sent back to DataTables.
		$columns = array(
			array('db' => 'id',              'dt' => 0),
			array('db' => 'code_alph',      'dt' => 1),
			array('db' => 'nom',            'dt' => 2),
			array('db' => 'dosage',         'dt' => 3),
			array('db' => 'prix_achat',     'dt' => 4),
			array('db' => 'prix_vente',     'dt' => 5),
			array('db' => 'qte_min',        'dt' => 6),
			array('db' => '',               'dt' => 7),
		);

		// Include SQL query processing class 
		require 'serverside/medicaments.php';

		header('Content-Type: application/json');

		// Output data as json format 
		echo json_encode(
			SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
		);        

	break;


  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui trouve un medicament pour le commander
  	 * 
  	 * ************************************************************
  	 */
    case 'trouver':

		$result = $medicamentdb->trouver(htmlspecialchars($_POST["keyword"]));

		if(!empty($result)) {?>

<ul id="result-list">
    <?php
				foreach($result as $desc) {?>

    <li onClick="selectMedic(<?=$desc->id?>)"><?=$desc->nom?></li>

    <?php }?>
</ul>

<?php }else{ ?>

<ul id="result-list">
    <li style="background-color:#D8A3A3;">
        <?php echo " pas de resultat pour le mot <b style='color:black'>".$_POST["keyword"]."</b>" ?></li>
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

		$result = $medicamentdb->getInfo(htmlspecialchars($_POST["id_produit"]));

		header('Access-Control-Allow-Origin: *');
		header('Content-Type: application/json');

		echo json_encode($result);

    break;

  	/**
  	 * *******************************
  	 * 
  	 * Ajout et suppression des forme
  	 * 
  	 * *******************************
  	 */
    case 'forme_add':

			$droit = $users->verification_droit($_SESSION['Pharmacie']->id, 'stock_add');

				if ($droit != false) {

					$nom = addslashes(htmlspecialchars( strtoupper($_REQUEST['nom']) ));

							$ok = $formedb->addForme($nom);

							echo json_encode(1);	

				} else {

				echo "Vous n'avez pas le droit d'effectuer cette opperation !!!";

				}

	    break;

	    case 'delete_forme':

				$droit = $users->verification_droit($_SESSION['Pharmacie']->id, 'stock_editer');

					if ($droit != false) {

						$id = addslashes(htmlspecialchars($_REQUEST['id']));

								$ok = $formedb->delete($id);

								echo json_encode($ok);	

					} else {

					echo "Vous n'avez pas le droit d'effectuer cette opperation !!!";

					}

	    break;



//********************************************************
    default:
      header("location:../index.php");
    break;
}} else {
	header("location:../index.php");
}
?>