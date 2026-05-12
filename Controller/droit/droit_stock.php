<?php 
	$test = $users->verification_droit($_SESSION['Pharmacie']->id, 'stock');
	
	if ($test == false) {
		
		session_destroy();

		$_SESSION=[]; 

		header("location:index.php"); 
	}
?>    	

