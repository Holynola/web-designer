<?php
	session_start();

	include('dbConf.php');

	if (isset($_SESSION["username"])) {
		$user = $_SESSION["username"];
		$logs = $bdd->query("SELECT * FROM login WHERE username = '$user'");

		while ($log = $logs->fetch()) {
			$type = $log['type'];
		}
	} else {
		header("location:../index.php");
	}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="author" content="Holynola">
	<link rel="shortcut icon" href="../img/favicon.ico">
	<title>Guide d'utilisation</title>
	<link rel="stylesheet" type="text/css" href="../style/guide.css">
</head>
<body>
	<div>
		<h1 class="wel">Bienvenue dans le guide d'utilisation de GESMA</h1>
		<h2 id="som">SOMMAIRE</h2>
		<ol type="I" id="tit">
			Avant-Propos
			<li>S'identifier</li>
			<li>Accueil</li>
			<li>Boissons</li>
			<li>Commandes</li>
			<li>Fournisseurs</li>
			<?php if (isset($type) && $type !== "gerant") { ?>
				<li>Stocks</li>
			<?php } ?>	
			<li>Espace Conso</li>
			<?php if (isset($type) && $type !== "gerant") { ?>
				<li>Points</li>
			<?php } ?>	
			<li>Se déconnecter</li>
		</ol>

		<p>
			<h1 class="wel">AVANT-PROPOS</h1>
			<h3 class="sty">Nous tenons à faire quelques précisions :</h3>
			<br>
			- Les différents éléments de ce guide d’utilisation s’affichent en fonction du type d’utilisateur connecté. Ainsi il y aura un type d’utilisateur qui se rendra compte de l’absence de certains titres et paragraphes<br>
		</p>

		<p>
			<h1 class="wel">I. S'IDENTIFIER</h1>
			<div id="iden"></div>
			<h3 class="sty">1. Entrez votre identifiant</h3><br>
			<h3 class="sty">2. Saisissez votre mot de passe</h3><br>
			<h3 class="sty">3. Cliquez sur « Se connecter »</h3><br>
			<span>NB :</span> Saisir correctement ces références (identifiant et mot de passe) pour éviter les messages d’erreurs.
		</p>

		<p>
			<h1 class="wel">II. ACCUEIL</h1>
			<div id="acc"></div>
			Faire défiler vers le bas pour voir les différentes options disponibles sur la page de l’accueil.<br>
			<?php if (isset($type) && $type !== "gerant") { ?>
				<br>
				<h3 class="sty">1. Ajouter un utilisateur</h3><br>
				- Cliquez sur le bouton « Cliquez ICI » juste en dessous de « Ajouter un utilisateur »<br>
				- La page de l’ajout d’un utilisateur s’ouvre<br>
				- Remplir les différentes cases et choisir le type d’utilisateur<br>
				- Enregistrer<br>
				<span>NB :</span> Ne pas se tromper sur le choix du type d’utilisateur.<br>
				<br>
				<h3 class="sty">2. Liste des utilisateurs enregistrés</h3><br>
				- Cliquez sur le bouton « Cliquez ICI » juste en dessous de « Liste des utilisateurs enregistrés »<br>
				- La page des utilisateurs enregistrés s’ouvre<br>
				<span>NB :</span> Vous pouvez supprimer un utilisateur en cliquant sur ses informations.<br>
			<?php } ?>
			<br>
			<h3 class="sty">3. Guide d'utilisation</h3><br>
			- Cliquez sur le bouton « Cliquez ICI » juste en dessous de « Guide d’utilisation »<br>
			- Le guide d’utilisation s’ouvre.<br>
			<br>
			<h3 class="sty">4. Termes et conditions</h3><br>
			- Cliquez sur le bouton « Cliquez ICI » juste en dessous de « Termes et conditions »<br>
			- Vous avez accès aux termes et conditions d’utilisation de l’application.<br>
		</p>

		<p>
			<h1 class="wel">III. BOISSONS</h1>
			<div id="boi"></div>
			<h3 class="sty">1. La liste des boissons enregistrées dans l’application</h3><br>
			<div id="aboi"></div>
			<h3 class="sty">2. Ajouter une nouvelle boisson</h3><br>
			- Cliquez sur « Ajouter une nouvelle boisson »<br>
			- La page de l’ajout d’une boisson s’ouvre<br>
			- Cliquez sur « Choisir un fichier » pour sélectionner une image correspondante à la boisson<br>
			- Saisir le nom, le prix et le nombre de bouteilles par casier de la boisson<br>
			- Cliquez sur « Ajouter »<br>
			<h3 class="sty">3. Informations sur la boisson</h3><br>
			- Cliquez sur une boisson pour voir plus d'informations<br>
			- La page s'ouvre<br>
			<div id="bois"></div>
			- Cliquez sur « Modifier » pour modifier la boisson<br>
			- Cliquez sur « Supprimer » pour supprimer la boisson

		</p>

		<p>
			<h1 class="wel">IV. COMMANDES</h1>
			<h3 class="sty">A. Cliquez sur « Commandes » pour afficher le menu déroulant (Nouvelle commande, Liste des commandes et Liste des commandes (Par Fournisseur))</h3><br>
			<h3 class="sty">B. Choisir la page que l’on souhaite ouvrir</h3><br>
			<div id="ncom"></div>
			<h3 class="sty">1. Nouvelle commande</h3><br>
			- Choisir le fournisseur (Dépôt)<br>
			- Entrer le numéro de la facture<br>
			- Cliquez sur « Ajouter une ligne » pour chaque type de boisson commandée et mentionnée sur la facture<br>
			- Choisir le type de boisson dans « Désignation »<br>
			- Saisir le prix d’achat par casier<br>
			- Entrer le nombre de casiers commandés dans « Quantité »<br>
			- Enregistrer<br>
			<span>NB :</span><br>
			- Vérifier les valeurs calculées pour voir s’il n’y pas d’erreur sur la facture avant d’enregistrer<br>
			- S’il y a une ou plusieurs lignes de trop, cliquez sur « Effacer une ligne » pour les effacer une à une.<br>
			<br>
			<div id="lcom"></div>
			<h3 class="sty">2. Liste des commandes</h3><br>
			- Les commandes du jour s’affichent à l’ouverture de la page<br>
			- Pour voir les anciennes commandes, cliquez sur « Trier » pour sélectionner le type d’affichage (afficher en fonction du jour ou du mois)<br>
			- Pour sélectionner avec précision le jour ou le mois, cliquez sur la période afficher en dessous de « Liste des commandes » pour faire un choix.<br>
			<br>
			<div id="fcom"></div>
			<h3 class="sty">3. Liste des commandes (Par Fournisseur)</h3><br>
			Pour sélectionner toutes commandes effectuées chez un fournisseur, il vous faut :<br>
			- D’abord cliquez sur le menu « Choisir le fournisseur » pour sélectionner un fournisseur<br>
			- Ensuite cliquez sur le menu « Choisir le moment » pour déterminer le jour, le mois ou l’année<br>
			- Enfin sélectionner une date après avoir cliquez sur le menu « Choisir le jour »<br>
			<span>NB :</span> Il faut obligatoirement effectuer ces 3 (trois) étapes ci-dessus pour avoir toutes les commandes liées à un fournisseur (Dépôt) en fonction de la période voulue.
		</p>

		<p>
			<h1 class="wel">V. FOURNISSEURS</h1>
			<div id="four"></div>
			<h3 class="sty">1. La liste des fournisseurs (dépôts) enregistrés dans l’application</h3><br>
			<div id="fours"></div>
			<h3 class="sty">2. Ajouter un nouveau fournisseur :</h3><br>
			- Cliquez sur « Ajouter un nouveau Fournisseur »<br>
			- La page de l’ajout d’un fournisseur s’ouvre<br>
			- Saisir le nom, la localisation et le ou les contacts de ce fournisseur<br>
			- Cliquez sur « Ajouter »<br>
			<h3 class="sty">3. Informations sur le fournisseur</h3><br>
			- Cliquez sur un fournisseur pour voir plus d'informations<br>
			- La page s'ouvre<br>
			<div id="fourse"></div>
			- Cliquez sur « Modifier » pour modifier le fournisseur<br>
			- Cliquez sur « Supprimer » pour supprimer le fournisseur
		</p>

	<?php if (isset($type) && $type !== "gerant") { ?>
		<p>
			<h1 class="wel">VI. STOCKS</h1>
			<div id="stock"></div>
			<h3 class="sty">1. Les points de stocks du mois s’affichent à l’ouverture de la page</h3><br>
			<h3 class="sty">2. Pour voir les anciens points de stocks, cliquez sur « Trier » pour sélectionner le type d’affichage (afficher en fonction du mois ou de l’année)</h3><br>
			<h3 class="sty">3. Pour sélectionner avec précision le mois ou l’année, cliquez sur la période afficher en dessous de « Stocks » pour faire un choix.</h3>
		</p>
	<?php } ?>	

		<p>
			<h1 class="wel">VII. ESPACE CONSO</h1>
			<div id="esp"></div>
			<div id="espa"></div>
			<div id="espac"></div>
			<div id="espace"></div>
			<h3 class="sty">1. Le gérant doit remplir le nombre de bouteilles vendues par type de boisson dans la colonne « Bouteilles vendues », saisir éventuellement le total des dépenses, le total des crédits et le total des remboursements, sans oublier les détails (justificatifs) dans les cases en dessous. Il doit cliquer sur « Enregistrer » avant de fermer la page.</h3><br>

			<span>NB :</span> S’assurer que l’enregistrement soit effectif avec le message « Enregistrement effectué ! ». Les valeurs saisies seront perdues si toute fois celles-ci ne sont pas enregistrées avant la fermeture de la page.<br>
		
		<?php if (isset($type) && $type !== "gerant") { ?>
			<h3 class="sty">2. Le contrôleur, après vérification du stock restant de chaque type de boisson, doit saisir ces valeurs dans la colonne « Stock Physique ». Il doit aussi sélectionner le nom du gérant dans le tableau « PERSONNEL », entrez dans le tableau « BILAN FINANCIER », le montant reçu et le montant manquant après calcul. Il doit cliquez sur « Enregistrer le point » pour l’enregistrer avant de quitter cette page.</h3><br>

			<span>NB :</span> En cas de besoin d’ajout de dépenses supplémentaires au point, le contrôleur doit faire appel au gérant afin d’effectuer la saisie avec son accès.
		<?php } ?>	
		</p>

	<?php if (isset($type) && $type !== "gerant") { ?>
		<p>
			<h1 class="wel">VIII. POINTS</h1>
			<div id="point"></div>
			<h3 class="sty">1. Les points du mois s’affichent à l’ouverture de la page</h3><br>
			<h3 class="sty">2. Pour voir les anciens points, cliquez sur « Trier » pour sélectionner le type d’affichage (afficher en fonction du mois ou de l’année)</h3><br>
			<h3 class="sty">3. Pour sélectionner avec précision le mois ou l’année, cliquez sur la période afficher en dessous de « Points » pour faire un choix</h3><br>
			<h3 class="sty">4. Cliquez sur un point pour voir les détails.</h3>
		</p>
	<?php } ?>	

		<p>
			<h1 class="wel">IX. SE DÉCONNECTER</h1>
			<h3 class="sty">Cliquez sur « Se déconnecter » pour sortir de l’application.</h3>
		</p>
	</div>
</body>
</html>