<?php

	session_start();

	if(isset($_SESSION["username"]))
	{
		
	}
	else
	{
		header("location:../index.php");
	}

	include('dbConf.php');

	// Préparation de la requête
	$pdoStat = $bdd->prepare('UPDATE boisson SET design = :design , prix = :prix , btpcasier = :btpcasier WHERE idBoisson= :num LIMIT 1');

	// Liaison du paramètre nommé
	$pdoStat->bindValue(':num', $_GET['sid'], PDO::PARAM_INT);
	$pdoStat->bindParam(':design', $_POST['design']);
	$pdoStat->bindParam(':prix', $_POST['prix']);
	$pdoStat->bindParam(':btpcasier', $_POST['btpcasier']);

	// Exécution de la requête
	$executeIsOk = $pdoStat->execute();

	if ($executeIsOk){
		$message = 'La boisson a été supprimée';
		header("location:boissons.php");
	}
	else
		$message = "Echec de la suppression de la boisson";
		header("location:boissons.php");

?>	