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

	$day = $_GET["day"];
	$heure = $_GET["heure"];

	$dayPt;
	$heurePt;

	$reks = $bdd->query('SELECT dayPt, heurePt FROM points WHERE idPoint = (SELECT MAX(idPoint) FROM points)');

	while ($rek = $reks->fetch()) {
		$dayPt = $rek['dayPt'];
		$heurePt = $rek['heurePt'];
	}

	if (isset($dayPt) && isset($heurePt)) {		
		$pointsh  = new DateTime($heurePt);
		$pointsj  = new DateTime($dayPt);
	}
	
	$commandej = new DateTime($day);
	$commandeh = new DateTime($heure);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="author" content="Holynola">
	<title>
		Détail de la commande du <?php echo $day; ?>
		Heure <?php echo $heure; ?>		
	</title>
	<link rel="shortcut icon" href="../img/favicon.ico">
	<link rel="stylesheet" type="text/css" href="../style/detCmd.css" media="screen">
	<link rel="stylesheet" type="text/css" href="../style/impCmd.css" media="print">
	<script src="jquery-3.3.1.min.js"></script>
</head>
<script type="text/javascript">
	function printContent(el) {
		var restorepage = document.body.innerHTML;
		var printcontent = document.getElementById(el).innerHTML;
		document.body.innerHTML = printcontent;
		window.print();
		document.body.innerHTML = restorepage;
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
		
		<h1>
			Détail de la commande du <?php echo $day; ?><br>
			Heure <?php echo $heure; ?>
		</h1>

		<div class="cmdBox" id="boxCmd">

			<form method="post" id="sent" name="sent" enctype="multipart/form-data">
			<?php

				$reponse = $bdd->query("SELECT * FROM commande WHERE dayCmd = '$day' AND heureCmd = '$heure'");

				while ($donnees = $reponse->fetch()) {
			?>	
				<span class="name">Nom du fournisseur :</span>
				<?php
					$fours = $bdd->query("SELECT * FROM supplier WHERE idSup =".$donnees['fourId']);

					while ($four = $fours->fetch()) {
				?>
				<input type="text" name="fourId" id="fourId" value="<?php echo $four['nomSup']; ?>" readonly><br><br>
				<?php
					}
				?>
				
				<span class="fact">Numéro de la facture :</span>
				<input type="text" name="numfact" id="numfact" value="<?php echo $donnees['numfact']; ?>" autocomplete="off" readonly>
				<br><br>
				<span class="tot">Montant Total (Francs CFA) :</span>
				<input type="number" name="mtt" id="mtt" value="<?php echo $donnees['mtt']; ?>" required readonly> 
			<?php
				}
			?>
				<table id="idTable">
					<thead>
						<tr>
							<th>Désignation</th>
							<th>Prix d'achat<br>par casier (Francs CFA)</th>
							<th>Quantité</th>
							<th>Montant<br>(Francs CFA)</th>
						</tr>
					</thead>
					<tbody id="tblBody">
					<?php
						$result = $bdd->query("SELECT * FROM produit WHERE dayPr = '$day' AND heurePr = '$heure'");

						while ($disque = $result->fetch())
						{
					?>	
						<tr>		
							<td id="boisson" data-label="Désignation">
								<?php
									$boixons = $bdd->query("SELECT * FROM drink WHERE idDrink =".$disque['boissonId']);

									while ($boixon = $boixons->fetch()) {
								?>
								<input type="text" name="boissonId" value="<?php echo $boixon['designD']; ?>" id="boissonId" readonly>
								<?php
									}
								?>
							</td>
							<td id="prix" data-label="Prix d'achat par casier (Francs CFA)">
								<input type="number" name="pacasier" value="<?php echo $disque['pacasier']; ?>" id="pacasier" readonly>
							</td>
							<td id="quantite" data-label="Quantité">
								<input type="number" name="qte" value="<?php echo $disque['qte']; ?>" id="qte" readonly>
							</td>
							<td id="somme" data-label="Montant (Francs CFA)">
								<input type="number" name="montant" value="<?php echo $disque['montant']; ?>" id="montant" readonly>
							</td>
						</tr>
					<?php
						}
					?>		
					</tbody>		
				</table>
				<br>
			</form>
			<br><br>
			
			<?php if (isset($type) && $type == "proprietaire" OR $type == "superadmin") {
			
				if (isset($pointsj) && isset($pointsh)) {	
					if($commandej > $pointsj)
					{ ?>
						<button id="delet"><a href="delCmd.php?days=<?=$day?>&amp;hour=<?=$heure?>">Supprimer la commande</a></button>
				<?php	}
					elseif ($commandej == $pointsj)
					{
						if ($commandeh > $pointsh)
						{ ?>
							<button id="delet"><a href="delCmd.php?days=<?=$day?>&amp;hour=<?=$heure?>">Supprimer la commande</a></button>
						<?php }
					}
				} else {
					?>
						<button id="delet"><a href="delCmd.php?days=<?=$day?>&amp;hour=<?=$heure?>">Supprimer la commande</a></button>
					<?php
				} 
			} ?>

				<button id="imp" onclick="printContent('boxCmd')">Imprimer la commande</button>
				<button id="imp" onclick="window.document.location.href='lstcmd.php';">Retour</button>
				<br><br>	
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