<?php
	include('dbConf.php');

	for ($i = 1; $i < 1000; $i++) {
		if (!empty($_POST["bteven".$i])) {
			$bouven = $_POST["bteven".$i]; // Boteilles vendues
			$design = $_POST["boixon".$i]; // Nom de la boisson

			$botleCmd = $_POST["btecmd".$i]; // Bouteilles commandées

			$prixAchat = $_POST["papbt".$i]; // Prix d'achat par bouteille
			$prixAchat1 = $_POST["papbte".$i]; // Prix d'achat par bouteille 1
			$prixAchat2 = $_POST["papbtes".$i]; // Prix d'achat par bouteille 2

			$stockIni = $_POST["stcin".$i]; // Stock initial
			$stockInitial1 = $_POST["stcint".$i]; // Stock initial 1
			$stockInitial2 = $_POST["stcinit".$i]; // Stock initial 2

			// Si stock initial <= 0
			if (($stockInitial1 <= 0) && ($stockInitial2 <= 0)) {
				
				$mac = $bouven * $prixAchat;
			}

			// Sinon si (stock initial 1 > 0) et (stock initial 2 <= 0)
			elseif (($stockInitial1 > 0) && ($stockInitial2 <= 0)) {
				
				// Si bouteilles commandées <= 0
				if ($botleCmd <= 0) {
					
					$mac = $bouven * $prixAchat1;
				}

				// Sinon si bouteilles commandées > 0
				elseif ($botleCmd > 0) {
					
					// Si prix d'achat par bouteille = prix d'achat par bouteille 1
					if ($prixAchat == $prixAchat1) {
						
						$mac = $bouven * $prixAchat;
					}

					// Sinon si prix d'achat par bouteille != prix d'achat par bouteille 1
					elseif ($prixAchat != $prixAchat1) {
						
						// Si bouteilles vendues <= stock initial 1
						if ($bouven <= $stockInitial1) {
							
							$mac = $bouven * $prixAchat1;
						}

						// Sinon si bouteilles vendues > stock initial 1
						elseif ($bouven > $stockInitial1) {
							
							$mace = $stockInitial1 * $prixAchat1;
							$abc = $bouven - $stockInitial1;
							$maces = $abc * $prixAchat;

							$mac = $mace + $maces;
						}
					}
				}
			}

			// Sinon si (stock initial 1 > 0) et (stock initial 2 > 0)
			elseif (($stockInitial1 > 0) && ($stockInitial2 > 0)) {
				
				// Si bouteilles commandées <= 0
				if ($botleCmd <= 0) {
					
					// Si bouteilles vendues <= stock initial 1
					if ($bouven <= $stockInitial1) {
						
						$mac = $bouven * $prixAchat1;
					}

					// Sinon si bouteilles vendues > stock initial 1
					elseif ($bouven > $stockInitial1) {
						
						$mace = $stockInitial1 * $prixAchat1;
						$abc = $bouven - $stockInitial1;
						$maces = $abc * $prixAchat2;

						$mac = $mace + $maces;
					}
				}

				// Sinon si bouteilles commandées > 0
				elseif ($botleCmd > 0) {
					
					// Si (bouteilles vendues <= stock initial 1) et (bouteilles vendues < stock initial)
					if (($bouven <= $stockInitial1) && ($bouven < $stockIni)) {
						
						$mac = $bouven * $prixAchat1;
					}

					// Sinon si (bouteilles vendues > stock initial 1) et (bouteilles vendues < stock initial)
					elseif (($bouven > $stockInitial1) && ($bouven < $stockIni)) {
						
						$mace = $stockInitial1 * $prixAchat1;
						$abc = $bouven -$stockInitial1;
						$maces = $abc * $prixAchat2;

						$mac = $mace + $maces;
					}

					// Sinon si (bouteilles vendues > stock initial 1) et (bouteilles vendues = stock initial)
					elseif (($bouven > $stockInitial1) && ($bouven == $stockIni)) {
						
						$mace = $stockInitial1 * $prixAchat1;
						$maces = $stockInitial2 * $prixAchat2;

						$mac = $mace + $maces;
					}

					// Sinon si (bouteilles vendues > stock initial 1) et (bouteilles vendues > stock initial)
					elseif (($bouven > $stockInitial1) && ($bouven > $stockIni)) {
						
						$mace = $stockInitial1 * $prixAchat1;
						$macs = $stockInitial2 * $prixAchat2;
						$abc = $bouven - $stockIni;
						$maces = $abc * $prixAchat;

						$mac = $mace + $macs + $maces;
					}
				}
			}



			$result = $bdd->query("UPDATE boisson SET bouven = $bouven, mac = $mac WHERE design = '$design'");	
		}
	}

	$idDep = $_POST["idDep"];
	$dpnx = $_POST["dpnx"];
	$detail = $_POST["detail"];
	$credit = $_POST["credit"];
	$details = $_POST["details"];
	$autres = $_POST["autres"];
	$detailss = $_POST["detailss"];

	$rek = $bdd->query('SELECT * FROM depense');

	if (0 == $rek->fetchColumn()) {
		// La table est vide
		$rekete = $bdd->query("INSERT INTO depense (dpnx, detail, credit, details, autres, detailss) VALUES ({$dpnx}, '{$detail}'), {$credit}, '{$details}', {$autres}, '{$detailss}'");
	} else {
		// La table n'est pas vide
		$data = [
			'idDep' => $idDep,
			'dpnx' => $dpnx,
			'detail' => $detail,
			'credit' => $credit,
			'details' => $details,
			'autres' => $autres,
			'detailss' => $detailss,
		];
		$sql = "UPDATE depense SET dpnx=:dpnx, detail=:detail, credit=:credit, details=:details, autres=:autres, detailss=:detailss WHERE idDep=:idDep";
		$stmt = $bdd->prepare($sql);
		$stmt->execute($data);
	}
?>