<?php
	session_start();

	if(!(isset($_SESSION['Pharmacie'])))
	{
		if($_SESSION['Pharmacie'] == [])
		{
			header("location:/Pharmacie/index.php?raison=securite"); 
		}
	}

?>