<?php
	session_start();

	include('dbConf.php');

	if (isset($_SESSION["username"])) {
		$pseudo = $_SESSION["username"];
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
	} else {
		header("location:../index.php");
	}

	if(isset($_POST['sent'])) {

		$name = $_POST['name'];
		$username = $_POST['username'];
		$password = sha1($_POST['password']);
		$type = $_POST['type'];
		$register = $_POST['register'];

		$req = $bdd->prepare('INSERT INTO login (name, username, password, type, register) VALUES (:name, :username, :password, :type, :register)');
		$req->execute(array(
			'name' => $name,
			'username' => $username,
			'password' => $password,
			'type' => $type,
			'register' => $register));

		header("location:users.php");
	}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="author" content="Holynola">
	<title>Ajouter un utilisateur</title>
	<link rel="shortcut icon" href="../img/favicon.ico">
	<link rel="stylesheet" type="text/css" href="../style/send.css">
	<script src="jquery-3.3.1.min.js"></script>
</head>
<script type="text/javascript">
	function val() {
		if (ajout.password.value == "") {
			alert("Veillez saisir le mot de passe");
			ajout.password.focus();
			return false;
		}

		if (ajout.confpass.value == "") {
			alert("Veillez confirmer votre mot de passe");
			ajout.confpass.focus();
			return false;
		}

		if (ajout.confpass.value != ajout.password.value) {
			alert("Mots de passe différents !");
			ajout.confpass.focus();
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

	<form method="post" id="ajout" name="ajout" action="send.php">
		<h2 id="titre">Ajouter un utilisateur</h2>
		<p>Nom :</p>
		<input type="text" name="name" id="name" autocomplete="off" required>
		<p>Identifiant :</p>
		<input type="text" name="username" id="username" autocomplete="off" style="text-transform:lowercase;" required>
		<p>Mot de passe :</p>
		<input type="password" name="password" id="password" autocomplete="off">
		<p>Confirmation du Mot de passe :</p>
		<input type="password" name="confpass" id="confpass" autocomplete="off">
		<p>Type d'utilisateur :</p>
		<select id="type" name="type" required>
			<option></option>
			<option value="controleur">Contrôleur</option>
			<option value="gerant">Gérant</option>
			<option value="proprietaire">Propriétaire</option>
		</select>
		<p>Enregistré par :</p>
		<?php
			$sqls = $bdd->query("SELECT * FROM login WHERE username = '$pseudo'");

			while ($dones= $sqls->fetch()) {
		?>
		<input type="text" name="register" id="register" value="<?php echo $dones["name"]; ?>" readonly>
		<?php
			}
		?>	
		<br>
		<input type="submit" name="sent" onclick="return val();" id="sent" value="Enregistrer">
	</form>

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