<?php 
	$test = $users->verification_droit($_SESSION['Pharmacie']->id, 'statistique');
	
	if ($test == false) {
		
		session_destroy();

		$_SESSION=[]; 

		header("location:/pharmacie_bansoa/index.php"); 
	}
?>    	

