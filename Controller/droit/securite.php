<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

	if(!isset($_SESSION['Pharmacie']) || empty($_SESSION['Pharmacie']))
	{
		header("location:index.php?raison=securite"); 
        exit();
	}

?>
