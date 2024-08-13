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

	if (isset($_GET['info'])) {
		$error = $_GET['info'];
	}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="author" content="Holynola">
	<title>Nouvelle Commande</title>
	<link rel="shortcut icon" href="../img/favicon.ico">
	<link rel="stylesheet" type="text/css" href="../style/nvcmd.css">
</head>
<script src="jquery-3.3.1.min.js"></script>
<script>
	function show() {
		alert("Veuillez vous assurez que la fiche de commande a été bien remplie avant d'enregistrement votre commande !");
	}
</script>
<body onload="show();">	
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
		<h1>Nouvelle Commande</h1>
	<?php if (isset($type) && $type == "gerant" OR $type == "superadmin") { ?>
		<div class="cmdBox">
			<form method="post" action="acp.php">
				<span class="name">Nom du fournisseur :</span>
				<select name="fourId" class="fourId" id="fourId" required>
					<option value=""></option>
					<?php
						$reponse = $bdd->query('SELECT * FROM fournisseur ORDER BY nom ASC');
						

						while ($donnees = $reponse->fetch())
						{
					?>
					<option value="<?php echo $donnees[0];?>"><?php echo $donnees[1];?></option>
					<?php
						}
					?>
				</select>

				<span class="fact">Numéro de la facture :</span>
				<input type="text" name="numfact" id="numfact" autocomplete="off" required>
				
				<div style="display: none;">
					<!-- Jour de la semaine -->
					<input type="number" name="jour" id="jour" value="<?php echo date('N'); ?>" readonly>
					<!-- Jour du calendrier -->
					<input type="text" name="day" id="day" value="<?php echo date('d-m-Y'); ?>" readonly>
					<!-- Mois -->
					<input type="text" name="mois" id="mois" value="<?php echo date('m-Y'); ?>" readonly>
					<!-- Année -->
					<input type="text" name="annee" id="annee" value="<?php echo date('Y'); ?>" readonly>
					<!-- Heure -->
					<input type="text" name="heure" id="heure" value="<?php echo date('H:i:s'); ?>" readonly>
				</div>

				<table id="idTable">
					<thead>
						<tr>
							<th id="desi">Désignation</th>
							<th id="pac">Prix d'achat<br>par casier (Francs CFA)</th>
							<th id="qua">Quantité</th>
							<th id="mon">Montant<br>(Francs CFA)</th>
						</tr>
					</thead>
					<tbody id="tblBody">
						<tr style="display: none;">		
							<td id="boisson" label="Désignation">	
								<select name="boissonId" id="boissonId">
									<option value=""></option>
						<?php
							$result = $bdd->query('SELECT * FROM boisson ORDER BY design ASC');

							while ($disque = $result->fetch())
							{
						?>			
									<option value="<?php echo $disque[0];?>"><?php echo $disque[1];?></option>
						<?php		
							}
						?>									
								</select>
							</td>
							<td id="prix" label="Prix d'achat par casier (Francs CFA)">
								<input type="number" name="pacasier" id="pacasier" onblur="calculerCellules();calculMtt();">
							</td>
							<td id="quantite" label="Quantité">
								<input type="number" name="qte" id="qte" onblur="calculerCellules();calculMtt();">
							</td>
							<td id="somme" label="Montant">
								<input type="number" name="montant" id="montant" readonly>
							</td>
						</tr>
					</tbody>		
				</table>
				<br>
				<span class="tot">Montant Total :</span>
				<input type="number" name="mtt" id="mtt" readonly>
				<br><br>
				<p class="Ligne" style="clear: both;">	
					<input type="submit" name="register" id="register" value="Enregistrer">
				</p>
			</form>
			<p class="Line">
				<button name="ajout" onclick="insererCellules();">Ajouter une ligne</button>
				<button onclick="effacerCellules();">Effacer une ligne</button>
			</p>
			<p class="form-message">
				<?php
					if (isset($error))
						echo $error;
				?>
			</p>
		</div>
	<?php } ?>	
	</div>

	<script type="text/javascript">

		// Déclaration du tableau
		var tableau = document.getElementById("idTable");
		var mtt = document.getElementById("mtt");

		function calculerCellules() {

			for (var i = 1; i < tableau.rows.length; i++) {

				for (var j = 0; j < tableau.rows[i].cells.length; j++) {

					var calcul;
					calcul = tableau.rows[i].cells[1].children[0].value * tableau.rows[i].cells[2].children[0].value;
					tableau.rows[i].cells[3].children[0].value = calcul;

				}

			}

		}

		var tblBody = document.getElementById("tblBody");

		var b = 1;
		var a;

		// Déclaration des cellules du tableau
		var boisson = document.getElementById("boisson");
		var prix = document.getElementById("prix");
		var quantite = document.getElementById("quantite");
		var somme = document.getElementById("somme");

		// Déclaration du contenu des cellules du tableau
		var boissonId = document.getElementById("boissonId");
		var pacasier = document.getElementById("pacasier");
		var qte = document.getElementById("qte");
		var montant = document.getElementById("montant");
		var mtt = document.getElementById("mtt");

		// Déclaration des titres du tableau
		var desi = document.getElementById("desi");
		var pac = document.getElementById("pac");
		var qua = document.getElementById("qua");
		var mon = document.getElementById("mon");

		function insererCellules() {
			var cell1, cell2, cell3, cell4, ligne;
			var nbLignes = tableau.rows.length;

			ligne = tableau.insertRow(-1);

			cell1 = ligne.insertCell(0);
			cell1.innerHTML = boisson.innerHTML;
			cell1.id = boisson.id + b;
			cell1.label = desi.innerHTML;
			cell1.children[0].id = boissonId.id + b;
			cell1.children[0].name = boissonId.name + b;
			cell1.children[0].setAttribute("required","required");

			cell2 = ligne.insertCell(1);
			cell2.innerHTML = prix.innerHTML;
			cell2.id = prix.id + b;
			cell2.label = pac.innerText;
			cell2.children[0].id = pacasier.id + b;
			cell2.children[0].name = pacasier.name + b;
			cell2.children[0].setAttribute("required","required");

			cell3 = ligne.insertCell(2);
			cell3.innerHTML = quantite.innerHTML;
			cell3.id = quantite.id + b;
			cell3.label = qua.innerHTML;
			cell3.children[0].id = qte.id + b;
			cell3.children[0].name = qte.name + b;
			cell3.children[0].setAttribute("required","required");

			cell4 = ligne.insertCell(3);
			cell4.innerHTML = somme.innerHTML;
			cell4.id = somme.id + b;
			cell4.label = mon.innerText;
			cell4.children[0].id = montant.id + b;
			cell4.children[0].name = montant.name + b;
			cell4.children[0].setAttribute("required","required");

			a = nbLignes;
			b++;

			tblBody.appendChild(ligne);
		}

		function effacerCellules() {
			for (var o = 2; o < tableau.rows.length; o++) {
				var fff = tableau.rows[o].cells[3].children[0].value;
			}

			mtt.value = parseInt(mtt.value) - parseInt(fff);
			
			if (tableau.rows.length > 1) {
				tableau.deleteRow(-1);
			}	
		}

		function calculMtt() {

			for (var k = 1; k < tableau.rows.length; k++) {

				if (k <= 1) {
					mtt.value = parseInt(tableau.rows[k].cells[3].children[0].value);
				} else if (k > 1) {
					mtt.value = parseInt(mtt.value) + parseInt(tableau.rows[k].cells[3].children[0].value);
				} else {
					mtt.value = parseInt(mtt.value);
				}

			}

		}
	</script>

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