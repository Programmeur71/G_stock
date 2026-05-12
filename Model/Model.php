<?php 

require 'Autoloader.php';

Autoloader::register();

require_once 'Database.php';

	$autorisationdb = new Autorisationdb();

	$commandedb = new Commandedb();

	$clientdb = new Clientdb();

	$fournisseurdb = new Fournisseurdb();

	$formedb = new Formedb();

	$gradedb = new Gradedb();

	$medicamentdb = new Medicamentdb();
	
	$users = new Personneldb();

	$stockdb = new Stockdb();

	$ventedb = new Ventedb();

	$facturesdb = new Facturesdb();

	$statistiquedb = new Statistiquedb();
?>