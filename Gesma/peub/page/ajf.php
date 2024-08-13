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

	$msg = "";
	if(isset($_POST['ajouter']))
	{
		$nom = $_POST['nom'];
		$localisation = $_POST['localisation'];
		$contacts = $_POST['contacts'];

		$req = $bdd-> prepare('INSERT INTO fournisseur (nom, localisation, contacts) VALUES (:nom, :localisation, :contacts)');
		$req->execute(array(
			'nom' => $nom,
			'localisation' => $localisation,
			'contacts' => $contacts));

		header("location:fournisseurs.php");
	}

	if(isset($_POST['retour'])) {
		header("location:fournisseurs.php");
	}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="author" content="Holynola">
	<title>Ajouter un Fournisseur</title>
	<link rel="shortcut icon" href="../img/favicon.ico">
	<link rel="stylesheet" type="text/css" href="../style/ajf.css">
	<script src="jquery-3.3.1.min.js"></script>
</head>
<script>
	function val() {
		if (frm.nom.value == "") {
			alert("Veuillez entrer le nom du fournisseur !");
			frm.nom.focus();
			return false;
		}

		if (frm.localisation.value == "") {
			alert("Veuillez saisir la situation géographique de votre fournisseur !");
			frm.localisation.focus();
			return false;
		}

		if (frm.contacts.value == "") {
			alert("Veuillez entrer le(s) contact(s) du fournisseur !");
			frm.contacts.focus();
			return false;
		}

		return true;
	}
</script>
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
			<h1> Ajouter un Fourniseur </h1>

			<form method="post" id="frm" name="frm" action="ajf.php" enctype="multipart/form-data">
				<p>Nom du Fournisseur : </p>
				<input type="text" id="nom" name="nom" size="50" autocomplete="off" />
				
				<p>Localisation : </p>
				<input type="text" id="localisation" name="localisation" size="100" autocomplete="off" />

				<p>Contacts : </p>
				<input type="text" id="contacts" name="contacts" size="100" autocomplete="off" />
				
				<input type="submit" name="ajouter" value="Ajouter" onclick="return val();">
				<input type="submit" name="retour" value="Retour">
			</form>
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