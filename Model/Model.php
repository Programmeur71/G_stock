<?php 

require 'Model/Autoloader.php';

Autoloader::register();

require_once 'Model/Database.php';
require_once 'Model/Utilisateurdb.php';
	$utilisateurdb = new Utilisateurdb();
?>