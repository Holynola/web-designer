<?php
	include('dbConf.php');

	// Commande
	$fourId = $_POST['fourId'];
	$numfact = $_POST['numfact'];
	$mtt = $_POST['mtt'];
	$jourCmd = $_POST['jour'];
	$dayCmd = $_POST['day'];
	$moisCmd = $_POST['mois'];
	$anneeCmd = $_POST['annee'];
	$heureCmd = $_POST['heure'];

	if (!empty($fourId) && !empty($numfact) && !empty($mtt)) {
		$req = $bdd->prepare('INSERT INTO commande (fourId, numfact, mtt, jourCmd, dayCmd, moisCmd, anneeCmd, heureCmd) VALUES (:fourId, :numfact, :mtt, :jourCmd, :dayCmd, :moisCmd, :anneeCmd, :heureCmd)');
		$req->execute(array(
			'fourId' => $fourId,
			'numfact' => $numfact,
			'mtt' => $mtt,
			'jourCmd' => $jourCmd,
			'dayCmd' => $dayCmd,
			'moisCmd' => $moisCmd,
			'anneeCmd' => $anneeCmd,
			'heureCmd' => $heureCmd));
	

		// Produit
		for ($i=1; $i < 100; $i++) {
			if((!empty($_POST['boissonId'.$i])) && (!empty($_POST['pacasier'.$i])) && (!empty($_POST['qte'.$i])) && (!empty($_POST['montant'.$i]))) {
				$boissonId = $_POST['boissonId'.$i];
				$pacasier = $_POST['pacasier'.$i];
				$qte = $_POST['qte'.$i];
				$montant = $_POST['montant'.$i];
				$jourPr = $_POST['jour'];
				$dayPr = $_POST['day'];
				$moisPr = $_POST['mois'];
				$anneePr = $_POST['annee'];
				$heurePr = $_POST['heure'];

				$rek = $bdd->prepare('INSERT INTO produit (boissonId, pacasier, qte, montant, jourPr, dayPr, moisPr, anneePr, heurePr) VALUES (:boissonId, :pacasier, :qte, :montant, :jourPr, :dayPr, :moisPr, :anneePr, :heurePr)');
				$rek->execute(array(
					'boissonId' => $boissonId,
					'pacasier' => $pacasier,
					'qte' => $qte,
					'montant' => $montant,
					'jourPr' => $jourPr,
					'dayPr' => $dayPr,
					'moisPr' => $moisPr,
					'anneePr' => $anneePr,
					'heurePr' => $heurePr));
			}
		}

		// Qte Commandée
		for ($i=0; $i < 100; $i++) { 
			if((!empty($_POST['boissonId'.$i])) && (!empty($_POST['pacasier'.$i])) && (!empty($_POST['qte'.$i])) && (!empty($_POST['montant'.$i]))) {
				$boixonId = $_POST['boissonId'.$i];
				$paksier = $_POST['pacasier'.$i];
				$qtt = $_POST['qte'.$i];
				$montt = $_POST['montant'.$i];
				$jourQtc = $_POST['jour'];
				$dayQtc = $_POST['day'];
				$moisQtc = $_POST['mois'];
				$anneeQtc = $_POST['annee'];
				$heureQtc = $_POST['heure'];

				$rekete = $bdd->prepare('INSERT INTO qtecommande (boixonId, paksier, qtt, montt, jourQtc, dayQtc, moisQtc, anneeQtc, heureQtc) VALUES (:boixonId, :paksier, :qtt, :montt, :jourQtc, :dayQtc, :moisQtc, :anneeQtc, :heureQtc)');
				$rekete->execute(array(
					'boixonId' => $boixonId,
					'paksier' => $paksier,
					'qtt' => $qtt,
					'montt' => $montt,
					'jourQtc' => $jourQtc,
					'dayQtc' => $dayQtc,
					'moisQtc' => $moisQtc,
					'anneeQtc' => $anneeQtc,
					'heureQtc' => $heureQtc));
			}
		}
		header("location:lstcmd.php");
	} else {
		header("location:nvcmd.php?info=Commande non enregistrée !");
	}
?>