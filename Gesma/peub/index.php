<?php

	session_start();

	date_default_timezone_set("Africa/Abidjan");
	
	$deny = array(""); // Ajouter l'adresse IP à bloquer ici "", ""
	if (in_array ($_SERVER['REMOTE_ADDR'], $deny)) {
	   header("location: error.php");
	   exit();
	}

	$host = "localhost";
	$username = "root";
	$password = "sgl.dev2018";
	$database = "kima";
	$message = "";

	try
	{
		$connect = new PDO("mysql:host=$host; dbname=$database", $username, $password);
		$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		if(isset($_POST["login"]))
		{
			if(empty($_POST["username"]) || empty($_POST["password"]))
			{
				$message = '<label>Veillez saisir votre Identifiant et votre Mot de passe</label>';
			}
			else
			{
				$query = "SELECT * FROM login WHERE username = :username AND password = :password";
				$statement = $connect->prepare($query);
				$statement->execute(
					array (
						'username' => $_POST["username"],
						'password' => sha1($_POST["password"])
					)
				);

				// compteur de nbre de tentative 
				if (!isset($_SESSION['limitation'])) {  
				    $_SESSION['limitation'] = 1;  
				} else {  
				    $_SESSION['limitation'] = $_SESSION['limitation'] + 1;
				}

				$count = $statement->rowCount();
				if($count > 0)
				{
					$logUser = $_POST["username"];
					$jourIn = date('d-m-Y');
					$heurIn = date('H:i:s');

					$bds = $connect->query("SELECT * FROM login WHERE username ='$logUser'");

					while ($bdd = $bds->fetch()) {
						$top = $bdd['type'];

						if ($top != "superadmin") {
							$res = $connect->prepare('INSERT INTO inlog (logUser, jourIn, heurIn) VALUES (:logUser, :jourIn, :heurIn)');

							$res->execute(array(
								'logUser' => $logUser,
								'jourIn' => $jourIn,
								'heurIn' => $heurIn));

							$_SESSION["username"] = $_POST["username"];
							header("location:page/index.php");
						} else {
							$_SESSION["username"] = $_POST["username"];
							header("location:page/index.php");
						}
					}
				}
				else
				{
					$message = '<label>Identifiant ou Mot de passe incorrect</label>';
					if ((isset($_SESSION['limitation'])) && ($_SESSION['limitation'] <= 5)) {}
					elseif ((isset($_SESSION['limitation'])) && ($_SESSION['limitation'] > 5)) {  
				        $_SESSION['limitation'] = 0;
				        header('Location: ind.php');
				    }
					
				}
			}
		}
	}
	catch(PDOException $error)
	{
		$message = $error->getMessage();
	}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="Holynola">
	<title>Maquis Bleu Blanc</title>
	<link rel="shortcut icon" href="img/beer.ico">
	<link rel="stylesheet" href="style/index.css">
</head>
<body>
	<header>
		<div class="wrapper">
			<div class="content">
				<!--Rectangle d'identification -->
				<div class="loginBox">
					
					<h1>Bienvenue dans GESMA</h1>
					<form method="post">
						<p>Identifiant</p>
						<input type="text" name="username" placeholder="Entrez votre identifiant" maxlength="25" autocomplete="off" autofocus>
						<p>Mot de passe</p>
						<input type="password" name="password" placeholder="••••••••••••••••••••••••••" maxlength="25">
						<input type="submit" name="login" value="Se connecter">
						<?php

							if(isset($message))
							{	
								echo '<p style="text-align: center;color: white;margin-top: -15px;">'.$message.'</p>';
							}

						?>
					</form>
				</div>
			</div>
		</div>
	</header>
</body>
</html>