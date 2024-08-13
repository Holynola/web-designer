<?php
	
	if(isset($_POST['test'])) {
		// Calcul des Stock et des Prix
		$stockPhysique = $_POST['stcpsq']; // Stock physique
		$bouteillesVendues = $_POST['bteven']; // Bouteilles vendues
		$stockInitial1 = $_POST['stcint']; // Stock initial 1
		$stockInitial2 = $_POST['stcinit']; // Stock initial 2
		$prixAchat = $_POST['papbt']; // Prix d'acaht par bouteille
		$prixAchat1 = $_POST['papbte']; // Prix d'achat par bouteille 1
		$prixAchat2 = $_POST['papbtes']; // Prix d'achat par bouteille 2
		$botleCmd = $_POST['btecmd']; // Boutelles commandées

		// Si Stock physique <= 0
		if ($stockPhysique <= 0) {
			$stkini = 0;
			$stkinit = 0;
			$pachat = 0;
			$pachats = 0;
		}

		// Sinon si Stock physique > 0
		elseif ($stockPhysique > 0) {
			
			// 1ère utilisation
			// Si Stock initial <= 0
			if (($stockInitial1 <= 0) && ($stockInitial2 <= 0)) {
					$stkini = $stockPhysique;
					$stkinit = 0;
					$pachat = $prixAchat;
					$pachats = 0;
			}

			// 2ème utilisation
			// Sinon si Stock initial 1 > 0 et Stock initial 2 = 0
			elseif (($stockInitial1 > 0) && ($stockInitial2 <= 0)) {
				
				// Si Bouteilles commandées <= 0
				if ($botleCmd <= 0) {
					$stkini = $stockPhysique;
					$stkinit = 0;
					$pachat = $prixAchat1;
					$pachats = 0;	
				}

				// Sinon si Bouteilles commandées > 0
				elseif ($botleCmd > 0) {
					
					// Si Prix d'achat par bouteille = Prix d'acaht par bouteille 1
					if ($prixAchat == $prixAchat1) {
						$stkini = $stockPhysique;
						$stkinit = 0;
						$pachat = $prixAchat1;
						$pachats = 0;
					}

					// Sinon si Prix d'achat par bouteille != Prix d'acaht par bouteille 1
					elseif ($prixAchat != $prixAchat1) {
						
						// Si Bouteilles vendues >= Stock initial 1
						if (($bouteillesVendues >= $stockInitial1)) {
							$stkini = $stockPhysique;
							$stkinit = 0;
							$pachat = $prixAchat;
							$pachats = 0;
						}

						// Sinon si Bouteilles vendues < Stock initial 1
						elseif (($bouteillesVendues < $stockInitial1)) {
							
							// Si Bouteilles commandées >= Stock physique
							if (($botleCmd >= $stockPhysique)) {
								$stkini = $stockPhysique;
								$stkinit = 0;
								$pachat = $prixAchat;
								$pachats = 0;
							}

							// Sinon si Bouteilles commandées < Stock physique
							elseif (($botleCmd < $stockPhysique)) {
								$stkini = $stockPhysique - $botleCmd;
								$stkinit = $botleCmd;
								$pachat = $prixAchat1;
								$pachats = $prixAchat;
							}
						}
					}
				}	
			}

			// 3ème utilisation
			// Sinon si Stock initial > 0 et Stock initial > 0
			elseif (($stockInitial1 > 0) && ($stockInitial2 > 0)) {
				
				// Si Bouteilles commandées <= 0
				if ($botleCmd <= 0) {
					
					// Si Bouteilles vendues >= Stock initial 1
					if (($bouteillesVendues >= $stockInitial1)) {
						$stkini = $stockPhysique;
						$stkinit = 0;
						$pachat = $prixAchat2;
						$pachats = 0;
					}

					// Sinon si Bouteilles vendus < Stock initial 1
					elseif (($bouteillesVendues < $stockInitial1)) {
						
						// Si Stock initial 2 >= Stock physique
						if (($stockInitial2 >= $stockPhysique)) {
							$stkini = $stockPhysique;
							$stkinit = 0;
							$pachat = $prixAchat2;
							$pachats = 0;
						}

						// Sinon si Stock initial 2 < Stock physique
						elseif (($stockInitial2 < $stockPhysique)) {
							$stkini = $stockPhysique - $stockInitial2;
							$stkinit = $stockInitial2;
							$pachat = $prixAchat1;
							$pachats = $prixAchat2;
						}
					}
				}

				// Sinon si Bouteilles commandées > 0
				elseif ($botleCmd > 0) {
					
					// Si Bouteilles vendues >= (Stock initial 1 + Stock initial 2)
					if ($bouteillesVendues >= ($stockInitial1 + $stockInitial2)) {
						$stkini = $stockPhysique;
						$stkinit = 0;
						$pachat = $prixAchat;
						$pachats = 0;
					}

					// Sinon si Bouteilles vendues < (Stock initial 1 + Stock initial 2) et Bouteilles vendues >= Stock initial 1
					elseif (($bouteillesVendues < ($stockInitial1 + $stockInitial2)) && ($bouteillesVendues >= $stockInitial1)) {
						
						// Si Bouteilles commandées >= Stock physique
						if ($botleCmd >= $stockPhysique) {
							$stkini = $stockPhysique;
							$stkinit = 0;
							$pachat = $prixAchat;
							$pachats = 0;
						}

						// Sinon si Bouteilles commandées < Stock physique
						elseif ($botleCmd < $stockPhysique) {
							$stkini = $stockPhysique - $botleCmd;
							$stkinit = $botleCmd;
							$pachat = $prixAchat2;
							$pachats = $prixAchat;
						}
					}

					// Sinon si Bouteilles vendues < Stock initial 1
					elseif ($bouteillesVendues < $stockInitial1) {
						
						// Si Bouteilles commandées >= Stock physique
						if ($botleCmd >= $stockPhysique) {
							$stkini = $stockPhysique;
							$stkinit = 0;
							$pachat = $prixAchat;
							$pachats = 0;
						}

						// Sinon si Bouteilles commandées < Stock physique
						elseif ($botleCmd < $stockPhysique) {
							
							// Si (Bouteilles commandées + Stock initial 2) > Stock physique
							if (($botleCmd + $stockInitial2) > $stockPhysique) {
								$stkini = $stockPhysique - $botleCmd;
								$stkinit = $botleCmd;
								$pachat = $prixAchat2;
								$pachats = $prixAchat;
							}

							// Sinon si (Bouteilles commandées + Stock initial 2) = Stock physique
							elseif (($botleCmd + $stockInitial2) == $stockPhysique) {
								$stkini = $stockInitial2;
								$stkinit = $botleCmd;
								$pachat = $prixAchat2;
								$pachats = $prixAchat;
							}

							// Sinon si (Bouteilles commandées + Stock initial 2) < Stock physique
							if (($botleCmd + $stockInitial2) < $stockPhysique) {
								$stkini = $stockPhysique - $botleCmd;
								$stkinit = $botleCmd;
								$pachat = ($prixAchat1 + $prixAchat2) / 2;
								$pachats = $prixAchat;
							}
						}
					}
				}
			}	
		}
	} else {
		$stkini = 0;
		$stkinit = 0;
		$pachat = 0;
		$pachats = 0;
	}	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Conso</title>
