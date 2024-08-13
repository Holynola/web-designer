<?php
    include('dbConf.php');

    $repFch = $bdd->query("SELECT idFiche FROM fiche");
    $count = $repFch->rowCount();

    // Ajout d'une fiche
    if (isset($_GET['nbFiche'])) {
        $nbFiche = $_GET['nbFiche'];

        if ($count > $nbFiche) {
            $info = 'Enregistrement effectué avec succès';
        }
    }

    // Modifier une fiche
    if (isset($_GET['mdfMsg'])) {
        $mdfMsg = $_GET['mdfMsg'];
    }

    // Supprimer une fiche
    if (isset($_GET['delMsg'])) {
        $delMsg = $_GET['delMsg'];
    }

    $today = date('d-m-Y');

    // Benjamins Today
    $query = "SELECT * FROM fiche WHERE jour = :jour AND niveau = :niveau";
    $repBenT = $bdd->prepare($query);
    $repBenT->execute(
        array (
            'jour' => $today,
            'niveau' => 1
        )
    );
    $countBenT = $repBenT->rowCount();

    // Benjamins
    $query = "SELECT * FROM fiche WHERE niveau = :niveau";
    $repBen = $bdd->prepare($query);
    $repBen->execute(
        array (
            'niveau' => 1
        )
    );
    $countBen = $repBen->rowCount();

    // Cadets Today
    $query = "SELECT * FROM fiche WHERE jour = :jour AND niveau = :niveau";
    $repCadT = $bdd->prepare($query);
    $repCadT->execute(
        array (
            'jour' => $today,
            'niveau' => 2
        )
    );
    $countCadT = $repCadT->rowCount();

    // Cadets
    $query = "SELECT * FROM fiche WHERE niveau = :niveau";
    $repCad = $bdd->prepare($query);
    $repCad->execute(
        array (
            'niveau' => 2
        )
    );
    $countCad = $repCad->rowCount();
    
    // Ainées Today
    $query = "SELECT * FROM fiche WHERE jour = :jour AND niveau = :niveau";
    $repAinT = $bdd->prepare($query);
    $repAinT->execute(
        array (
            'jour' => $today,
            'niveau' => 3
        )
    );
    $countAinT = $repAinT->rowCount();

    // Ainées
    $query = "SELECT * FROM fiche WHERE niveau = :niveau";
    $repAin = $bdd->prepare($query);
    $repAin->execute(
        array (
            'niveau' => 3
        )
    );
    $countAin = $repAin->rowCount();

    // Meneurs Today
    $query = "SELECT * FROM fiche WHERE jour = :jour AND niveau = :niveau";
    $repMenT = $bdd->prepare($query);
    $repMenT->execute(
        array (
            'jour' => $today,
            'niveau' => 4
        )
    );
    $countMenT = $repMenT->rowCount();

    // Meneurs
    $query = "SELECT * FROM fiche WHERE niveau = :niveau";
    $repMen = $bdd->prepare($query);
    $repMen->execute(
        array (
            'niveau' => 4
        )
    );
    $countMen = $repMen->rowCount();

    // AA Today
    $query = "SELECT * FROM fiche WHERE jour = :jour AND niveau = :niveau";
    $repAacT = $bdd->prepare($query);
    $repAacT->execute(
        array (
            'jour' => $today,
            'niveau' => 5
        )
    );
    $countAacT = $repAacT->rowCount();

    // AA
    $query = "SELECT * FROM fiche WHERE niveau = :niveau";
    $repAac = $bdd->prepare($query);
    $repAac->execute(
        array (
            'niveau' => 5
        )
    );
    $countAac = $repAac->rowCount();

    // AC Today
    $query = "SELECT * FROM fiche WHERE jour = :jour AND niveau = :niveau";
    $repAccT = $bdd->prepare($query);
    $repAccT->execute(
        array (
            'jour' => $today,
            'niveau' => 6
        )
    );
    $countAccT = $repAccT->rowCount();

    // AC
    $query = "SELECT * FROM fiche WHERE niveau = :niveau";
    $repAcc = $bdd->prepare($query);
    $repAcc->execute(
        array (
            'niveau' => 6
        )
    );
    $countAcc = $repAcc->rowCount();

    // AP Today
    $query = "SELECT * FROM fiche WHERE jour = :jour AND niveau = :niveau";
    $repAcpT = $bdd->prepare($query);
    $repAcpT->execute(
        array (
            'jour' => $today,
            'niveau' => 7
        )
    );
    $countAcpT = $repAcpT->rowCount();

    // AP
    $query = "SELECT * FROM fiche WHERE niveau = :niveau";
    $repAcp = $bdd->prepare($query);
    $repAcp->execute(
        array (
            'niveau' => 7
        )
    );
    $countAcp = $repAcp->rowCount();

    // Today Fiche
    $query = "SELECT * FROM fiche WHERE jour = :jour";
    $repTdF = $bdd->prepare($query);
    $repTdF->execute(
        array (
            'jour' => $today
        )
    );
    $countTdF = $repTdF->rowCount();

    // All Fiche
    $repFiche = $bdd->query('SELECT * FROM fiche');
    $countFiche = $repFiche->rowCount();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Effectifs | CV-AV BOUAKE</title>
    <link href="../font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/work.css">
