<?php

	session_start();

	include('dbConf.php');

	if(isset($_SESSION["username"]))
	{
		$sender = $_SESSION["username"];
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
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="author" content="Holynola">
	<title>Détail du point du <?php echo $day; ?></title>
	<link rel="shortcut icon" href="../img/favicon.ico">
	<link rel="stylesheet" type="text/css" href="../style/detConso.css" media="screen">
	<link rel="stylesheet" type="text/css" href="../style/impConso.css" media="print">
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
<script src="jquery-3.3.1.min.js"></script>
<body onload="total();">
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

	<div id="content" name="content">
		<h1>Détail du point du <?php echo $day; ?></h1>

		<div class="cmdBox" id="boxCmd">

			<form id="frm" action="conso.php" name="frm" method="post">

				<div id="table-box">

					<table id="idTable">

						<thead>
							<tr class="tit">
								<th>Désignation</th> <!-- 1 -->
								<th>Commandes<br>(Casiers)</th> <!-- 2 -->
								<th>Bouteilles<br>commandées</th> <!-- 3 -->
								<th>Prix d'achat<br>par casier (FCFA)</th> <!-- 4 -->
								<th>Estimation<br>commande<br>(FCFA)</th> <!-- 5 -->
								<th>Stock<br>initial</th> <!-- 6 -->
								<th>Nouveau<br>stock</th> <!-- 7 -->
								<th>Prix de vente<br>unitaire (FCFA)</th> <!-- 8 -->
								<th>Estimation<br>du nouveau<br>stock (FCFA)</th> <!-- 9 -->
								<th>Bouteilles<br>vendues</th> <!-- 10 -->
								<th>Montant<br>vente</th> <!-- 11 -->
								<th>Bénéfice</th> <!-- 12 -->
								<th>Stock<br>restant</th> <!-- 13 -->
								<th>Stock<br>physique</th> <!-- 14 -->
								<th>Estimation du<br>stock physique<br>(FCFA)</th> <!-- 15 -->
								<th>Stock<br>manquant</th> <!-- 16 -->
								<th>Estimation du<br>stock manquant<br>(FCFA)</th> <!-- 17 -->
							</tr>
						</thead>

						<tbody>
							<?php
								$res = $bdd->query("SELECT * FROM conso WHERE dayConso = '$day' AND heureConso = '$heure'");

								while ($don = $res->fetch()) {
							?>
							<tr>
								<!-- 1:Désignation -->
								<td><?php echo $don["boixon"]; ?></td>

								<!-- 2:Commandes (Casiers) -->
								<td><?php echo $don["cmdcs"]; ?></td>

								<!-- 3:Bouteilles commandées -->
								<td><?php echo $don["btecmd"]; ?></td>

								<!-- 4:Prix d'achat par casier -->
								<td><?php echo $don["papcs"]; ?></td>

								<!-- 5:Estimation commande -->
								<td><?php echo $don["estcmd"]; ?></td>

								<!-- 6:Stock initial -->
								<td><?php echo $don["stcint"]; ?></td>

								<!-- 7:Nouveau stock -->
								<td><?php echo $don["nvstc"]; ?></td>

								<!-- 8:Prix de vente unitaire -->
								<td><?php echo $don["pdvuni"]; ?></td>

								<!-- 9:Estimation du nouveau stock -->
								<td><?php echo $don["estnstc"]; ?></td>

								<!-- 10:Bouteilles vendues -->
								<td><?php echo $don["bteven"]; ?></td>

								<!-- 11:Montant vente -->
								<td><?php echo $don["mttven"]; ?></td>

								<!-- 12:Bénéfice -->
								<td><?php echo $don["bene"]; ?></td>

								<!-- 13:Stock restant -->
								<td><?php echo $don["stcrst"]; ?></td>

								<!-- 14:Stock physique -->
								<td><?php echo $don["stcpsq"]; ?></td>

								<!-- 15:Estimation du stock physique -->
								<td><?php echo $don["estsp"]; ?></td>

								<!-- 16:Stock manquant -->
								<td><?php echo $don["stcman"]; ?></td>

								<!-- 17:Estimation du stock manquant -->
								<td><?php echo $don["estsm"]; ?></td>
							<?php
								}
							?>		
							</tr>
						</tbody>

						<tfoot id="total" name="total">
							<tr style="background-color: #1ABF4C; color: white;">
								<!-- 1:Désignation -->
								<td>TOTAUX</td>

								<!-- 2:Commandes (Casiers) -->
								<td id="tocom"></td>

								<!-- 3:Bouteilles commandées -->
								<td id="tobou"></td>

								<!-- 4:Prix d'achat par casier -->
								<td style="background-color: #000;"></td>

								<!-- 5:Estimation commande -->
								<td id="toesc"></td>

								<!-- 6:Stock initial -->
								<td id="toski"></td>

								<!-- 7:Nouveau stock -->
								<td id="tonsk"></td>

								<!-- 8:Prix de vente unitaire -->
								<td style="background-color: #000;"></td>

								<!-- 9:Estimation du nouveau stock -->
								<td id="toens"></td>

								<!-- 10:Bouteilles vendues -->
								<td id="tobtv"></td>

								<!-- 11:Montant vente -->
								<td id="tomtv"></td>

								<!-- 12:Bénéfice -->
								<td id="toben"></td>

								<!-- 13:Stock restant -->
								<td id="toskr"></td>

								<!-- 14:Stock physique -->
								<td id="toskp"></td>

								<!-- 15:Estimation du stock physique -->
								<td id="toesp"></td>

								<!-- 16:Stock manquant -->
								<td id="toskm"></td>

								<!-- 17:Estimation du stock manquant -->
								<td id="toesm"></td>
							</tr>
						</tfoot>
						
					</table>

				</div>

				<div id="autre">
					<?php
						$rest = $bdd->query("SELECT * FROM points WHERE dayPt = '$day' AND heurePt = '$heure'");

						while ($done = $rest->fetch()) {
					?>

						<table id="one">
							<tr>
								<td>
									Dépenses (FCFA) : 
								</td>
								<td data-label="Dépenses (FCFA) :">
									<input type="number" name="dpnx" value="<?php echo $done["dpsePt"]; ?>" readonly>
								</td>
							</tr>
							<tr>
								<td>
									Détails des<br>dépenses : 
								</td>
								<td data-label="Détails des dépenses : ">
									<textarea name="detail" id="detail" rows="10" cols="30" readonly><?php echo $done["detdepPt"]; ?></textarea>
								</td>
							</tr>
						</table>

						<table id="two">
							<tr>
								<td>
									Crédits (FCFA) : 
								</td>
								<td data-label="Crédits (FCFA) : ">
									<input type="number" name="credit" value="<?php echo $done["crdPt"]; ?>" id="credit" readonly>
								</td>
							</tr>
							<tr>
								<td>
									Détails des<br>crédits :
								</td>
								<td data-label="Détails des crédits : ">
									<textarea name="details" id="details" rows="10" cols="30" autocomplete="off" readonly><?php if(isset($don["details"])) { echo $don["details"]; } else { echo " " ; } ?></textarea>
								</td>
							</tr>
						</table>

						<table id="three">
							<tr>
								<td>
									Autres (FCFA) : 
								</td>
								<td data-label="Autres (FCFA) : ">
									<input type="number" name="autres" value="<?php echo $done["autrPt"]; ?>" id="autres" readonly>
								</td>
							</tr>
							<tr>
								<td>
									Détails des<br>autres :
								</td>
								<td data-label="Détails des autres : ">
									<textarea name="detailss" id="detailss" rows="10" cols="30" readonly><?php echo $done["detautrPt"]; ?></textarea>
								</td>
							</tr>
						</table>
				</div>	

				<div id="bef"></div>

				<div id="dbs">
					<table id="recap">
						<tr>
							<th style="text-align: center; font-weight: bold;">BILAN FINANCIER</th>
						</tr>
						<tr>
							<td style="text-align: right;">ESTIMATION DES COMMANDES (FCFA) :</td>
							<td>
								<?php echo $done["estcomPt"]; ?>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">ESTIMATION DU STOCK AVANT POINT (FCFA) :</td>
							<td>
								<?php echo $done["eststkPt"]; ?>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">MONTANT VENTE (FCFA) :</td>
							<td>
								<?php echo $done["mntvtePt"]; ?>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">BENEFICE (FCFA) :</td>
							<td>
								<?php echo $done["benefPt"]; ?>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">MONTANT RECU (FCFA) :</td>
							<td style="width: 100px;">
								<?php echo $done["mntrPt"]; ?>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">ECART MONTANTS (Vente/Reçu) (FCFA) :</td>
							<td>
								<?php echo $done["ekaPt"]; ?>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">DEPENSES (FCFA) :</td>
							<td>
								<?php echo $done["dpsePt"]; ?>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">CREDIT (FCFA) :</td>
							<td style="width: 100px;">
								<?php echo $done["crdPt"]; ?>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">AUTRES (FCFA) :</td>
							<td style="width: 100px;">
								<?php echo $done["autrPt"]; ?>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">ESTIMATION DU STOCK MANQUANT (FCFA) :</td>
							<td style="width: 100px;">
								<?php echo $done["mankPt"]; ?>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">ESTIMATION DU STOCK APRES POINT (FCFA) :</td>
							<td>
								<?php echo $done["estsapPt"]; ?>
							</td>
						</tr>
					<?php
						}
					?>		
					</table>

					<table id="stck">
					<?php
						$resut = $bdd->query("SELECT * FROM stock WHERE dayStk = '$day' AND heureStk = '$heure'");

						while ($dones = $resut->fetch()) {
					?>	
						<tr>
							<th style="text-align: center; font-weight: bold;">STOCKS</th>
						</tr>
						<tr>
							<td style="text-align: right;">BOUTEILLES EN STOCK AVANT COMMANDES :</td>
							<td>
								<?php echo $dones["btsavStk"]; ?>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">CASIERS COMMANDÉS :</td>
							<td style="width: 100px;">
								<?php echo $dones["ccmdStk"]; ?>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">BOUTEILLES EN STOCK APRES COMMANDES :</td>
							<td>
								<?php echo $dones["btsapStk"]; ?>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">BOUTEILLES VENDUES :</td>
							<td>
								<?php echo $dones["btevduStk"]; ?>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">STOCK RESTANT (BOUTEILLES) :</td>
							<td>
								<?php echo $dones["stkresStk"]; ?>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">STOCK PHYSIQUE (BOUTEILLES) :</td>
							<td>
								<?php echo $dones["stkphyStk"]; ?>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">STOCK MANQUANT (BOUTEILLES) :</td>
							<td>
								<?php echo $dones["stkmanStk"]; ?>
							</td>
						</tr>
					<?php
						}
					?>		
					</table>

					<table id="pers">
					<?php
						$rest = $bdd->query("SELECT * FROM points WHERE dayPt = '$day' AND heurePt = '$heure'");

						while ($done = $rest->fetch()) {
					?>	
						<tr>
							<th style="text-align: center; font-weight: bold;">PERSONNEL</th>
						</tr>
						<tr>
							<td style="text-align: right;">NOM DU GERANT :</td>
							<td style="width: 100px;">
								<?php echo $done["nomGer"]; ?>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">NOM DU CONTROLEUR :</td>
							<td>
								<?php echo $done["nomCrtl"]; ?>
							</td>
						</tr>
					<?php
						}
					?>	
					</table>

				</div>				

			</form>

			<div id="bef"></div>

			<div id="imp">
				<button onclick="window.document.location.href='lstpt.php';">Retour</button>
				<button onclick="printContent('boxCmd')">Imprimer le point</button>
			</div><br>
			
		</div>
	</div>

	<script>
		// Déclaration du tableau
		var tableau = document.getElementById("idTable");

		function total() {
			// Total des Casiers commandés
			var tocom = document.getElementById("tocom");

			for (var a = 1; a < tableau.rows.length-1; a++) {

				if (a <= 1) {
					tocom.innerHTML = parseInt(tableau.rows[a].cells[1].innerHTML);
				} else if (a > 1) {
					tocom.innerHTML = parseInt(tocom.innerHTML) + parseInt(tableau.rows[a].cells[1].innerHTML);
				} else {
					tocom.innerHTML = parseInt(tocom.innerHTML);
				}
			}

			// Total des Bouteilles commandées
			var tobou = document.getElementById("tobou");

			for (var a = 1; a < tableau.rows.length-1; a++) {

				if (a <= 1) {
					tobou.innerHTML = parseInt(tableau.rows[a].cells[2].innerHTML);
				} else if (a > 1) {
					tobou.innerHTML = parseInt(tobou.innerHTML) + parseInt(tableau.rows[a].cells[2].innerHTML);
				} else {
					tobou.innerHTML = parseInt(tobou.innerHTML);
				}
			}

			// Total des Estimations des commandes
			var toesc = document.getElementById("toesc");

			for (var a = 1; a < tableau.rows.length-1; a++) {

				if (a <= 1) {
					toesc.innerHTML = parseInt(tableau.rows[a].cells[4].innerHTML);
				} else if (a > 1) {
					toesc.innerHTML = parseInt(toesc.innerHTML) + parseInt(tableau.rows[a].cells[4].innerHTML);
				} else {
					toesc.innerHTML = parseInt(toesc.innerHTML);
				}
			}

			// Total des Stocks Initiaux
			var toski = document.getElementById("toski");

			for (var a = 1; a < tableau.rows.length-1; a++) {

				if (a <= 1) {
					toski.innerHTML = parseInt(tableau.rows[a].cells[5].innerHTML);
				} else if (a > 1) {
					toski.innerHTML = parseInt(toski.innerHTML) + parseInt(tableau.rows[a].cells[5].innerHTML);
				} else {
					toski.innerHTML = parseInt(toski.innerHTML);
				}
			}

			// Total des Nouveaux Stocks
			var tonsk = document.getElementById("tonsk");

			for (var a = 1; a < tableau.rows.length-1; a++) {

				if (a <= 1) {
					tonsk.innerHTML = parseInt(tableau.rows[a].cells[6].innerHTML);
				} else if (a > 1) {
					tonsk.innerHTML = parseInt(tonsk.innerHTML) + parseInt(tableau.rows[a].cells[6].innerHTML);
				} else {
					tonsk.innerHTML = parseInt(tonsk.innerHTML);
				}
			}

			// Total des Estimations des Nouveaux Stocks
			var toens = document.getElementById("toens");

			for (var a = 1; a < tableau.rows.length-1; a++) {

				if (a <= 1) {
					toens.innerHTML = parseInt(tableau.rows[a].cells[8].innerHTML);
				} else if (a > 1) {
					toens.innerHTML = parseInt(toens.innerHTML) + parseInt(tableau.rows[a].cells[8].innerHTML);
				} else {
					toens.innerHTML = parseInt(toens.innerHTML);
				}
			}

			// Total des Bouteilles vendues
			var tobtv = document.getElementById("tobtv");

			for (var a = 1; a < tableau.rows.length-1; a++) {

				if (a <= 1) {
					tobtv.innerHTML = parseInt(tableau.rows[a].cells[9].innerHTML);
				} else if (a > 1) {
					tobtv.innerHTML = parseInt(tobtv.innerHTML) + parseInt(tableau.rows[a].cells[9].innerHTML);
				} else {
					tobtv.innerHTML = parseInt(tobtv.innerHTML);
				}
			}

			// Total des Montant vente
			var tomtv = document.getElementById("tomtv");

			for (var a = 1; a < tableau.rows.length-1; a++) {

				if (a <= 1) {
					tomtv.innerHTML = parseInt(tableau.rows[a].cells[10].innerHTML);
				} else if (a > 1) {
					tomtv.innerHTML = parseInt(tomtv.innerHTML) + parseInt(tableau.rows[a].cells[10].innerHTML);
				} else {
					tomtv.innerHTML = parseInt(tomtv.innerHTML);
				}
			}

			// Total des Bénéfices
			var toben = document.getElementById("toben");

			for (var a = 1; a < tableau.rows.length-1; a++) {

				if (a <= 1) {
					toben.innerHTML = parseInt(tableau.rows[a].cells[11].innerHTML);
				} else if (a > 1) {
					toben.innerHTML = parseInt(toben.innerHTML) + parseInt(tableau.rows[a].cells[11].innerHTML);
				} else {
					toben.innerHTML = parseInt(toben.innerHTML);
				}
			}

			// Total des Stocks Restants
			var toskr = document.getElementById("toskr");

			for (var a = 1; a < tableau.rows.length-1; a++) {

				if (a <= 1) {
					toskr.innerHTML = parseInt(tableau.rows[a].cells[12].innerHTML);
				} else if (a > 1) {
					toskr.innerHTML = parseInt(toskr.innerHTML) + parseInt(tableau.rows[a].cells[12].innerHTML);
				} else {
					toskr.innerHTML = parseInt(toskr.innerHTML);
				}
			}

			// Total des Stocks Physiques
			var toskp = document.getElementById("toskp");

			for (var a = 1; a < tableau.rows.length-1; a++) {

				if (a <= 1) {
					toskp.innerHTML = parseInt(tableau.rows[a].cells[13].innerHTML);
				} else if (a > 1) {
					toskp.innerHTML = parseInt(toskp.innerHTML) + parseInt(tableau.rows[a].cells[13].innerHTML);
				} else {
					toskp.innerHTML = parseInt(toskp.innerHTML);
				}
			}

			// Total des Estimations des Stocks Physiques
			var toesp = document.getElementById("toesp");

			for (var a = 1; a < tableau.rows.length-1; a++) {

				if (a <= 1) {
					toesp.innerHTML = parseInt(tableau.rows[a].cells[14].innerHTML);
				} else if (a > 1) {
					toesp.innerHTML = parseInt(toesp.innerHTML) + parseInt(tableau.rows[a].cells[14].innerHTML);
				} else {
					toesp.innerHTML = parseInt(toesp.innerHTML);
				}
			}

			// Total des Stocks Manquants
			var toskm = document.getElementById("toskm");

			for (var a = 1; a < tableau.rows.length-1; a++) {

				if (a <= 1) {
					toskm.innerHTML = parseInt(tableau.rows[a].cells[15].innerHTML);
				} else if (a > 1) {
					toskm.innerHTML = parseInt(toskm.innerHTML) + parseInt(tableau.rows[a].cells[15].innerHTML);
				} else {
					toskm.innerHTML = parseInt(toskm.innerHTML);
				}
			}

			// Total des Estimations des Stocks Manquants
			var toesm = document.getElementById("toesm");

			for (var a = 1; a < tableau.rows.length-1; a++) {

				if (a <= 1) {
					toesm.innerHTML = parseInt(tableau.rows[a].cells[16].innerHTML);
				} else if (a > 1) {
					toesm.innerHTML = parseInt(toesm.innerHTML) + parseInt(tableau.rows[a].cells[16].innerHTML);
				} else {
					toesm.innerHTML = parseInt(toesm.innerHTML);
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