</head>
<body>
	<form action="index.php" method="POST">

		Bouteilles commandées : <input type="number" name="btecmd">
		<br><br>

		Prix d'achat par bouteille : <input type="number" name="papbt"><br>
		Prix d'achat par bouteille 1 : <input type="number" name="papbte"><br>
		Prix d'achat par bouteille 2 : <input type="number" name="papbtes"><br>
		<br>

		Stock initial : <input type="number" name="stcin"><br>
		Stock initial 1 : <input type="number" name="stcint"><br>
		Stock initial 2 : <input type="number" name="stcinit"><br>
		<br>

		Nouveau stock : <input type="number" name="nvstc"><br>
		<br>

		Bouteilles vendues : <input type="number" name="bteven"><br>
		<br>

		Stock physique : <input type="number" name="stcpsq"><br>
		<br><br>

		<input type="submit" name="test" value="Sub"><br><br>
	</form>

	Prix d'achat par bouteille 1 : <input type="number" value="<?php echo $pachat; ?>"><br>
	Prix d'achat par bouteille 2 : <input type="number" value="<?php echo $pachats; ?>"><br>
	<br>

	Stock initial : <input type="number" value="<?php echo $stkini + $stkinit; ?>"><br>
	Stock initial 1 : <input type="number" value="<?php echo $stkini; ?>"><br>
	Stock initial 2 : <input type="number" value="<?php echo $stkinit; ?>"><br>
	<br>

</body>
</html>