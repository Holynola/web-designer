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
	<title>Liste des utilisateurs</title>
	<link rel="shortcut icon" href="../img/favicon.ico">
	<link rel="stylesheet" type="text/css" href="../style/users.css">
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
			<div class="wrap">
				<h1>Liste des Utilisateurs</h1>
				<?php if (isset($type) && $type !== "gerant") { ?>
					<?php
						$reponse = $bdd->query('SELECT * FROM login WHERE type != "superadmin" ORDER BY name ASC');

						while ($donnees = $reponse->fetch())
						{
						?>
							<a onclick="return val();" href="userdel.php?id=<?=$donnees['idLog']?>" style="text-decoration: none;color: black;" title="Effacer l'utilisateur">	
								<form method="post" enctype="multipart/form-data">
									<li>
										<div class="container">
											<br>
										<p><b>Nom : </b><b style="color: orange;"><?php echo $donnees['name']; ?></b></p>
										<p><b style="color: green;">Identifiant : </b><?php echo $donnees['username']; ?></p>
										<p><b style="color: green;">Type d'utilisateur : </b><?php echo $donnees['type']; ?></p>
										<br>
										</div>
									</li>
								</form>		
							</a>
							<?php
						}
					?>
				<?php } ?>		
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

	<script>
		function val() {
			var rep = confirm("Voulez-vous supprimer cet utilisateur ?");

			if (rep == true) {
				return true;
			} else {
				return false;
			}
		}
	</script>	
</body>
</html>