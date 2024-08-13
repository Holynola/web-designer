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

	
	if(isset($_POST['ajouter']))
	{
		
		$image = $_POST['image'];
		$design = $_POST['design'];
		$prix = $_POST['prix'];
		$btpcasier = $_POST['btpcasier'];
		$stkini = 0;
		$stkinit = 0;
		$pachat = 0;
		$pachats = 0;
		$bouven = 0;
		$mac = 0;

		$req = $bdd-> prepare('INSERT INTO boisson (design, prix, image, btpcasier, stkini, stkinit, pachat, pachats, bouven, mac) VALUES (:design, :prix, :image, :btpcasier, :stkini, :stkini, :pachat, :pachats, :bouven, :mac)');
		$req->execute(array(
			'design' => $design,
			'prix' => $prix,
			'btpcasier' => $btpcasier,
			'stkini' => $stkini,
			'stkinit' => $stkinit,
			'pachat' => $pachat,
			'pachats' => $pachats,
			'bouven' => $bouven,
			'mac' => $mac,
			'image' => $image));

		$res = $bdd-> prepare('INSERT INTO drink (designD, prixD, imageD, btpcasierD) VALUES (:designD, :prixD, :imageD, :btpcasierD)');
		$res->execute(array(
			'designD' => $design,
			'prixD' => $prix,
			'btpcasierD' => $btpcasier,
			'imageD' => $image));

		header("location:boissons.php");
	}

	if(isset($_POST['retour'])) {
		header("location:boissons.php");
	}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width" />
	<meta name="author" content="Holynola" >
	<title>Ajouter une boisson</title>
	<link rel="shortcut icon" href="../img/favicon.ico">
	<link rel="stylesheet" type="text/css" href="../style/ajb.css">
	<script src="jquery-3.3.1.min.js"></script>
</head>
<script type="text/javascript">
	function val() {

		if (abs.image.value == "") {
			alert("Veillez choisir l'image de la boisson");
			return false;
		} else {

			if (abs.design.value == "") {
				alert("Veillez saisir le nom de la boisson");
				abs.design.focus();
				return false;
			}

			if (abs.prix.value == "") {
				alert("Veillez entrer le prix de la boisson");
				abs.prix.focus();
				return false;
			}

			if (abs.btpcasier.value == "") {
				alert("Veillez entrer le nombre de bouteilles par casier");
				abs.btpcasier.focus();
				return false;
			}
		}

		return true;

	}

	function bol() {
		return false;
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
		
		<h1>Ajouter une Boisson</h1>
		
		<div id="cant" align="center">
			<p>Image de la boisson :</p>
			<button id="btn" onclick="window.document.location.href='aji.php';">Choisir une image</button>
		</div>

		<?php
			if (isset($_GET['pid'])) {
				$info = $_GET['pid'];
			}
		?>

		<form method="post" action="ajb.php" id="abs" enctype="multipart/form-data">
			<input type="text" name="image" id="image" value="<?php if(isset($info)) { echo $info; } ?>" readonly>
			
			<p>Nom de la boisson : </p>
			<input type="text" name="design" id="design" size="30" autocomplete="off"/>

			<p>Prix de la boisson : </p>
			<input type ="number" step="any" name="prix" id="prix">
			
			<p>Nombre de bouteilles par casier : </p>
			<input type ="number" name="btpcasier" id="btpcasier">

			<input type="submit" name="ajouter" onclick="return val();" value="Ajouter">
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