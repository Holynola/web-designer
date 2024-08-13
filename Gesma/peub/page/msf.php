<?php

	session_start();

	include('dbConf.php');

	if(isset($_SESSION["username"]))
	{
		$user = $_SESSION["username"];
		$logs = $bdd->query("SELECT * FROM login WHERE username = '$user'");

		while ($log = $logs->fetch()) {
			$type = $log['type'];
		}

		if(isset($_SESSION['timestamp'])){ // si $_SESSION['timestamp'] existe
	    	if($_SESSION['timestamp'] + 600 > time()){
	            $_SESSION['timestamp'] = time();
	        } else { 
	        	session_destroy();
	        }
	    } else { 
	    	$_SESSION['timestamp'] = time();
	    }
	}
	else
	{
		header("location:../index.php");
	}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="author" content="Holynola">
	<title>Informations sur le fournisseur</title>
	<link rel="shortcut icon" href="../img/favicon.ico">
	<link rel="stylesheet" type="text/css" href="../style/msf.css">
	<script src="jquery-3.3.1.min.js"></script>
</head>
<body>
		
		<header>
			<!-- Logo -->
			<div class="logo">
				<a href="index.php">
					<img src="../img/logo.png">
				</a>
			</div>	

			<!-- Menu -->
			<button id="option">Menu</button>
			<ul id="menu">
				<li><a href="index.php">Accueil</a></li>
				<li><a href="boissons.php">Boissons</a></li>
				<li id="cmd"><a href="#">Commandes</a>
					<ul class="sousmenu" id="sousmenu">
						<?php if (isset($type) && $type == "gerant" OR $type == "superadmin") { ?>
							<li><a href="nvcmd.php">Nouvelle<br>Commande</a></li>
						<?php } ?>
						<li><a href="lstcmd.php">Liste des<br>Commandes</a></li>
						<li><a href="lstcmdpf.php">Liste des<br>Commandes<br>(Par fournisseur)</a></li>
					</ul>
				</li>
				<li><a href="fournisseurs.php">Fournisseurs</a></li>
				<?php if (isset($type) && $type !== "gerant") { ?>
					<li><a href="stock.php">Stocks</a></li>
				<?php } ?>	
				<li><a href="espc.php">Espace Conso</a></li>
				<?php if (isset($type) && $type !== "gerant") { ?>
					<li><a href="lstpt.php">Points</a></li>
				<?php } ?>
				<li><a href="logout.php">Se déconnecter</a></li>
			</ul>
		</header>

		<div id="content">
			<div class="infoBox">
				<?php
				$reponse = $bdd->query('SELECT * FROM fournisseur WHERE idFour='.$_GET['pid']);

				while ($donnees = $reponse->fetch())
				{
					echo "<h1 style='color:orange;'>Nom : ".$donnees['nom']."</h1>";
					echo "<h5>Lieu : ".$donnees['localisation']."</h5>";
					echo "<h4>Contacts : ".$donnees['contacts']."</h4>";
				}
				?>

				<?php if (isset($type) && $type == "proprietaire" OR $type == "superadmin") { ?>
					<form method="post" action="mdff.php?id=<?=$_GET['pid']?>" enctype="multipart/form-data">
						<a href="mdff.php?id=<?=$_GET['pid']?>" style="text-decoration: none;">	
						<input type="submit" name="modifier" value="Modifier">
						</a>
					</form>		
					<form method="post" action="delete_four.php?id=<?=$_GET['pid']?>" enctype="multipart/form-data">
						<a href="delete_four.php?id=<?=$_GET['pid']?>" style="text-decoration: none;">
							<input type="submit" name="supprimer" value="Supprimer">
						</a>
					</form>
				<?php } ?>	

				<button id="retour" onclick="window.document.location.href='fournisseurs.php';">Retour</button>
			</div>	
		</div>

	<script>
		$("#option").click(function() {
			$("#menu").toggle(500);
		});

		$("#cmd").click(function() {
			$("#sousmenu").toggle(500);
		})
	</script>	
</body>
</html>