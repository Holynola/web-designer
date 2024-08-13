<?php
	session_start();

	if(isset($_SESSION["username"])) {
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
	else {
		header("location:../index.php");
	}

	include('dbConf.php');

	if(isset($_POST['envoi'])) {

		for ($i=1; $i < 100; $i++) { 
			
			// Conso
			if (!empty($_POST['boixon'.$i])) {
				$boixon = $_POST['boixon'.$i];
				$cmdcs = $_POST['cmdcs'.$i];
				$btecmd = $_POST['btecmd'.$i];
				$papcs = $_POST['papcs'.$i];
				$estcmd = $_POST['estcmd'.$i];
				$stcint = $_POST['stcin'.$i];
				$nvstc = $_POST['nvstc'.$i];
				$pdvuni = $_POST['pdvuni'.$i];
				$estnstc = $_POST['estnstc'.$i];
				$bteven = $_POST['bteven'.$i];
				$mttven = $_POST['mttven'.$i];
				$bene = $_POST['bene'.$i];
				$stcrst = $_POST['stcrst'.$i];
				$stcpsq = $_POST['stcpsq'.$i];
				$estsp = $_POST['estsp'.$i];
				$stcman = $_POST['stcman'.$i];
				$estsm = $_POST['estsm'.$i];
				$jourConso = $_POST['jour'];
				$dayConso = $_POST['day'];
				$moisConso = $_POST['mois'];
				$anneeConso = $_POST['annee'];
				$heureConso = $_POST['heure'];

				$rek = $bdd->prepare("INSERT INTO conso (boixon, cmdcs, btecmd, papcs, estcmd, stcint, nvstc, pdvuni, estnstc, bteven, mttven, bene, stcrst, stcpsq, estsp, stcman, estsm, jourConso, dayConso, moisConso, anneeConso, heureConso) VALUES (:boixon, :cmdcs, :btecmd, :papcs, :estcmd, :stcint, :nvstc, :pdvuni, :estnstc, :bteven, :mttven, :bene, :stcrst, :stcpsq, :estsp, :stcman, :estsm, :jourConso, :dayConso, :moisConso, :anneeConso, :heureConso)");
				$rek->execute(array(
					'boixon' => $boixon,
					'cmdcs' => $cmdcs,
					'btecmd' => $btecmd,
					'papcs' => $papcs,
					'estcmd' => $estcmd,
					'stcint' => $stcint,
					'nvstc' => $nvstc,
					'pdvuni' => $pdvuni,
					'estnstc' => $estnstc,
					'bteven' => $bteven,
					'mttven' => $mttven,
					'bene' => $bene,
					'stcrst' => $stcrst,
					'stcpsq' => $stcpsq,
					'estsp' => $estsp,
					'stcman' => $stcman,
					'estsm' => $estsm,
					'jourConso' => $jourConso,
					'dayConso' => $dayConso,
					'moisConso' => $moisConso,
					'anneeConso' => $anneeConso,
					'heureConso' => $heureConso));

				// Calcul des Stock et des Prix
				$stockPhysique = $_POST['stcpsq'.$i]; // Stock physique
				$bouteillesVendues = $_POST['bteven'.$i]; // Bouteilles vendues
				$stockInitial1 = $_POST['stcint'.$i]; // Stock initial 1
				$stockInitial2 = $_POST['stcinit'.$i]; // Stock initial 2
				$prixAchat = $_POST['papbt'.$i]; // Prix d'acaht par bouteille
				$prixAchat1 = $_POST['papbte'.$i]; // Prix d'achat par bouteille 1
				$prixAchat2 = $_POST['papbtes'.$i]; // Prix d'achat par bouteille 2
				$botleCmd = $_POST['btecmd'.$i]; // Boutelles commandées

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

				// Boisson
				$design = $_POST['boixon'.$i];
				$bouven = 0;
				$mac = 0;

				$dete = [
					'design' => $design,
					'pachat' => $pachat,
					'pachats' => $pachats,
					'stkini' => $stkini,
					'stkinit' => $stkinit,
					'bouven' => $bouven,
					'mac' => $mac,
				];

				$sal = "UPDATE boisson SET pachat = :pachat, pachats = :pachats, stkini = :stkini, stkinit = :stkinit, bouven = :bouven, mac = :mac WHERE design = :design";
				$stat = $bdd->prepare($sal);
				$stat->execute($dete);
			}	
		}

		// Points
		$estcomPt = $_POST['estcom'];
		$eststkPt = $_POST['eststc'];
		$mntvtePt = $_POST['mttvte'];
		$benefPt = $_POST['bnefix'];
		$dpsePt = $_POST['dpnx'];
		$detdepPt = $_POST['detail'];
		$mntrPt = $_POST['mttrecu'];
		$ekaPt = $_POST['eka'];
		$mankPt = $_POST['manque'];
		$crdPt = $_POST['credit'];
		$detcrdPt = $_POST['details'];
		$autrPt = $_POST['autres'];
		$detautrPt = $_POST['detailss'];
		$estsapPt = $_POST['estsap'];
		$nomGer = $_POST['gernt'];
		$nomCrtl = $_POST['control'];
		$jourPt = $_POST['jour'];
		$dayPt = $_POST['day'];
		$moisPt = $_POST['mois'];
		$anneePt = $_POST['annee'];
		$heurePt = $_POST['heure'];

		$reke = $bdd->prepare('INSERT INTO points (estcomPt, eststkPt, mntvtePt, benefPt, dpsePt, detdepPt, mntrPt, ekaPt, mankPt, crdPt, detcrdPt, autrPt, detautrPt, estsapPt, nomGer, nomCrtl, jourPt, dayPt, moisPt, anneePt, heurePt) VALUES (:estcomPt, :eststkPt, :mntvtePt, :benefPt, :dpsePt, :detdepPt, :mntrPt, :ekaPt, :mankPt, :crdPt, :detcrdPt, :autrPt, :detautrPt, :estsapPt, :nomGer, :nomCrtl, :jourPt, :dayPt, :moisPt, :anneePt, :heurePt)');
		$reke->execute(array(
			'estcomPt' => $estcomPt,
			'eststkPt' => $eststkPt,
			'mntvtePt' => $mntvtePt,
			'benefPt' => $benefPt,
			'dpsePt' => $dpsePt,
			'detdepPt' => $detdepPt,
			'mntrPt' => $mntrPt,
			'ekaPt' => $ekaPt,
			'mankPt' => $mankPt,
			'crdPt' => $crdPt,
			'detcrdPt' => $detcrdPt,
			'autrPt' => $autrPt,
			'detautrPt' => $detautrPt,
			'estsapPt' => $estsapPt,
			'nomGer' => $nomGer,
			'nomCrtl' => $nomCrtl,
			'jourPt' => $jourPt,
			'dayPt' => $dayPt,
			'moisPt' => $moisPt,
			'anneePt' => $anneePt,
			'heurePt' => $heurePt));

		// Stock
		$btsavStk = $_POST['btstk'];
		$ccmdStk = $_POST['cascom'];
		$btsapStk = $_POST['btstck'];
		$btevduStk = $_POST['btvend'];
		$stkresStk = $_POST['stcres'];
		$stkphyStk = $_POST['stcphy'];
		$stkmanStk = $_POST['stcman'];
		$jourStk = $_POST['jour'];
		$dayStk = $_POST['day'];
		$moisStk = $_POST['mois'];
		$anneeStk = $_POST['annee'];
		$heureStk = $_POST['heure'];

		$reket = $bdd->prepare('INSERT INTO stock (btsavStk, ccmdStk, btsapStk, btevduStk, stkresStk, stkphyStk, stkmanStk, jourStk, dayStk, moisStk, anneeStk, heureStk) VALUES (:btsavStk, :ccmdStk, :btsapStk, :btevduStk, :stkresStk, :stkphyStk, :stkmanStk, :jourStk, :dayStk, :moisStk, :anneeStk, :heureStk)');
		$reket->execute(array(
			'btsavStk' => $btsavStk,
			'ccmdStk' => $ccmdStk,
			'btsapStk' => $btsapStk,
			'btevduStk' => $btevduStk,
			'stkresStk' => $stkresStk,
			'stkphyStk' => $stkphyStk,
			'stkmanStk' => $stkmanStk,
			'jourStk' => $jourStk,
			'dayStk' => $dayStk,
			'moisStk' => $moisStk,
			'anneeStk' => $anneeStk,
			'heureStk' => $heureStk
		));

		// Dépense
		$idDep = $_POST["idDep"];
		$dpnx = 0;
		$detail = " ";
		$credit = 0;
		$details = " ";
		$autres = 0;
		$detailss = " ";

		$dutu = [
			'idDep' => $idDep,
			'dpnx' => $dpnx,
			'detail' => $detail,
			'credit' => $credit,
			'details' => $details,
			'autres' => $autres,
			'detailss' => $detailss,
		];
		$sul = "UPDATE depense SET dpnx=:dpnx, detail=:detail, credit=:credit, details=:details, autres=:autres, detailss=:detailss WHERE idDep=:idDep";
		$stut = $bdd->prepare($sul);
		$stut->execute($dutu);

		// Qte Commande
		$rekete = $bdd->query("DELETE FROM qtecommande");

		header("location:lstpt.php");
	
	} else {
		header("localtion:espc.php?info=Le point n'a pas été enregistré !");
	}
?>