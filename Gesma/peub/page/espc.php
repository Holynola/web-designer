<?php

	session_start();

	include('dbConf.php');

	if(isset($_SESSION["username"]))
	{
		$sender = $_SESSION["username"];
		$logs = $bdd->query("SELECT * FROM login WHERE username = '$sender'");

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
	<title>Espace Conso</title>
	<link rel="shortcut icon" href="../img/favicon.ico">
	<link rel="stylesheet" type="text/css" href="../style/espc.css">
	<script src="jquery-3.3.1.min.js"></script>
</head>
<script>
	$(document).ready(function() {
		$("#save").click(function() {
			$.ajax({
				url:"espac.php",
				type:"post",
				data:$("#frm").serialize(),
				success:function(d) {
					if (d == "") {
						alert('Enregistrement effectué !');
					} else {
						alert("Erreur !!!");
					}	
				}
			});
		});
	});
</script>
<body onload="calcul();total();cache();">	
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
			Espace Conso
			<span style="color: red;">
				<?php
					if (isset($error))
						echo $error;
				?>
			</span>	
		</h1>

		<div class="cmdBox">
			<form id="frm" action="cnso.php" name="frm" onkeypress="BloqSubmit();" method="post">
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
				
				<div id="table-box">
					<table id="idTable">
						<thead>
							<tr class="tit">
								<th>Désignation</th> <!-- 1 -->
								<th>Commandes<br>(Casiers)</th> <!-- 2 -->
								<th style="display: none;">Bouteilles<br>par casier</th> <!-- 3 -->
								<th>Bouteilles<br>commandées</th> <!-- 4 -->
								<th>Prix d'achat<br>par casier (FCFA)</th> <!-- 5 -->
								<th>Prix d'achat<br>par bouteille<br>(FCFA)</th> <!-- 6 -->
								<th>Estimation<br>commande<br>(FCFA)</th> <!-- 7 -->
								<th>Stock<br>initial</th> <!-- 8 -->
								<th>Nouveau<br>stock</th> <!-- 9 -->
								<th>Prix de vente<br>unitaire (FCFA)</th> <!-- 10 -->
								<th>Estimation du<br>nouveau stock<br>(FCFA)</th> <!-- 11 -->
								<th>Bouteilles<br>vendues</th> <!-- 12 -->
								<th>Montant<br>vente</th> <!-- 13 -->
								<th id="titre">Bénéfice</th> <!-- 14 -->
								<th>Stock<br>restant</th> <!-- 15 -->
								<th id="titres">Stock<br>Physique</th> <!-- 16 -->
								<th id="titrese">Estimation du<br>stock physique<br>(FCFA)</th> <!-- 17 -->
								<th id="titreses">Stock<br>manquant</th> <!-- 18 -->
								<th id="titresese">Estimation du<br>stock manquant<br>(FCFA)</th> <!-- 19 -->
							</tr>
						</thead>
						<tbody>
							<?php
								$ligne = 1;
								$check = $bdd->prepare('SELECT * FROM qtecommande');
								$check->execute();
								$chk = $check->rowCount();

								if ($chk == 0) {
									$bssn = $bdd->query('SELECT * FROM boisson ORDER BY idBoisson');
								} else {	
									$bssn = $bdd->query("
										SELECT design, idBoisson, btpcasier, pachat, pachats, bouven, mac, stkini, stkinit, prix, boixonId, ROUND(AVG(paksier)) AS prx, SUM(qtt) AS qt, SUM(montt) AS mt 
										FROM boisson
										LEFT JOIN qtecommande ON boisson.idBoisson = qtecommande.boixonId
										GROUP BY boisson.idBoisson
										");
								}
								
								while ($bss = $bssn->fetch()) {
							?>
							<tr>

								<!-- 1:Désignation -->
								<td style="width:150px;">
									<input style="width:150px;" type="text" id="boixon<?php echo $ligne; ?>" name="boixon<?php echo $ligne; ?>" value="<?php echo $bss['design']; ?>" readonly>
								</td>

								<!-- 2:Commandes (Casiers) -->
								<td>
									<input type="number" id="cmdcs<?php echo $ligne; ?>" name="cmdcs<?php echo $ligne; ?>" value="<?php if (isset($bss['qt'])) { echo $bss['qt']; } else { echo 0 ; } ?>" readonly>
								</td>

								<!-- 3:Bouteilles par casier -->
								<td style="display: none;">
									<input type="number" id="btecs<?php echo $ligne; ?>" name="btecs<?php echo $ligne; ?>" value="<?php echo $bss['btpcasier'];?>" readonly>
								</td>

								<!-- 4:Bouteilles commandées -->
								<td>
									<input type="number" id="btecmd<?php echo $ligne; ?>" name="btecmd<?php echo $ligne; ?>" readonly>
								</td>

								<!-- 5:Prix d'achat par casier (FCFA) -->
								<td style="width: 70px">
									<input style="width:70px;" type="number" id="papcs<?php echo $ligne; ?>" name="papcs<?php echo $ligne; ?>" value="<?php if (isset($bss['prx'])) { echo $bss['prx']; } else { echo 0 ; } ?>" readonly>
								</td>

								<!-- 6:Prix d'achat par bouteille (FCFA) -->
								<td style="width: 70px;">
									<input style="width: 70px" type="number" step="any" id="papbt<?php echo $ligne; ?>" name="papbt<?php echo $ligne; ?>" value="0" readonly>
									<input style="width: 70px" type="number" step="any" id="papbte<?php echo $ligne; ?>" name="papbte<?php echo $ligne; ?>" value="<?php echo $bss['pachat']; ?>" readonly>
									<input style="width: 70px" type="number" step="any" id="papbtes<?php echo $ligne; ?>" name="papbtes<?php echo $ligne; ?>" value="<?php echo $bss['pachats']; ?>" readonly>
								</td>

								<!-- 7:Estimation commande (FCFA) -->
								<td style="width: 100px">
									<input style="width: 100px" type="number" id="estcmd<?php echo $ligne; ?>" name="estcmd<?php echo $ligne; ?>" value="<?php if (isset($bss['mt'])) { echo $bss['mt']; } else { echo 0 ; } ?>" readonly>
								</td>

								<!-- 8:Stock initial -->
								<td style="width: 60px">
									<input style="width: 60px" type="number" id="stcin<?php echo $ligne; ?>" name="stcin<?php echo $ligne; ?>" value="<?php echo $bss['stkini'] + $bss['stkinit']  ; ?>" readonly>
									<input style="width: 60px" type="number" id="stcint<?php echo $ligne; ?>" name="stcint<?php echo $ligne; ?>" value="<?php echo $bss['stkini'] ; ?>" readonly>
									<input style="width: 60px;" type="number" id="stcinit<?php echo $ligne; ?>" name="stcinit<?php echo $ligne; ?>" value="<?php echo $bss['stkinit']  ; ?>" readonly>
								</td>

								<!-- 9:Nouveau stock -->
								<td style="width: 60px">
									<input style="width: 60px" type="number" id="nvstc<?php echo $ligne; ?>" name="nvstc<?php echo $ligne; ?>" readonly>
								</td>

								<!-- 10:Prix de vente unitaire (FCFA) -->
								<td style="width: 70px">
									<input style="width: 70px" type="number" step="any" id="pdvuni<?php echo $ligne; ?>" name="pdvuni<?php echo $ligne; ?>" value="<?php echo $bss['prix']; ?>" readonly>
								</td>

								<!-- 11:Estimation du nouveau stock (FCFA) -->
								<td style="width: 100px">
									<input style="width: 100px" type="number" id="estnstc<?php echo $ligne; ?>" name="estnstc<?php echo $ligne; ?>" readonly>
								</td>

								<!-- 12:Bouteilles vendues -->
								<td style="width: 60px">
									<input style="width: 60px" type="number" id="bteven<?php echo $ligne; ?>" name="bteven<?php echo $ligne; ?>" value="<?php echo $bss['bouven']; ?>" onkeypress="BloqSubmit();" onchange="calcul();total();venbou();">
								</td>

								<!-- 13:Montant vente -->
								<td style="width: 100px">
									<input style="width: 100px" type="number" id="mttven<?php echo $ligne; ?>" name="mttven<?php echo $ligne; ?>" readonly>
								</td>

								<!-- 14:Bénéfice -->
								<td style="width: 80px">
									<input style="width: 80px" type="number" id="bene<?php echo $ligne; ?>" name="bene<?php echo $ligne; ?>" readonly>
									<input style="width: 80px" type="number" id="mac<?php echo $ligne; ?>" name="mac<?php echo $ligne; ?>" value="<?php echo $bss['mac']; ?>" readonly>
								</td>

								<!-- 15:Stock restant -->
								<td style="width: 60px">
									<input style="width: 60px" type="number" id="stcrst<?php echo $ligne; ?>" name="stcrst<?php echo $ligne; ?>" readonly>
								</td>

								<!-- 16:Stock Physique -->
								<td style="width: 60px">
									<input style="width: 60px" type="number" id="stcpsq<?php echo $ligne; ?>" name="stcpsq<?php echo $ligne; ?>" onchange="calcul();total();mank();">
								</td>

								<!-- 17:Estimation du stock physique (FCFA) -->
								<td style="width: 100px">
									<input style="width: 100px" type="number" id="estsp<?php echo $ligne; ?>" name="estsp<?php echo $ligne; ?>" readonly>
								</td>

								<!-- 18:Stock manquant -->
								<td style="width: 60px">
									<input style="width: 60px" type="number" id="stcman<?php echo $ligne; ?>" name="stcman<?php echo $ligne; ?>" readonly>
								</td>

								<!-- 19:Estimation du stock manquant (FCFA) -->
								<td style="width: 100px">
									<input style="width: 100px" type="number" id="estsm<?php echo $ligne; ?>" name="estsm<?php echo $ligne; ?>" readonly>
								</td>

							</tr>
							<?php
								++$ligne;
							}
							?>		
						</tbody>
						<tfoot id="total" name="total">
							<tr style="background-color: #0563af; color: white;">
								<td>TOTAUX</td> <!-- 1 -->
								
								<!-- 2 -->
								<td>
									<input type="number" name="tocom" id="tocom" readonly>
								</td>

								<td style="background-color: black;display: none;"></td> <!-- 3 -->
								
								<!-- 4 -->
								<td>
									<input type="number" name="tobou" id="tobou" readonly>
								</td>

								<td style="background-color: black;"></td> <!-- 5 -->
								<td style="background-color: black;"></td> <!-- 6 -->
								
								<!-- 7 -->
								<td>
									<input type="number" name="toesc" id="toesc" readonly>
								</td>

								<!-- 8 -->
								<td>
									<input type="number" name="toski" id="toski" readonly>
								</td>
								
								<!-- 9 -->
								<td>
									<input type="number" name="tonsk" id="tonsk" readonly>
								</td>

								<td style="background-color: black;"></td> <!-- 10 -->
								
								<!-- 11 -->
								<td>
									<input type="number" name="toens" id="toens" readonly>
								</td>
								
								<!-- 12 -->
								<td>
									<input type="number" name="tobtv" id="tobtv" readonly>
								</td>
								
								<!-- 13 -->
								<td>
									<input type="number" name="tomtv" id="tomtv" readonly>
								</td>

								<!-- 14 -->
								<td id="sous">
									<input type="number" name="toben" id="toben" readonly>
								</td>

								<!-- 15 -->
								<td>
									<input type="number" name="toskr" id="toskr" readonly>
								</td>
								
								<!-- 16 -->
								<td id="souse">
									<input type="number" name="toskp" id="toskp" readonly>
								</td>

								<!-- 17 -->
								<td id="souses">
									<input type="number" name="toesp" id="toesp" readonly>
								</td>
								
								<!-- 18 -->
								<td id="sousese">
									<input type="number" name="toskm" id="toskm" readonly>
								</td>

								<!-- 19 -->
								<td id="souseses">
									<input type="number" name="toesm" id="toesm" readonly>
								</td>
							</tr>
						</tfoot>
					</table>
				</div>

				<div id="autre">
					<?php
						$breh = $bdd->query("SELECT * FROM depense");

						while ($don = $breh->fetch()) {
					?>
						<span style="display: none;">
							<input type="number" name="idDep" id="idDep" value="<?php echo $don["idDep"]; ?>" readonly>
						</span>

						<table id="one">
							<tr>
								<td>
									Dépenses (FCFA) : 
								</td>
								<td data-label="Dépenses (FCFA) :">
									<input type="number" name="dpnx" value="<?php if(isset($don["dpnx"])) { echo $don["dpnx"]; } else { echo 0 ; } ?>" id="dpenx" onchange="depense();">
								</td>
							</tr>
							<tr>
								<td>
									Détails des<br>dépenses : 
								</td>
								<td data-label="Détails des dépenses : ">
									<textarea name="detail" id="detail" rows="10" cols="30" autocomplete="off"><?php if(isset($don["detail"])) { echo $don["detail"]; } else { echo " " ; } ?></textarea>
								</td>
							</tr>
						</table>

						<table id="two">
							<tr>
								<td>
									Crédits (FCFA) : 
								</td>
								<td data-label="Crédits (FCFA) : ">
									<input type="number" name="credit" value="<?php if(isset($don["credit"])) { echo $don["credit"]; } else { echo 0 ; } ?>" id="credit" onchange="depense();">
								</td>
							</tr>
							<tr>
								<td>
									Détails des<br>crédits :
								</td>
								<td data-label="Détails des crédits : ">
									<textarea name="details" id="details" rows="10" cols="30" autocomplete="off"><?php if(isset($don["details"])) { echo $don["details"]; } else { echo " " ; } ?></textarea>
								</td>
							</tr>
						</table>

						<table id="three">
							<tr>
								<td>
									Autres (FCFA) : 
								</td>
								<td data-label="Autres (FCFA) : ">
									<input type="number" name="autres" value="<?php if(isset($don["autres"])) { echo $don["autres"]; } else { echo 0 ; } ?>" id="autres" onchange="depense();">
								</td>
							</tr>
							<tr>
								<td>
									Détails des<br>autres :
								</td>
								<td data-label="Détails des autres : ">
									<textarea name="detailss" id="detailss" rows="10" cols="30" autocomplete="off"><?php if(isset($don["detailss"])) { echo $don["detailss"]; } else { echo " " ; } ?></textarea>
								</td>
							</tr>
						</table>
					<?php
						}
					?>	
				</div>

				<div id="bef"></div>

				<div id="xender" name="xender"><br>
					<span name="save" id="save">Enregistrer</span>
				</div>	
				<div id="dbs">
					<table id="recap">
						<tr>
							<th style="text-align: center; font-weight: bold;">BILAN FINANCIER</th>
						</tr>
						<tr>
							<td style="text-align: right;">ESTIMATION DES COMMANDES (FCFA) :</td>
							<td>
								<input type="number" name="estcom" id="estcom" style="width: 100px;border: none;" readonly>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">ESTIMATION DU STOCK AVANT POINT (FCFA) :</td>
							<td>
								<input type="number" name="eststc" id="eststc" style="width: 100px;border: none;" readonly>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">MONTANT VENTE (FCFA) :</td>
							<td>
								<input type="number" name="mttvte" id="mttvte" style="width: 100px;border: none;" readonly>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">BENEFICE (FCFA) :</td>
							<td>
								<input type="number" name="bnefix" id="bnefix" style="width: 100px;border: none;color: red;" readonly>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">MONTANT RECU (FCFA) :</td>
							<td style="width: 100px;"><input type="number" id="mttrecu" name="mttrecu" onchange="ekars();" style="width: 100px;border: none;text-align: center;font-family: sans-serif; font-weight: bold; font-size: 16px;color: red;"></td>
						</tr>
						<tr>
							<td style="text-align: right;">ECART MONTANTS (Vente/Reçu) (FCFA) :</td>
							<td>
								<input type="number" name="eka" id="eka" style="width: 100px;border: none;text-align: center;font-family: sans-serif; font-weight: bold; font-size: 16px;color: red;" value="0" readonly>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">DEPENSES (FCFA) :</td>
							<td>
								<input type="number" name="depenx" id="depenx" style="width: 100px;border: none;" readonly>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">CREDIT (FCFA) :</td>
							<td style="width: 100px;"><input type="number" id="cred" name="cred" style="width: 100px;border: none;text-align: center;font-family: sans-serif; font-weight: bold; font-size: 16px;" readonly></td>
						</tr>
						<tr>
							<td style="text-align: right;">AUTRES (FCFA) :</td>
							<td style="width: 100px;"><input type="number" id="otre" name="otre" style="width: 100px;border: none;text-align: center;font-family: sans-serif; font-weight: bold; font-size: 16px;" readonly></td>
						</tr>
						<tr>
							<td style="text-align: right;">ESTIMATION DU STOCK MANQUANT (FCFA) :</td>
							<td style="width: 100px;"><input type="number" id="manque" name="manque" style="width: 100px;border: none;text-align: center;font-family: sans-serif; font-weight: bold; font-size: 16px;" readonly></td>
						</tr>
						<tr>
							<td style="text-align: right;">ESTIMATION DU STOCK APRES POINT (FCFA) :</td>
							<td>
								<input type="number" name="estsap" id="estsap" style="width: 100px;border: none;" readonly>
							</td>
						</tr>
						
					</table>

					<table id="stck">
						<tr>
							<th style="text-align: center; font-weight: bold;">STOCKS</th>
						</tr>
						<tr>
							<td style="text-align: right;">BOUTEILLES EN STOCK AVANT COMMANDES :</td>
							<td>
								<input type="number" name="btstk" id="btstk" style="width: 100px;border: none;" readonly>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">CASIERS COMMANDÉS :</td>
							<td>
								<input type="number" name="cascom" id="cascom" style="width: 100px;border: none;" readonly>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">BOUTEILLES EN STOCK APRES COMMANDES :</td>
							<td>
								<input type="number" name="btstck" id="btstck" style="width: 100px;border: none;" readonly>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">BOUTEILLES VENDUES :</td>
							<td>
								<input type="number" name="btvend" id="btvend" style="width: 100px;border: none;" readonly>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">STOCK RESTANT (BOUTEILLES) :</td>
							<td>
								<input type="number" name="stcres" id="stcres" style="width: 100px;border: none;" readonly>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">STOCK PHYSIQUE (BOUTEILLES) :</td>
							<td>
								<input type="number" name="stcphy" id="stcphy" style="width: 100px;border: none;" readonly>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">STOCK MANQUANT (BOUTEILLES) :</td>
							<td>
								<input type="number" name="stcman" id="stcman" style="width: 100px;border: none;" readonly>
							</td>
						</tr>
					</table>

					<?php if (isset($type) && $type == "controleur" OR $type == "superadmin") { ?>
						<table id="pers">
							<tr>
								<th style="text-align: center; font-weight: bold;">PERSONNEL</th>
							</tr>
							<tr>
								<td style="text-align: right;">NOM DU GERANT :</td>
								<td>
									<select id="gernt" name="gernt">
										<option value=""></option>
									<?php
										$sql = $bdd->query("SELECT * FROM login WHERE type = 'gerant'");

										while ($done = $sql->fetch()) {
									?>
										<option value="<?php echo $done["name"]; ?>"><?php echo $done["name"]; ?></option>
									<?php
										}
									?>	
									</select>
								</td>
							</tr>
							<tr>
								<td style="text-align: right;">NOM DU CONTROLEUR :</td>
								<td>
									<?php
										$sqls = $bdd->query("SELECT * FROM login WHERE username = '$sender'");

										while ($dones= $sqls->fetch()) {
									?>
									<input type="text" name="control" id="control" style="width: 100px;border: none;" value="<?php echo $dones["name"] ; ?>" readonly>
									<?php
										}
									?>
								</td>
							</tr>
						</table>


						<br><br>
						<div id="pnt">
							<input type="submit" name="envoi" id="envoi" onclick="return val();" value="Enregistrer le point">
						</div>
					<?php } ?>	
				</div>	
			</form>		
			<br>
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

	<script type="text/javascript">
		

		// Déclaration du tableau
		var tableau = document.getElementById("idTable");

		function calcul() {

			for (var i = 1; i < tableau.rows.length-1; i++) {

				// Bouteilles commandées = Commandes (casier) x Bouteilles par casier
				var btc;
				btc = tableau.rows[i].cells[1].children[0].value * tableau.rows[i].cells[2].children[0].value;
				tableau.rows[i].cells[3].children[0].value = btc;

				// Prix d'achat par bouteille = Prix d'achat par casier / Bouteilles par casier
				var pab;
				pab = tableau.rows[i].cells[4].children[0].value / tableau.rows[i].cells[2].children[0].value;
				tableau.rows[i].cells[5].children[0].value = pab.toFixed(3);

				// Nouveau stock = Bouteilles commandées + Stock initial
				var nst;
				nst = parseInt(tableau.rows[i].cells[3].children[0].value) + parseInt(tableau.rows[i].cells[7].children[0].value);
				tableau.rows[i].cells[8].children[0].value = nst;

				// Estimation du nouveau stock = Nouveau stock x Prix de vente unitaire
				var ens;
				ens = tableau.rows[i].cells[8].children[0].value * tableau.rows[i].cells[9].children[0].value;
				tableau.rows[i].cells[10].children[0].value = parseInt(ens);

				// Montant vente = Prix de vente unitaire x Bouteilles vendues
				var mtv;
				mtv = tableau.rows[i].cells[9].children[0].value * tableau.rows[i].cells[11].children[0].value;
				tableau.rows[i].cells[12].children[0].value = parseInt(mtv);

				// Bénéfice = Montant vente - Montant d'achat
				var benef;
				benef = tableau.rows[i].cells[12].children[0].value - tableau.rows[i].cells[13].children[1].value;
				tableau.rows[i].cells[13].children[0].value = parseInt(benef);

				// Stock restant = Nouveau stock - Bouteilles vendues
				var str;
				str = parseInt(tableau.rows[i].cells[8].children[0].value) - tableau.rows[i].cells[11].children[0].value;
				tableau.rows[i].cells[14].children[0].value = parseInt(str);

				// Estimation du stock physique = Stock physique * Prix de vente unitaire
				var stphy;
				stphy = tableau.rows[i].cells[15].children[0].value * tableau.rows[i].cells[9].children[0].value;
				tableau.rows[i].cells[16].children[0].value = parseInt(stphy);	
			}

		}

		function mank() {
			for (var t = 1; t < tableau.rows.length-1; t++) {
				// Stock manquant = Stock restant - Stock physique
				var stmq;
				stmq = parseInt(tableau.rows[t].cells[14].children[0].value) - tableau.rows[t].cells[15].children[0].value
				tableau.rows[t].cells[17].children[0].value = parseInt(stmq);

				// Estimation du stock manquant = Stock manquant * Prix de vente unitaire
				var esmq;
				esmq = tableau.rows[t].cells[17].children[0].value * tableau.rows[t].cells[9].children[0].value;
				tableau.rows[t].cells[18].children[0].value = parseInt(esmq);
			}

			// Total des Stocks Manquants
			var toskm = document.getElementById("toskm");

			for (var a = 1; a < tableau.rows.length-1; a++) {

				if (a <= 1) {
					toskm.value = parseInt(tableau.rows[a].cells[17].children[0].value);
				} else if (a > 1) {
					toskm.value = parseInt(toskm.value) + parseInt(tableau.rows[a].cells[17].children[0].value);
				} else {
					toskm.value = parseInt(toskm.value);
				}

				var stcman = document.getElementById("stcman");
				stcman.value = parseInt(toskm.value);
			}

			// Total des Estimations des Stocks Manquants
			var toesm = document.getElementById("toesm");

			for (var a = 1; a < tableau.rows.length-1; a++) {

				if (a <= 1) {
					toesm.value = parseInt(tableau.rows[a].cells[18].children[0].value);
				} else if (a > 1) {
					toesm.value = parseInt(toesm.value) + parseInt(tableau.rows[a].cells[18].children[0].value);
				} else {
					toesm.value = parseInt(toesm.value);
				}

				var manque = document.getElementById("manque");
				manque.value = parseInt(toesm.value);
			}

		}

		function total() {

			// Total des Casiers commandés
			var tocom = document.getElementById("tocom");

			for (var a = 1; a < tableau.rows.length-1; a++) {

				if (a <= 1) {
					tocom.value = parseInt(tableau.rows[a].cells[1].children[0].value);
				} else if (a > 1) {
					tocom.value = parseInt(tocom.value) + parseInt(tableau.rows[a].cells[1].children[0].value);
				} else {
					tocom.value = parseInt(tocom.value);
				}

				var cascom = document.getElementById("cascom");
				cascom.value = parseInt(tocom.value);
			}

			// Total des Bouteilles commandées
			var tobou = document.getElementById("tobou");

			for (var a = 1; a < tableau.rows.length-1; a++) {

				if (a <= 1) {
					tobou.value = parseInt(tableau.rows[a].cells[3].children[0].value);
				} else if (a > 1) {
					tobou.value = parseInt(tobou.value) + parseInt(tableau.rows[a].cells[3].children[0].value);
				} else {
					tobou.value = parseInt(tobou.value);
				}
			}

			// Total des Estimations des commandes
			var toesc = document.getElementById("toesc");

			for (var a = 1; a < tableau.rows.length-1; a++) {

				if (a <= 1) {
					toesc.value = parseInt(tableau.rows[a].cells[6].children[0].value);
				} else if (a > 1) {
					toesc.value = parseInt(toesc.value) + parseInt(tableau.rows[a].cells[6].children[0].value);
				} else {
					toesc.value = parseInt(toesc.value);
				}

				var estcom = document.getElementById("estcom");
				estcom.value = parseInt(toesc.value);
			}

			// Total des Stocks Initiaux
			var toski = document.getElementById("toski");

			for (var a = 1; a < tableau.rows.length-1; a++) {

				if (a <= 1) {
					toski.value = parseInt(tableau.rows[a].cells[7].children[0].value);
				} else if (a > 1) {
					toski.value = parseInt(toski.value) + parseInt(tableau.rows[a].cells[7].children[0].value);
				} else {
					toski.value = parseInt(toski.value);
				}

				var btstk = document.getElementById("btstk");
				btstk.value = parseInt(toski.value);
			}

			// Total des Nouveaux Stocks
			var tonsk = document.getElementById("tonsk");

			for (var a = 1; a < tableau.rows.length-1; a++) {

				if (a <= 1) {
					tonsk.value = parseInt(tableau.rows[a].cells[8].children[0].value);
				} else if (a > 1) {
					tonsk.value = parseInt(tonsk.value) + parseInt(tableau.rows[a].cells[8].children[0].value);
				} else {
					tonsk.value = parseInt(tonsk.value);
				}

				var btstck = document.getElementById("btstck");
				btstck.value = parseInt(tonsk.value);
			}

			// Total des Estimations des Nouveaux Stocks
			var toens = document.getElementById("toens");

			for (var a = 1; a < tableau.rows.length-1; a++) {

				if (a <= 1) {
					toens.value = parseInt(tableau.rows[a].cells[10].children[0].value);
				} else if (a > 1) {
					toens.value = parseInt(toens.value) + parseInt(tableau.rows[a].cells[10].children[0].value);
				} else {
					toens.value = parseInt(toens.value);
				}

				var eststc = document.getElementById("eststc");
				eststc.value = parseInt(toens.value);
			}

			// Total des Bouteilles vendues
			var tobtv = document.getElementById("tobtv");

			for (var a = 1; a < tableau.rows.length-1; a++) {

				if (a <= 1) {
					tobtv.value = parseInt(tableau.rows[a].cells[11].children[0].value);
				} else if (a > 1) {
					tobtv.value = parseInt(tobtv.value) + parseInt(tableau.rows[a].cells[11].children[0].value);
				} else {
					tobtv.value = parseInt(tobtv.value);
				}

				var btvend = document.getElementById("btvend");
				btvend.value = parseInt(tobtv.value);
			}

			// Total des Montant vente
			var tomtv = document.getElementById("tomtv");

			for (var a = 1; a < tableau.rows.length-1; a++) {

				if (a <= 1) {
					tomtv.value = parseInt(tableau.rows[a].cells[12].children[0].value);
				} else if (a > 1) {
					tomtv.value = parseInt(tomtv.value) + parseInt(tableau.rows[a].cells[12].children[0].value);
				} else {
					tomtv.value = parseInt(tomtv.value);
				}

				var mttvte = document.getElementById("mttvte");
				mttvte.value = parseInt(tomtv.value);
			}

			// Total des Bénéfices
			var toben = document.getElementById("toben");

			for (var a = 1; a < tableau.rows.length-1; a++) {

				if (a <= 1) {
					toben.value = parseInt(tableau.rows[a].cells[13].children[0].value);
				} else if (a > 1) {
					toben.value = parseInt(toben.value) + parseInt(tableau.rows[a].cells[13].children[0].value);
				} else {
					toben.value = parseInt(toben.value);
				}

				var bnefix = document.getElementById("bnefix");
				bnefix.value = parseInt(toben.value);
			}

			// Total des Stocks Restants
			var toskr = document.getElementById("toskr");

			for (var a = 1; a < tableau.rows.length-1; a++) {

				if (a <= 1) {
					toskr.value = parseInt(tableau.rows[a].cells[14].children[0].value);
				} else if (a > 1) {
					toskr.value = parseInt(toskr.value) + parseInt(tableau.rows[a].cells[14].children[0].value);
				} else {
					toskr.value = parseInt(toskr.value);
				}

				var stcres = document.getElementById("stcres");
				stcres.value = parseInt(toskr.value);
			}

			// Total des Stocks Physiques
			
			for (var a = 1; a < tableau.rows.length-1; a++) {
				
				var toskp = document.getElementById("toskp");

				if (a <= 1) {
					toskp.value = parseInt(tableau.rows[a].cells[15].children[0].value);
				} else if (a > 1) {
					toskp.value = parseInt(toskp.value) + parseInt(tableau.rows[a].cells[15].children[0].value);
				} else {
					toskp.value = parseInt(toskp.value);
				}

				var stcphy = document.getElementById("stcphy");
				stcphy.value = parseInt(toskp.value);
			}	

			// Total des Estimations des Stocks Physiques
			var toesp = document.getElementById("toesp");

			for (var a = 1; a < tableau.rows.length-1; a++) {

				if (a <= 1) {
					toesp.value = parseInt(tableau.rows[a].cells[16].children[0].value);
				} else if (a > 1) {
					toesp.value = parseInt(toesp.value) + parseInt(tableau.rows[a].cells[16].children[0].value);
				} else {
					toesp.value = parseInt(toesp.value);
				}

				var estsap = document.getElementById("estsap");
				estsap.value = parseInt(toesp.value);
			}

			var dpenx = document.getElementById("dpenx");
			var depenx = document.getElementById("depenx");
			depenx.value = dpenx.value;

			var credit = document.getElementById("credit");
			var cred = document.getElementById("cred");
			cred.value = credit.value;

			var autres = document.getElementById("autres");
			var otre = document.getElementById("otre");
			otre.value = autres.value;
		}

		function ekars() {
			var eka = document.getElementById("eka");

			var era;
			era = mttvte.value - mttrecu.value;
			eka.value = era;
		}

		function depense() {
			var dpenx = document.getElementById("dpenx");
			var depenx = document.getElementById("depenx");
			depenx.value = dpenx.value;

			var credit = document.getElementById("credit");
			var cred = document.getElementById("cred");
			cred.value = credit.value;

			var autres = document.getElementById("autres");
			var otre = document.getElementById("otre");
			otre.value = autres.value;
		}

		function cache() {
			var dbs = document.getElementById("dbs");

			// Titre du tableau
			var titre = document.getElementById("titre");
			var titres = document.getElementById("titres");
			var titrese = document.getElementById("titrese");
			var titreses = document.getElementById("titreses");
			var titresese = document.getElementById("titresese");

			// Bas du tableau
			var sous = document.getElementById("sous");
			var souse = document.getElementById("souse");
			var souses = document.getElementById("souses");
			var sousese = document.getElementById("sousese");
			var souseses = document.getElementById("souseses");

			var show = "<?php echo $type; ?>";

			if (show == "gerant") {
				dbs.style.display = 'none';

				titre.style.display = 'none';
				titres.style.display = 'none';
				titrese.style.display = 'none';
				titreses.style.display = 'none';
				titresese.style.display = 'none';

				sous.style.display = 'none';
				souse.style.display = 'none';
				souses.style.display = 'none';
				sousese.style.display = 'none';
				souseses.style.display = 'none';

				for (var a = 1; a < tableau.rows.length-1; a++) {
					tableau.rows[a].cells[13].style.display = 'none';

					tableau.rows[a].cells[15].style.display = 'none';
					tableau.rows[a].cells[15].children[0].style.display = 'none';

					tableau.rows[a].cells[16].style.display = 'none';

					tableau.rows[a].cells[17].style.display = 'none';

					tableau.rows[a].cells[18].style.display = 'none';
				}
			}

			var dpenx = document.getElementById("dpenx");
			var credit = document.getElementById("credit");
			var autres = document.getElementById("autres");

			var detail = document.getElementById("detail");
			var details = document.getElementById("details");
			var detailss = document.getElementById("detailss");
			var xender = document.getElementById("xender");

			if (show == "controleur" || show == "proprietaire") {
				for (var a = 1; a < tableau.rows.length-1; a++) {
					tableau.rows[a].cells[11].children[0].setAttribute("readonly","readonly");
				}

				dpenx.setAttribute("readonly","readonly");
				credit.setAttribute("readonly","readonly");
				autres.setAttribute("readonly","readonly");

				detail.setAttribute("readonly","readonly");
				details.setAttribute("readonly","readonly");
				detailss.setAttribute("readonly","readonly");

				xender.style.display = 'none';
			}

			var gernt = document.getElementById("gernt");
			var mttrecu = document.getElementById("mttrecu");
			var manque = document.getElementById("manque");
			var pnt = document.getElementById("pnt");

			if (show == "proprietaire") {
				for (var b = 1; b < tableau.rows.length-1; b++) {
					tableau.rows[b].cells[15].children[0].setAttribute("readonly","readonly");
				}

				gernt.setAttribute("readonly","readonly");
				mttrecu.setAttribute("readonly","readonly");
				manque.setAttribute("readonly","readonly");

				pnt.style.display = 'none';
			}
		}

		function venbou() {
			for (var s = 1; s < tableau.rows.length-1; s++) {

				if (tableau.rows[s].cells[11].children[0].value > tableau.rows[s].cells[8].children[0].value) {
					alert("Le nombres de bouteilles vendues ne doit pas être supérieur au nombres de bouteilles en stock !");
					tableau.rows[s].cells[11].children[0].focus();
				}
			}
		}

		function val() {
			for (var r = 1; r < tableau.rows.length-1; r++) {
				if (tableau.rows[r].cells[11].children[0].value > tableau.rows[r].cells[8].children[0].value) {
					alert("Le nombres de bouteilles vendues ne doit pas être supérieur au nombres de bouteilles en stock !");
					tableau.rows[r].cells[11].children[0].focus();
					return false;
				}

				if (tableau.rows[r].cells[15].children[0].value == "") {
					alert("Veuillez entrer le stock physique !");
					return false;
				}

				if (tableau.rows[r].cells[17].children[0].value < 0) {
					alert("Le stock physique ne doit pas être supérieur au stock restant !");
					alert("- Vérifiez que toutes les commandes ont été correctement saisies !\n- S'assurer d'avoir saisie toutes les bouteilles vendues !\n- Vérifiez que le stock ne contient pas des bouteilles déjà achetées par le client. Si tel est le cas, déduire ces bouteilles du stock physique");
					return false;
				}
			}

			if ((frm.dpenx.value > 0) && (frm.detail.value == " ")) {
				alert("Veuillez saisir les détails des dépenses !");
				frm.detail.focus();
				return false;
			}

			if ((frm.credit.value > 0) && (frm.details.value == " ")) {
				alert("Veuillez saisir les détails des crédits !");
				frm.details.focus();
				return false;
			}

			if ((frm.autres.value != 0) && (frm.detailss.value == " ")) {
				alert("Veuillez saisir les détails des autres !");
				frm.detailss.focus();
				return false;
			}

			if (frm.gernt.value == "") {
				alert("Veuillez choisir le nom du gérant !");
				frm.gernt.focus();
				return false;
			}

			if (frm.mttrecu.value == "") {
				alert("Veillez entrer le montant reçu !");
				frm.mttrecu.focus();
				return false;
			}

			return true;
		}

		function BloqSubmit() {  
			if (window.event.type == "keypress" & window.event.keyCode == 13) {
				return !(window.event.type == "keypress" & window.event.keyCode == 13); 
			}
		}	
	</script>
</body>
</html>