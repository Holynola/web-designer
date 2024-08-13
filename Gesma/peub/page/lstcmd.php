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

	$wrapj = "display: block;" ;

	// Jour
	$_sltjour = date('d-m-Y');
	if (isset($_POST['slct3'])) {
		$_sltjour = $_POST['slct3'];
	}

	// Mois
	$_sltmois = date('m-Y');
	if (isset($_POST['slct4'])) {
		$_sltmois = $_POST['slct4'];
	}

	// Par Jour
	if (isset($_POST['slct2']) AND $_POST['slct2'] == 'jour') {
		$_POST['slct2'] = 'Par Jour';
		$slctIII = "display: block;" ;
		$slctIV = "display: none;" ;
		$wrapj = "display: block;" ;
		$wrapm = "display: none;" ;
	}
	
	// Par Mois
	if (isset($_POST['slct2']) AND $_POST['slct2'] == 'mois') {
		$_POST['slct2'] = 'Par Mois';
		$slctIII = "display: none;" ;
		$slctIV = "display: block;" ;
		$wrapj = "display: none;" ;
		$wrapm = "display: block;" ;
	}
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="author" content="Holynola">
		<title>Liste des commandes</title>
		<link rel="shortcut icon" href="../img/favicon.ico">
		<link rel="stylesheet" type="text/css" href="../style/lstcmd.css">
	</head>
	<script src="jquery-3.3.1.min.js"></script>
	<script type="text/javascript">
		function showMyData() {
			$.ajax ({
				type: "POST",
				url: "showdtm.php",
				data: {
					age:$("#slct4").val()
				},
				success: function (data) {
					$("#wrapmois").html(data);
				}
			});
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
			<h1>Liste des commandes</h1>
			
			<hr>

			<form action="lstcmd.php" method="post">

			<select id="slct2" name="slct2" onchange="this.form.submit();" style = "<?php echo $slctII ; ?>">
				<option>
					<?php
						if (isset($_POST['slct2'])) {
							echo $_POST['slct2'];
						} else {
							echo "Trier";
						}
					?>
				</option>
				<option value="jour">Par Jour</option>
				<option value="mois">Par Mois</option>
			</select>

			<!-- Jour -->
			<select id="slct3" name="slct3" onchange="this.form.submit();" style = "<?php echo $slctIII ; ?>">
				<option><?php echo $_sltjour ; ?></option>
			<?php
				$temp = $bdd->query('SELECT DISTINCT dayCmd FROM commande ORDER BY dayCmd DESC');

				while ($temps = $temp->fetch()) {
			?>	
				<option value="<?php echo $temps['dayCmd']; ?>">
					<?php
						echo $temps['dayCmd'];
					?>
				</option>
			<?php
				}
			?>		
			</select>

			<!-- Mois -->
			<select id="slct4" name="slct4" onchange="showMyData();" style = "<?php echo $slctIV ; ?>">
				<option><?php echo $_sltmois ; ?></option>
			<?php
				$temp_2 = $bdd->query('SELECT DISTINCT moisCmd FROM commande ORDER BY moisCmd DESC');

				while ($temps_2 = $temp_2->fetch()) {
			?>	
				<option value="<?php echo $temps_2['moisCmd'];?>">
					<?php
						echo $temps_2['moisCmd'];
					?>
				</option>
			<?php
				}
			?>		
			</select>

			</form>

			<!-- Afficher en fonction du jour -->
				<div class="wrap" id="wrapjour" style = "<?php echo $wrapj ; ?>">
					<?php	
						$reponse = $bdd->query("SELECT * FROM commande, supplier WHERE commande.fourId = supplier.idSup AND dayCmd ='$_sltjour'");

						while ($donnees = $reponse->fetch())
						{
					?>
					<a href="detCmd.php?day=<?=$donnees['dayCmd']?>&amp;heure=<?=$donnees['heureCmd']?>" style="text-decoration: none;color: black;">	
						<form method="post" enctype="multipart/form-data">
							<li>
								<div class="container">
									<br>
									<p>Date : <?php echo $donnees['dayCmd']; ?></p>
									<p style="color: orange;">N° Facture : <?php echo $donnees['numfact']; ?></p>
									<p><span style="color: green;">Fournisseur :</span><br><?php echo $donnees['nomSup'] ?></p>
									<p><span style="color: green;">Montant :</span><br><?php echo $donnees['mtt']; ?> Francs CFA</p>
								</div>
							</li>
						</form>
					</a>	
					<?php
						}
					?>	
				</div>
			
			<!-- Afficher en fonction du mois -->
			<div class="wrap" id="wrapmois" style = "<?php echo $wrapm ; ?>">
				<?php
					$reponse = $bdd->query("SELECT * FROM commande, supplier WHERE commande.fourId = supplier.idSup AND moisCmd ='$_sltmois'");

					while ($donnees = $reponse->fetch()) {
				?>	
				<a href="detCmd.php?day=<?=$donnees['dayCmd']?>&amp;heure=<?=$donnees['heureCmd']?>" style="text-decoration: none;color: black;">
					<form method="post" enctype="multipart/form-data">
						<li>
							<div class="container">
								<br>
								<p>Date : <?php echo $donnees['dayCmd']; ?></p>
								<p style="color: orange;">N° Facture : <?php echo $donnees['numfact']; ?></p>
								<p><span style="color: green;">Fournisseur :</span><br><?php echo $donnees['nomSup'] ?></p>
								<p><span style="color: green;">Montant :</span><br><?php echo $donnees['mtt']; ?> Francs CFA</p>
							</div>
						</li>
					</form>
				</a>	
				<?php
				}
				?>	
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