<?php

	session_start();

	include('dbConf.php');

	if(isset($_SESSION["username"])) {
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
?>	
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="author" content="Holynola">
	<title>Liste des commandes (Par fournisseur)</title>
	<link rel="shortcut icon" href="../img/favicon.ico">
	<link rel="stylesheet" type="text/css" href="../style/lstcmdpf.css">
</head>
<script src="jquery-3.3.1.min.js"></script>
<script>
$(document).ready(function(){
	$('#uns').on('change', function() {
		var fours = $(this).val();
		if (fours) {
			$.ajax({
				type:'POST',
				url:'ajaxDon.php',
				data:'four='+fours,
				success:function(html){
					$('#deux').html(html);
					$('#trois').html('<option value=""></option>');
				}
			});
		} else {
			$('#deux').html('<option value="">Choisir le moment</option>');
			$('#trois').html('<option value=""></option>');
		}
	});

	$('#deux').on('change',function(){
        var stateID = $(this).val();
        if(stateID){
            $.ajax({
                type:'POST',
                url:'ajaxDon.php',
                data:'take='+stateID,
                success:function(html){
                    $('#trois').html(html);
                }
            }); 
        }else{
            $('#trois').html('<option value="">Choisir le moment en premier</option>'); 
        }
    });

    $('#trois').on('change', function(){
    	var detes = $(this).val();
    	var dutus = $('#uns').val();
    	if(detes){
    		$.ajax({
    			type:'POST',
    			url:'ajaxDon.php',
    			data:{
    				dete: detes,
    				dutu: dutus
    			},
    			success:function(html){
    				$('#para').html(html);
    			}
    		});
    	}else{
    		$('#para').html('<p id="para" name="para">Aucune sélection</p>');
    	}
    });
});
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
		<h1>Liste des commandes (Par fournisseur)</h1>

		<hr>

		<?php
		include('dbConf.php');

		$query = $bdd->query("SELECT * FROM supplier ORDER BY nomSup ASC");
		?>
		<div id="card" style="text-align: center;">
			<select name="uns" id="uns">
				<option value="">Choisir le fournisseur</option>
				<?php	
					while ($row = $query->fetch()) {
						echo '<option value="'.$row['idSup'].'">'.$row['nomSup'].'</option>';
					}
				?>
			</select>

			<select name="deux" id="deux">
				<option value="">Choisir le moment</option>
			</select>	

			<select name="trois" id="trois">
				<option value=""></option>
			</select>
		</div>	

		<div class="wrap" id="para">
			
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