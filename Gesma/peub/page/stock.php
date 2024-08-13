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

	$wrapm = "display: block;" ;

	// Mois
	$_sltmois = date('m-Y');
	if (isset($_POST['selct2'])) {
		$_sltmois = $_POST['selct2'];
	}

	// Année
	$_sltannee = date('Y');
	if (isset($_POST['selct3'])) {
		$_sltannee = $_POST['selct3'];
	}
	
	// Par Mois
	if (isset($_POST['selct1']) AND $_POST['selct1'] == 'mois') {
		$_POST['selct1'] = 'Par Mois';
		$slctIV = "display: block;" ;
		$slctV = "display: none;" ;
		$wrapm = "display: block;" ;
		$wrapa = "display: none;" ;
	}
	
	// Par An
	if (isset($_POST['selct1']) AND $_POST['selct1'] == 'an') {
		$_POST['selct1'] = 'Par An';
		$slctIV = "display: none;" ;
		$slctV = "display: block;" ;
		$wrapm = "display: none;" ;
		$wrapa = "display: block;" ;
	}
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="author" content="Holynola">
		<title>Stocks</title>
		<link rel="shortcut icon" href="../img/favicon.ico">
		<link rel="stylesheet" type="text/css" href="../style/stock.css">
	</head>
	<script src="jquery-3.3.1.min.js"></script>
	<script type="text/javascript">
		function showMyData() {
			$.ajax ({
				type: "POST",
				url: "showyear.php",
				data: {
					age:$("#selct3").val()
				},
				success: function (data) {
					$("#wrapannee").html(data);
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
			<h1>Stocks</h1>
		<?php if (isset($type) && $type !== "gerant") { ?>	
			<h2></h2>
			
			<hr>

			<form action="stock.php" method="post">

				<select id="selct1" name="selct1" onchange="this.form.submit();"> style = "<?php echo $slctII ; ?>">
					<option>
						<?php
							if (isset($_POST['selct1'])) {
								echo $_POST['selct1'];
							} else {
								echo "Trier";
							}
						?>
					</option>
					<option value="mois">Par Mois</option>
					<option value="an">Par An</option>
				</select>

				<!-- Mois -->
				<select id="selct2" name="selct2" onchange="this.form.submit();" style = "<?php echo $slctIV ; ?>">
					<option><?php echo $_sltmois ; ?></option>
				<?php
					$temp_2 = $bdd->query('SELECT DISTINCT moisStk FROM stock ORDER BY moisStk DESC');

					while ($temps_2 = $temp_2->fetch()) {
				?>	
					<option value="<?php echo $temps_2['moisStk'];?>">
						<?php
							echo $temps_2['moisStk'];
						?>
					</option>
				<?php
					}
				?>		
				</select>

				<!-- Année -->
				<select id="selct3" name="selct3" onchange="showMyData();" style = "<?php echo $slctV ; ?>">
					<option><?php echo "$_sltannee"; ?></option>
				<?php
					$temp_3 = $bdd->query('SELECT DISTINCT anneeStk FROM stock ORDER BY anneeStk DESC');

					while ($temps_3 = $temp_3->fetch()) {
				?>	
					<option value="<?php echo $temps_3['anneeStk'];?>">
						<?php
							echo $temps_3['anneeStk'];
						?>
					</option>
				<?php
					}
				?>		
				</select>

			</form>
			
			<!-- Afficher en fonction du mois -->
			<div class="wrap" id="wrapmois" style = "<?php echo $wrapm ; ?>">
				<?php
					$reponse = $bdd->query("SELECT * FROM stock WHERE moisStk ='$_sltmois'");

					while ($don = $reponse->fetch()) {
				?>	
				<a href="detConso.php?day=<?=$don['dayStk']?>&amp;heure=<?=$don['heureStk']?>" style="text-decoration: none;color: black;">
					<form method="post" enctype="multipart/form-data">
						<li>
							<div class="container">
								<br>
								<table>
									<tr>
										<td style="text-align: right;">Date</td>
										<td> : 
											<span style="color: red;"><?php echo $don['dayStk']; ?></span>
										</td>
									</tr>
									<tr>
										<td style="text-align: right;">Heure</td>
										<td> : 
											<span style="color: red;"><?php echo $don['heureStk']; ?></span>
										</td>
									</tr>
									<tr>
										<td style="text-align: right;">Bouteilles en stock<br>avant commandes</td>
										<td> : 
											<span style="color: red;"><?php echo $don['btsavStk']; ?></span>
										</td>
									</tr>
									<tr>
										<td style="text-align: right;">Casiers commandés</td>
										<td> : 
											<span style="color: red;"><?php echo $don['ccmdStk']; ?></span>
										</td>
									</tr>
									<tr>
										<td style="text-align: right;">Bouteilles en stock<br>après commandes</td>
										<td> : 
											<span style="color: red;"><?php echo $don['btsapStk']; ?></span>
										</td>
									</tr>
									<tr>
										<td style="text-align: right;">Bouteilles vendues</td>
										<td> : 
											<span style="color: red;"><?php echo $don['btevduStk']; ?></span>
										</td>
									</tr>
									<tr>
										<td style="text-align: right;">Stock restant<br>(bouteilles)</td>
										<td> : 
											<span style="color: red;"><?php echo $don['stkresStk']; ?></span>
										</td>
									</tr>
									<tr>
										<td style="text-align: right;">Stock physique<br>(bouteilles)</td>
										<td> : 
											<span style="color: red;"><?php echo $don['stkphyStk']; ?></span>
										</td>
									</tr>
									<tr>
										<td style="text-align: right;">Stock manquant<br>(bouteilles)</td>
										<td> : 
											<span style="color: red;"><?php echo $don['stkmanStk']; ?></span>
										</td>
									</tr>
								</table>	
								<br>
							</div>
						</li>
					</form>
				</a>
				<?php
					}
				?>	
			</div>

			<!-- Afficher en fonction de l'année -->
			<div class="wrap" id="wrapannee" style = "<?php echo $wrapa ; ?>">
				<?php
					$reponse = $bdd->query("SELECT * FROM stock WHERE anneeStk = '$_sltannee'");

					while ($don = $reponse->fetch())
					{
				?>	
				<a href="detConso.php?day=<?=$don['dayStk']?>&amp;heure=<?=$don['heureStk']?>" style="text-decoration: none;color: black;">
					<form method="post" enctype="multipart/form-data">
						<li>
							<div class="container">
								<br>
								<table>
									<tr>
										<td style="text-align: right;">Date</td>
										<td> : 
											<span style="color: red;"><?php echo $don['dayStk']; ?></span>
										</td>
									</tr>
									<tr>
										<td style="text-align: right;">Heure</td>
										<td> : 
											<span style="color: red;"><?php echo $don['heureStk']; ?></span>
										</td>
									</tr>
									<tr>
										<td style="text-align: right;">Bouteilles en stock<br>avant commandes</td>
										<td> : 
											<span style="color: red;"><?php echo $don['btsavStk']; ?></span>
										</td>
									</tr>
									<tr>
										<td style="text-align: right;">Casiers commandés</td>
										<td> : 
											<span style="color: red;"><?php echo $don['ccmdStk']; ?></span>
										</td>
									</tr>
									<tr>
										<td style="text-align: right;">Bouteilles en stock<br>après commandes</td>
										<td> : 
											<span style="color: red;"><?php echo $don['btsapStk']; ?></span>
										</td>
									</tr>
									<tr>
										<td style="text-align: right;">Bouteilles vendues</td>
										<td> : 
											<span style="color: red;"><?php echo $don['btevduStk']; ?></span>
										</td>
									</tr>
									<tr>
										<td style="text-align: right;">Stock restant<br>(bouteilles)</td>
										<td> : 
											<span style="color: red;"><?php echo $don['stkresStk']; ?></span>
										</td>
									</tr>
									<tr>
										<td style="text-align: right;">Stock physique<br>(bouteilles)</td>
										<td> : 
											<span style="color: red;"><?php echo $don['stkphyStk']; ?></span>
										</td>
									</tr>
									<tr>
										<td style="text-align: right;">Stock manquant<br>(bouteilles)</td>
										<td> : 
											<span style="color: red;"><?php echo $don['stkmanStk']; ?></span>
										</td>
									</tr>
								</table>
								<br>
							</div>
						</li>
					</form>
				</a>	
				<?php
				}
				?>	
			</div>
		<?php } ?>	
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