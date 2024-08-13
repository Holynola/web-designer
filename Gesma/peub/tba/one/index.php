<?php

	include('../../page/dbConf.php');

	$dte = '15-01-2012';
	$aujourdhui = new DateTime($dte);
	$lancement  = new DateTime('14-02-2012');
	
	if($aujourdhui > $lancement)
	{     
	    echo 'Bâtiment construit !';
	}
	else
	{
	    echo 'Veuillez attendre la fin de la construction';
	}

	echo '<br><br>';

	$dayCmd;
	$heureCmd;

	$reqs = $bdd->query('SELECT dayCmd, heureCmd FROM commande WHERE idCmd = (SELECT MAX(idCmd) FROM commande)');

	while ($req = $reqs->fetch()) {
		$dayCmd = $req['dayCmd'];
		$heureCmd = $req['heureCmd'];
	}

	echo "Commande<br>";
	echo "Jour : " . $dayCmd . "<br>";
	echo " Heure : " . $heureCmd;

	$dayPt;
	$heurePt;

	$reks = $bdd->query('SELECT dayPt, heurePt FROM points WHERE idPoint = (SELECT MAX(idPoint) FROM points)');

	while ($rek = $reks->fetch()) {
		$dayPt = $rek['dayPt'];
		$heurePt = $rek['heurePt'];
	}

	echo "<br><br>";

	echo "Point<br>";
	echo "Jour : " . $dayPt . "<br>";
	echo " Heure : " . $heurePt;

	echo "<br><br>";

	$commandej = new DateTime($dayCmd);
	$pointsj  = new DateTime($dayPt);

	$commandeh = new DateTime($heureCmd);
	$pointsh  = new DateTime($heurePt);
	
	if($commandej > $pointsj)
	{     
	    echo 'Bâtiment construit !';
	}
	elseif ($commandej = $pointsj)
	{
	    if ($commandeh > $pointsh)
	    {
	    	echo 'Bâtiment construit !';
	    }
	    else
	    {
	    	echo 'Veuillez attendre la fin de la construction';
	    }
	}
	else
	{
		echo 'Veuillez attendre la fin de la construction';
	}
?>