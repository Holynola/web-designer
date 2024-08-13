<?php
	
	date_default_timezone_set("Africa/Abidjan");

	try {
		// On se connecter à MySQL
		$bdd = new PDO('mysql:host=localhost;dbname=kima', 'root', 'sgl.dev2018', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	} catch(Exception $e) {
		// En cas d'erreur, on affiche un message et on arrête tout
		die('Erreur : '.$e->getMessage());
	}
?>