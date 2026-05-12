<?php
	include('config.php');
date_default_timezone_set('Africa/Douala');
/*/////////////////////LA FONCTION TIME DE CYRIAS LE PROGRAMMEUR. LE PLUS GRAND DE TOUS LES TEMPS//////////////////////////////

  'an(s)' => 31557600, 'moi' => 2629800, 'semaine' => 604800, 'jour' => 86400, 'heure' => 3600, 'min' => 60, 'sec' => 1
     $entiere = intval($cyc);  partie entiere
    $decimale = $cyc - $entiere;   partie decimale  
*/

/*$time1 = time() - $date_pub;*/
/*$times = time();
$date1 = date('d/m/Y H:i:s', $time1);
$date = date('d/m/Y H:i:s', time());

echo "$time => $date<br><br> $time1 => $date1<br><br><br><br>";*/

	extract($_POST); 
/*****************************************/
	if (isset($t5)) { 
		
		$time = time();

		$date_pub = $time + (60*5);
			echo $date_pub;

	}


/******************************************/
		if (isset($t10)) {
		
		$time = time();

		$date_pub = $time + (60*10);
			echo $date_pub;

	}


/*****************************************/
		if (isset($t15)) {
		
		$time = time();

		$date_pub = $time + (60*15);
			echo $date_pub;

	}


/****************************************/
			if (isset($t2sm)) {
		
		$time = time();

		$date_pub = $time + (604800*2);
			echo $date_pub;

	}

/**************************************/
			if (isset($t1n)) {
		
		$time = time();

		$date_pub = $time + (31557600*1);
			echo $date_pub;

	}

/**********************************/
			if (isset($t2n)) {
		
		$time = time();

		$date_pub = $time + (31557600*2);
			echo $date_pub;

	}

/********************************/
			if (isset($t3n)) {
		
		$time = time();

		$date_pub = $time + (31557600*3);
			echo $date_pub;

	}

/**************************************************/

	if (isset($sup5)) {	

$time = time();

$verif = "select * from user_licence where statut = 'ACTIF'";
	$ok = mysqli_query($conn,$verif);

	if ($vue = mysqli_fetch_assoc($ok)) {
		echo "il existe deja une licence actif";
	}
	else
	{
		$ins = "insert into user_licence values (null, '$time', '$calcul', '$time', 'ACTIF')";
		$ok = mysqli_query($conn,$ins);
		if ($ok) {
						$rqt = "UPDATE absence SET lc_date = '$calcul' WHERE id = '1'";
						 mysqli_query($conn,$rqt);
			echo 1; 
		} else {
			echo 0;
		}
	}

	}



		if (isset($sup10)) {		
$time = time();

$verif = "select * from user_licence where statut = 'ACTIF'";
	$ok = mysqli_query($conn,$verif);

	if ($vue = mysqli_fetch_assoc($ok)) {
		echo "il existe deja une licence actif";
	}
	else
	{
		$ins = "insert into licence values (null, '$time', '$calcul', '$time', 'ACTIF')";
		$ok = mysqli_query($conn,$ins);
		if ($ok) {
						$rqt = "UPDATE absence SET lc_date = '$calcul' WHERE id = '1'";
						 mysqli_query($conn,$rqt);
			echo 1;
		} else {
			echo 0;
		}
	}

	}



		if (isset($sup15)) {		
$time = time();

$verif = "select * from user_licence where statut = 'ACTIF'";
	$ok = mysqli_query($conn,$verif);

	if ($vue = mysqli_fetch_assoc($ok)) {
		echo "il existe deja une licence actif";
	}
	else
	{
		$ins = "insert into user_licence values (null, '$time', '$calcul', '$time', 'ACTIF')";
		$ok = mysqli_query($conn,$ins);
		if ($ok) {
						$rqt = "UPDATE absence SET lc_date = '$calcul' WHERE id = '1'";
						 mysqli_query($conn,$rqt);
			echo 1;
		} else {
			echo 0;
		}
	}

	}



			if (isset($sup2sm)) {		
$time = time();

$verif = "select * from user_licence where statut = 'ACTIF'";
	$ok = mysqli_query($conn,$verif);

	if ($vue = mysqli_fetch_assoc($ok)) {
		echo "il existe deja une licence actif";
	}
	else
	{
		$ins = "insert into user_licence values (null, '$time', '$calcul', '$time', 'ACTIF')";
		$ok = mysqli_query($conn,$ins);
		if ($ok) {
						$rqt = "UPDATE absence SET lc_date = '$calcul' WHERE id = '1'";
						 mysqli_query($conn,$rqt);
			echo 1;
		} else {
			echo 0;
		}
	}

	}

			if (isset($sup1n)) {		
$time = time();

$verif = "select * from user_licence where statut = 'ACTIF'";
	$ok = mysqli_query($conn,$verif);

	if ($vue = mysqli_fetch_assoc($ok)) {
		echo "il existe deja une licence actif";
	}
	else
	{
		$ins = "insert into user_licence values (null, '$time', '$calcul', '$time', 'ACTIF')";
		$ok = mysqli_query($conn,$ins);
		if ($ok) {
						$rqt = "UPDATE absence SET lc_date = '$calcul' WHERE id = '1'";
						 mysqli_query($conn,$rqt);
			echo 1;
		} else {
			echo 0;
		}
	}

	}

			if (isset($sup2n)) {		
$time = time();

$verif = "select * from user_licence where statut = 'ACTIF'";
	$ok = mysqli_query($conn,$verif);

	if ($vue = mysqli_fetch_assoc($ok)) {
		echo "il existe deja une licence actif";
	}
	else
	{
		$ins = "insert into user_licence values (null, '$time', '$calcul', '$time', 'ACTIF')";
		$ok = mysqli_query($conn,$ins);
		if ($ok) {
						$rqt = "UPDATE absence SET lc_date = '$calcul' WHERE id = '1'";
						 mysqli_query($conn,$rqt);
			echo 1;
		} else {
			echo 0;
		}
	}

	}

			if (isset($sup3n)) {		
$time = time();

$verif = "select * from user_licence where statut = 'ACTIF'";
	$ok = mysqli_query($conn,$verif);

	if ($vue = mysqli_fetch_assoc($ok)) {
		echo "il existe deja une licence actif";
	}
	else
	{
		$ins = "insert into user_licence values (null, '$time', '$calcul', '$time', 'ACTIF')";
		$ok = mysqli_query($conn,$ins);
		if ($ok) {
						$rqt = "UPDATE absence SET lc_date = '$calcul' WHERE id = '1'";
						 mysqli_query($conn,$rqt);
			echo 1;
		} else {
			echo 0;
		}
	}

	}



?>
