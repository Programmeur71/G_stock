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
  	 * controller qui modifie le stock depuis les finance
  	 * 
  	 * ************************************************************
  	 */
    case 'setStockf':

		$droitf = $users->verification_droit($_SESSION['Pharmacie']->id, 'fimance_editer');
		if ($droitf != false) {

		$id = addslashes(htmlspecialchars($_REQUEST['id']));
		$prix_v = addslashes(htmlspecialchars($_REQUEST['prix_v']));
		$qte = addslashes(htmlspecialchars($_REQUEST['qte']));
		$qte_min = addslashes(htmlspecialchars($_REQUEST['qte_min']));
		$date_p = addslashes(htmlspecialchars($_REQUEST['date_p']));

		$ok = $stockdb->setStock2($prix_v, $qte, $qte_min, $date_p, $id);


		if ($ok != false) {
			echo json_encode(1);
		} else {
			echo json_encode($date_p);
		}

		} else {
			echo "Vous n'avez pas le droit d'effectuer cette opperation !!!";
		}
    break;
  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui modifie le stock
  	 * 
  	 * ************************************************************
  	 */
    case 'setStock':

					$droits = $users->verification_droit($_SESSION['Pharmacie']->id, 'stock_editer');
					if ($droits != false) {

			    	$id = addslashes(htmlspecialchars($_REQUEST['id']));
			    	$prix_v = addslashes(htmlspecialchars($_REQUEST['prix_v']));
			    	$qte = addslashes(htmlspecialchars($_REQUEST['qte']));
			    	$qte_min = addslashes(htmlspecialchars($_REQUEST['qte_min']));
			    	$date_p = addslashes(htmlspecialchars($_REQUEST['date_p']));

			    	$ok = $stockdb->setStock2($prix_v, $qte, $qte_min, $date_p, $id);

			    	if ($ok != false) {
			    		echo json_encode(1);
			    	} else {
			    		echo json_encode($ok);
			    	}

					} else {
						echo "Vous n'avez pas le droit d'effectuer cette opperation !!!";
					}    	
    break;

  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui liste tout les produit du stock
  	 * 
  	 * ************************************************************
  	 */
    case 'readAlls':

		    header('Access-Control-Allow-Origin: *');
		    header('Content-Type: application/json');

				echo json_encode($stockdb->getStock());

    break;

  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui liste les produit perime
  	 * 
  	 * ************************************************************
  	 */
    case 'StockPerime':

		    header('Access-Control-Allow-Origin: *');
		    header('Content-Type: application/json');

				echo json_encode($stockdb->getStockPerimer());
    break;

  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui liste les produit en rupture
  	 * 
  	 * ************************************************************
  	 */
    case 'ruptureStock':

		    header('Access-Control-Allow-Origin: *');
		    header('Content-Type: application/json');

				echo json_encode($stockdb->getStockRupture());

    break;

  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui trouve les informations d'un medicament 
  	 * 
  	 * ************************************************************
  	 */
    case 'info':

    $mot = explode('_', $_POST["id_produit"]);

		$result = $stockdb->getInfo($mot[0], $mot[1]);

		header('Access-Control-Allow-Origin: *');
		header('Content-Type: application/json');

		echo json_encode($result);

    break;

  	/**
  	 * ************************************************************
  	 * 
  	 * controller qui trouve un medicament pour le commander
  	 * 
  	 * ************************************************************
  	 */
    case 'trouver':

		$result = $stockdb->trouver(htmlspecialchars($_POST["keyword"]));
		$resultnl = $stockdb->trouverNl(htmlspecialchars($_POST["keyword"]));

		if(!empty($result) || !empty($resultnl)) {?>

<?php if (htmlspecialchars($_POST["type"]) == 1) {?>
<ul id="result-list">
    <?php
		foreach($result as $desc) {
			$separateur = '_';
				if ( strtotime($desc->date_p) < time()) {
					$date_p="| <b style='color:red'>Perime</b> |";
				} else {
					$date_p="";
				}?>

    <li onClick="selectMedic('<?=$desc->idm.$separateur.$desc->idfr.$separateur.$desc->id?>')">
        <b><?=$desc->produit?></b> &nbsp<i><br>[ <b><?=$desc->nombre?></b> <?=$date_p?> <span
                style="color:#9D0AA2"><?=$desc->fournisseur?></span> ]</i>
    </li>

    <?php }?>
</ul>

<?php  } else {?>
<ul id="result-list">
    <li style="background-color:#D8A3A3;">Produit pas dispo en stock</li>
    <?php
		foreach($resultnl as $desc) {
			$separateur = '_';
				if ( strtotime($desc->date_p) < time()) {
					$date_p="| <b style='color:red'>Perime</b> |";
				} else {
					$date_p="";
				}?>

    <li onClick="selectMedic('<?=$desc->idm.$separateur.$desc->idfr.$separateur.$desc->id?>')">
        <b><?=$desc->produit?></b> &nbsp<i><br>[ <b><?=$desc->nombre?></b> <?=$date_p?> <span
                style="color:#9D0AA2"><?=$desc->fournisseur?></span> ]</i>
    </li>

    <?php }?>
</ul>

<?php } ?>



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
  	 * controller qui trouve un medicament pour le commander
  	 * 
  	 * ************************************************************
  	 */
	  case 'trouvera':
		$resultnl = $stockdb->trouverNlA(htmlspecialchars($_POST["keyword"]));

		if(!empty($resultnl)) {?>


<ul id="result-list">
    <li style="background-color:#D8A3A3;">Anciennes ventes</li>
    <?php
					foreach($resultnl as $desc) {
						$separateur = '_';
							if ( strtotime($desc->date_p) < time()) {
								$date_p="| <b style='color:red'>Perime</b> |";
							} else {
								$date_p="";
							}?>

    <li onClick="selectMedic('<?=$desc->idm.$separateur.$desc->idfr.$separateur.$desc->id?>')">
        <b><?=$desc->produit?></b> &nbsp<i><br>[ <b><?=$desc->nombre?></b> <?=$date_p?> <span
                style="color:#9D0AA2"><?=$desc->fournisseur?></span> ] </i>
    </li>

    <?php }?>
</ul>



<?php }else{ ?>

<ul id="result-list">
    <li style="background-color:#D8A3A3;">
        <?php echo " pas de resultat pour le mot <b style='color:black'>".$_POST["keyword"]."</b>" ?></li>
</ul>

<?php }

				break;


//********************************************************
    default:
      header("location:../index.php");
    break;
}} else {
	header("location:../index.php");
}
?>
