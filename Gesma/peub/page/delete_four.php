<?php

	session_start();

	if(isset($_SESSION["username"]))
	{
		
	}
	else
	{
		header("location:../index.php");
	}

	// Supprimer un fournisseur
	include('dbConf.php');

	// Préparation de la requête
	$pdoStat = $bdd->prepare('DELETE FROM fournisseur WHERE idFour=:num LIMIT 1');

	// Liaison du paramètre nommé
	$pdoStat->bindValue(':num', $_GET['id'], PDO::PARAM_INT);

	// Exécution de la requête
	$executeIsOk = $pdoStat->execute();

	if ($executeIsOk){
		$message = 'Le fournisseur a été supprimée';
		header("location:fournisseurs.php");
	}
	else
	{
		$message = "Echec de la suppression du fournisseur";
		header("location:fournisseurs.php");
	}
?>	