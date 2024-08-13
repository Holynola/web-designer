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
	<title>Modifier une boisson</title>
	<link rel="shortcut icon" href="../img/favicon.ico">
	<link rel="stylesheet" type="text/css" href="../style/mdfb.css">
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
		<h1>Modifier une Boisson</h1>
		<?php

			$reponse = $bdd->query('SELECT * FROM boisson WHERE idBoisson='.$_GET['id']);

			while ($donnees = $reponse->fetch())
			{
		?>
		<form method="post" action="modify_boisson.php?sid=<?=$_GET['id']?>" enctype="multipart/form-data">
			<p>Image de la boisson :</p>
			<?php echo "<img width=100% height=180 style='float: left;' src=".$donnees['image'].">"; ?>
			<p>Nom de la boisson : </p>
			<input type="text" name="design" value="<?= $donnees['design'] ?>" size="30" autocomplete="off" required />

			<p>Prix de la boisson : </p>
			<input type ="number" step="any" name="prix" value="<?= $donnees['prix'] ?>" required >
			
			<p>Nombre de bouteilles par casier : </p>
			<input type ="number" name="btpcasier" value="<?= $donnees['btpcasier'] ?>" required >
		<?php
			}
		?>	
			<a href="modify_boisson.php?sid=<?=$_GET['id']?>" style="text-decoration: none;">
				<input type="submit" name="modifier" value="Modifier">
			</a>
			<button id="retour" onclick="window.document.location.href='boissons.php';">Retour</button>
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