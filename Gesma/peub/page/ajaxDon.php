<?php
	include('dbConf.php');

	if (isset($_POST["four"]) && !empty($_POST["four"])) {
		echo '<option value="">Choisir le moment</option>';
		echo '<option value="jour">Par Jour</option>';
		echo '<option value="mois">Par Mois</option>';
		echo '<option value="an">Par An</option>';
	}

	if (isset($_POST["take"]) && !empty($_POST["take"])) {
		if ($_POST["take"] == "jour") { // Jour
			$stmt = $bdd->query("SELECT DISTINCT dayCmd FROM commande ORDER BY dayCmd DESC");

				echo '<option value="">Choisir le jour</option>';
			while ($row = $stmt->fetch()) {
				echo '<option value="'.$row['dayCmd'].'">'.$row['dayCmd'].'</option>';
			}
		} elseif ($_POST["take"] == "mois") { // Mois
			$stmt = $bdd->query("SELECT DISTINCT moisCmd FROM commande ORDER BY moisCmd DESC");

				echo '<option value="">Choisir le mois</option>';
			while ($row = $stmt->fetch()) {
				echo '<option value="'.$row['moisCmd'].'">'.$row['moisCmd'].'</option>';
			}
		} elseif ($_POST["take"] == "an") { // Année
			$stmt = $bdd->query("SELECT DISTINCT anneeCmd FROM commande ORDER BY anneeCmd DESC");

				echo '<option value="">Choisir l\'année</option>';
			while ($row = $stmt->fetch()) {
				echo '<option value="'.$row['anneeCmd'].'">'.$row['anneeCmd'].'</option>';
			}
		}
	}

	if (isset($_POST['dete']) && !empty($_POST['dete']) && isset($_POST['dutu']) && !empty($_POST['dutu'])) {
		// Jour
		$rkos = $bdd->query("SELECT DISTINCT dayCmd FROM commande");
		while ($rko = $rkos->fetch()) {
			if ($rko['dayCmd'] == $_POST['dete']) {
				$days = $_POST['dete'];
				$fournis = $_POST['dutu'];
				
				$reponse = $bdd->query("SELECT * FROM commande WHERE dayCmd = '$days' AND fourId = $fournis");

				while ($donnees = $reponse->fetch()) {
				?>
				<a href="detCmd.php?day=<?=$donnees['dayCmd']?>&amp;heure=<?=$donnees['heureCmd']?>" style="text-decoration: none;color: black;">
					<form method="post" enctype="multipart/form-data">
						<li>
							<div class="container"><br>
								<p>Date : <?php echo $donnees['dayCmd']; ?></p>
								<p style="color: orange;">N° Facture : <?php echo $donnees['numfact']; ?></p>
								<?php
									$fours = $bdd->query("SELECT * FROM supplier WHERE idSup =".$donnees['fourId']);

									while ($four = $fours->fetch()) {
								?>
								<p><span style="color: green;">Fournisseur : </span><?php echo $four['nomSup']; ?></p>
								<?php
									}
								?>	
								<p><span style="color: green;">Montant : </span><?php echo $donnees['mtt']; ?> Francs CFA</p><br>
							</div>
						</li>
					</form>
				</a>
					
				<?php	
				}
			}
		}
		// Mois
		$rkos = $bdd->query("SELECT DISTINCT moisCmd FROM commande");
		while ($rko = $rkos->fetch()) {
			if ($rko['moisCmd'] == $_POST['dete']) {
				$mois = $_POST['dete'];
				$fournis = $_POST['dutu'];
				
				$reponse = $bdd->query("SELECT * FROM commande WHERE moisCmd = '$mois' AND fourId = $fournis");

				while ($donnees = $reponse->fetch()) {
				?>	
				<a href="detCmd.php?day=<?=$donnees['dayCmd']?>&amp;heure=<?=$donnees['heureCmd']?>" style="text-decoration: none;color: black;">
					<form method="post" enctype="multipart/form-data">
						<li>
							<div class="container"><br>
								<p>Date : <?php echo $donnees['moisCmd']; ?></p>
								<p style="color: orange;">N° Facture : <?php echo $donnees['numfact']; ?></p>
								<?php
									$fours = $bdd->query("SELECT * FROM supplier WHERE idSup =".$donnees['fourId']);

									while ($four = $fours->fetch()) {
								?>
								<p><span style="color: green;">Fournisseur : </span><?php echo $four['nomSup']; ?></p>
								<?php
									}
								?>
								<p><span style="color: green;">Montant : </span><?php echo $donnees['mtt']; ?> Francs CFA</p><br>
							</div>
						</li>
					</form>
				</a>
				<?php	
				}
			}
		}
		// Année
		$rkos = $bdd->query("SELECT DISTINCT anneeCmd FROM commande");
		while ($rko = $rkos->fetch()) {
			if ($rko['anneeCmd'] == $_POST['dete']) {
				$annee = $_POST['dete'];
				$fournis = $_POST['dutu'];
				
				$reponse = $bdd->query("SELECT * FROM commande WHERE anneeCmd = '$annee' AND fourId = $fournis");

				while ($donnees = $reponse->fetch()) {
				?>	
				<a href="detCmd.php?day=<?=$donnees['dayCmd']?>&amp;heure=<?=$donnees['heureCmd']?>" style="text-decoration: none;color: black;">
					<form method="post" enctype="multipart/form-data">
						<li>
							<div class="container"><br>
								<p>Date : <?php echo $donnees['anneeCmd']; ?></p>
								<p style="color: orange;">N° Facture : <?php echo $donnees['numfact']; ?></p>
								<?php
									$fours = $bdd->query("SELECT * FROM supplier WHERE idSup =".$donnees['fourId']);

									while ($four = $fours->fetch()) {
								?>
								<p><span style="color: green;">Fournisseur : </span><?php echo $four['nomSup']; ?></p>
								<?php
									}
								?>
								<p><span style="color: green;">Montant : </span><?php echo $donnees['mtt']; ?> Francs CFA</p><br>
							</div>
						</li>
					</form>
				</a>
				<?php	
				}
			}
		}
	}
?>