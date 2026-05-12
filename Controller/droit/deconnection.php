<?php
include ('securite.php');

	session_destroy();

		$_SESSION=[];    

	header("location:../../index.php");

?>
