<?php
	$pseudo = "";

	session_start();

	include('dbConf.php');

	if(isset($_SESSION["username"])) {
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
	else {
		header("location:../index.php");
	}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="author" content="Holynola">
	<title>Accueil</title>
	<link rel="shortcut icon" href="../img/favicon.ico">
	<link rel="stylesheet" type="text/css" href="../style/home.css">
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
		<br><br><br>
		<img id="image" src="../img/bgbn.jpg" width="100%">
		<h1 id="welcome">Bienvenue au maquis</h1>
		<h2 id="mbb">Bleu Blanc</h2>
		
		<div id="info">
			<?php if (isset($type) && $type == "proprietaire" OR $type == "superadmin") { ?>
				<h1 class="add">Ajouter un utilisateur</h1><br>
				<button class="btn" onclick="window.document.location.href='send.php';">Cliquez ICI</button><br><br>
				<h1 class="add">Liste des utilisateurs<br>enregistrés</h1><br>
				<button class="btn" onclick="window.document.location.href='users.php';">Cliquez ICI</button><br><br>
				<h1 class="add">Historique<br>des connexions</h1><br>
				<button class="btn" onclick="window.document.location.href='inlog.php';">Cliquez ICI</button><br><br>
			<?php } ?>		
				<h1 class="add">Guide d'utilisation</h1><br>
				<button class="btn" onclick="window.open('guide.php','_blank');">Cliquez ICI</button><br><br>
				<h1 class="add">Termes et Conditions</h1><br>
				<button class="btn" onclick="window.open('condi.php','_blank');">Cliquez ICI</button><br><br>

				<h1 class="add">Application développée<br>par :</h1>
				<div id="pdc"></div><br>
				
				<h2 class="bad">Contacts :</h2>
				<h2 class="bae">07-52-63-30 / 57-91-32-44</h2>
				<h2 class="bae">01-18-86-55 / 45-15-84-08</h2>
				
				<h2 class="bad">Visitez notre site : <a href="#" style="color: black;">ICI</a></h2>
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