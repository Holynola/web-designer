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
	<meta name="viewport" content="width=device-width" />
	<meta name="author" content="Holynola" >
	<title>Boissons</title>
	<link rel="shortcut icon" href="../img/favicon.ico">
	<link rel="stylesheet" type="text/css" href="../style/aji.css">
	<script src="jquery-3.3.1.min.js"></script>
</head>
<body>
	<main>

		<div align="center">
			<button onclick="window.document.location.href='ajb.php';">Retour</button>
		</div>	

		<h1>Choississez l'image de la boisson à ajouter</h1>

		<?php
			$dir = glob('boisson/{*.jpg, *.png}', GLOB_BRACE);

			foreach ($dir as $value) {
				?>
				<div class="content">
					<a href="ajb.php?pid=<?=$value?>" style="text-decoration: none; color: black;">
						<img src="<?php echo $value; ?>" alt="<?php echo $value; ?>">
						<span>
							<?php
								$domain = strstr($value, '/');
								echo $domain;
							?>
						</span>
					</a>	
				</div>	
				<?php
			}
		?>
	</main>
</body>
</html>