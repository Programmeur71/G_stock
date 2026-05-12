<?php
	$test = $users->verification_droit($_SESSION['Pharmacie']->id, 'personnel');
	if ($test === false) {
		
		session_destroy();

		$_SESSION=[]; 

		header("location:/pharmacie_bansoa/index.php?raison=cyc"); 
	}
?>
   
