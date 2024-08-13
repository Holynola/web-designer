<?php

	session_start();

	if(isset($_SESSION["username"]))
	{
		
	}
	else
	{
		header("location:../index.php");
	}

	// Supprimer une boisson
	include('dbConf.php');

	// Préparation de la requête
	$pdoStat = $bdd->prepare('DELETE FROM login WHERE idLog=:num LIMIT 1');

	// Liaison du paramètre nommé
	$pdoStat->bindValue(':num', $_GET['id'], PDO::PARAM_INT);

	// Exécution de la requête
	$executeIsOk = $pdoStat->execute();

	if ($executeIsOk){
		$message = "L'utilisateur a été supprimé";
		header("location:users.php");
	}
	else
	{
		$message = "Echec de la suppression de l'utilisateur";
		header("location:users.php");
	}
?>	