</head>
<body>
    
    <?php include 'header.php'; ?>

    <!-- Work Area-->
    <section class="work-area" id="work">
        <h1 class="section-title">EFFECTIFS</h1>
        <ul class="work-content">
            <li>
                <h2>Aujourd'hui</h2>
                <hr>

                <div class="work-details">

                    
                    <div class="detail-box">
                        <a href="list.php?niveaux=1&amp;jours=<?= $today ?>">
                            <h3>Benjamins</h3>
                            <span>
                                <?php echo $countBenT; ?>
                            </span>
                        </a>
                    </div>

                    <div class="detail-box">
                        <a href="list.php?niveaux=2&amp;jours=<?= $today ?>">    
                            <h3>Cadets</h3>
                            <span>
                                <?php echo $countCadT; ?>
                            </span>
                        </a>
                    </div>

                    <div class="detail-box">
                        <a href="list.php?niveaux=3&amp;jours=<?= $today ?>">
                            <h3>Ainés</h3>
                            <span>
                                <?php echo $countAinT; ?>
                            </span>
                        </a>
                    </div>

                    <div class="detail-box">
                        <a href="list.php?niveaux=4&amp;jours=<?= $today ?>">
                            <h3>Meneurs</h3>
                            <span>
                                <?php echo $countMenT; ?>
                            </span>
                        </a>
                    </div>

                    <div class="detail-box">
                        <a href="list.php?niveaux=5&amp;jours=<?= $today ?>">
                            <h3>Aspirants Accompagnateurs</h3>
                            <span>
                                <?php echo $countAacT; ?>
                            </span>
                        </a>
                    </div>

                    <div class="detail-box">
                        <a href="list.php?niveaux=6&amp;jours=<?= $today ?>">
                            <h3>Accompagnateurs</h3>
                            <span>
                                <?php echo $countAccT; ?>
                            </span>
                        </a>
                    </div>

                    <div class="detail-box">
                        <a href="list.php?niveaux=7&amp;jours=<?= $today ?>">
                            <h3>Accompagnateurs Principal</h3>
                            <span>
                                <?php echo $countAcpT; ?>
                            </span>
                        </a>
                    </div>

                    <div class="detail-box tot1">
                        <a href="list-all.php?jours=<?= $today ?>">
                            <h3>Total</h3>
                            <span>
                                <?php echo $countTdF; ?>
                            </span>
                        </a>
                    </div>
                </div>
            </li>
            <li>
                <h2>Nombre total de Militants</h2>
                <hr>

                <div class="work-details">

                    <div class="detail-box">
                        <a href="list.php?niveaux=1">
                            <h3>Benjamins</h3>
                            <span>
                                <?php echo $countBen; ?>
                            </span>
                        </a>
                    </div>

                    <div class="detail-box">
                        <a href="list.php?niveaux=2">
                            <h3>Cadets</h3>
                            <span>
                                <?php echo $countCad; ?>
                            </span>
                        </a>
                    </div>

                    <div class="detail-box">
                        <a href="list.php?niveaux=3">
                            <h3>Ainés</h3>
                            <span>
                                <?php echo $countAin; ?>
                            </span>
                        </a>
                    </div>

                    <div class="detail-box">
                        <a href="list.php?niveaux=4">
                            <h3>Meneurs</h3>
                            <span>
                                <?php echo $countMen; ?>
                            </span>
                        </a>
                    </div>

                    <div class="detail-box">
                        <a href="list.php?niveaux=5">  
                            <h3>Aspirants Accompagnateurs</h3>
                            <span>
                                <?php echo $countAac; ?>
                            </span>
                        </a>
                    </div>

                    <div class="detail-box">
                        <a href="list.php?niveaux=6">
                            <h3>Accompagnateurs</h3>
                            <span>
                                <?php echo $countAcc; ?>
                            </span>
                        </a>
                    </div>

                    <div class="detail-box">
                        <a href="list.php?niveaux=7">
                            <h3>Accompagnateurs Principal</h3>
                            <span>
                                <?php echo $countAcp; ?>
                            </span>
                        </a>
                    </div>

                    <div class="detail-box tot2">
                        <a href="list-all.php">
                            <h3>Total</h3>
                            <span>
                                <?php echo $countFiche; ?>
                            </span>
                        </a>
                    </div>
                </div>
            </li>

            <a href="add-cvav.php" class="button">Ajouter un(e) militant(e)</a>
        </ul>
    </section>
    <!-- End Work Area-->

    <?php include 'footer.php'; ?>

    <script src="script.js"></script>
    <script>
        var addInfo = "<?php if (isset($info)) {echo $info;} else {echo "";} ?>";
        var mdfInfo = "<?php if (isset($mdfMsg)) {echo $mdfMsg;} else {echo "";} ?>";
        var delInfo = "<?php if (isset($delMsg)) {echo $delMsg;} else {echo "";} ?>";

        if (addInfo != "") {
            alert(addInfo);
        }

        if (mdfInfo != "") {
            alert(mdfInfo);
        }

        if (delInfo != "") {
            alert(delInfo);
        }
        
    </script>
</body>
</html>