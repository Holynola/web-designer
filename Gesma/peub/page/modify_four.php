<?php

	session_start();

	if(isset($_SESSION["username"]))
	{
		
	}
	else
	{
		header("location:../index.php");
	}

	// Modifier une boisson
	include('dbConf.php');

	// Préparation de la requête
	$pdoStat = $bdd->prepare('UPDATE fournisseur SET nom = :nom , localisation = :localisation , contacts = :contacts WHERE idFour= :num LIMIT 1');

	// Liaison du paramètre nommé
	$pdoStat->bindValue(':num', $_GET['sid'], PDO::PARAM_INT);
	$pdoStat->bindParam(':nom', $_POST['nom']);
	$pdoStat->bindParam(':localisation', $_POST['localisation']);
	$pdoStat->bindParam(':contacts', $_POST['contacts']);

	// Exécution de la requête
	$executeIsOk = $pdoStat->execute();

	if ($executeIsOk){
		$message = 'La boisson a été supprimée';
		header("location:fournisseurs.php");
	}
	else
	{
		$message = "Echec de la suppression de la boisson";
		header("location:fournisseurs.php");
	}

?>	