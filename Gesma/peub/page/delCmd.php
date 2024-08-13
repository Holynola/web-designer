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

	$days = $_GET['days'];
	$hour = $_GET['hour'];

	// Commande
	$rek = $bdd->query("DELETE FROM commande WHERE dayCmd = '$days' AND heureCmd = '$hour'");

	// Produit
	$reke = $bdd->query("DELETE FROM produit WHERE dayPr = '$days' AND heurePr = '$hour'");

	// Qte commande
	$reket = $bdd->query("DELETE FROM qtecommande WHERE dayQtc = '$days' AND heureQtc = '$hour'");

	header("location:lstcmd.php");
?>