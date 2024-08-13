<?php
    include('dbConf.php');

    if (isset($_GET['niveaux'])) {
        
        $niveaux = $_GET['niveaux'];
        
        switch ($niveaux) {
            case 1:
                $groupe = "Benjamins";
                break;
                
            case 2:
                $groupe = "Cadets";
                break;

            case 3:
                $groupe = "Ainés";
                break;

            case 4:
                $groupe = "Meneurs";
                break;

            case 5:
                $groupe = "Aspirants Accompagnateurs";
                break;

            case 6:
                $groupe = "Accompagnateurs";
                break;

            case 7:
                $groupe = "Accompagnateurs Principaux";
                break;
        }

        if (isset($_GET['jours'])) {
            $niveauEx = $niveaux;
            $jours = $_GET['jours'];
        } else {
            $niveauIn = $niveaux;
        }

    } else {
        header('Location: work.php');
    }
    
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informations détaillées | CV-AV BOUAKE</title>
    <link href="../font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/list.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <!-- List Area -->
    <section class="list-area" id="list">
        <?php
            // Aujourd'hui
            if (isset($niveauEx)) {
                $query = "SELECT * FROM fiche WHERE jour = :jour AND niveau = :niveau";
                $reph1 = $bdd->prepare($query);
                $reph1->execute(
                    array (
                        'jour' => $jours,
                        'niveau' => $niveauEx
                    )
                );
                $count = $reph1->rowCount();

                if ($count < 1) {
                    header("Location: work.php");
                } elseif ($count == 1) {
                    $mili = "Militant";
                } else {
                    $mili = "Militants";
                }

                ?>
                
                <h1 class="section-title">Liste des <?php echo $groupe ?> (Aujourd'hui) : <?php echo $count ." ". $mili; ?></h1>
                
                <?php
            }

            // All
            if (isset($niveauIn)) {
                
                $reph1 = $bdd->query("SELECT * FROM fiche WHERE niveau = $niveauIn");
                $count = $reph1->rowCount();

                if ($count < 1) {
                    header("Location: work.php");
                } elseif ($count == 1) {
                    $mili = "Militant";
                } else {
                    $mili = "Militants";
                }

                ?>
                
                <h1 class="section-title">Liste des <?php echo $groupe ?> : <?php echo $count ." ". $mili; ?></h1>
                
                <?php
            }
        ?>

        <ul class="list-content">
            <li>
                <div class="list-details" id="th-color">

                    <div class="details-box">
                        <span class="details">Nom et Prénoms</span>
                    </div>

                    <div class="details-box">
                        <span class="details">Section de base</span>
                    </div>

                    <div class="details-box">
                        <span class="details">Doyenné</span>
                    </div>

                    <div class="details-box">
                        <span class="details th-del">Modifier</span>
                    </div>

                    <div class="details-box">
                        <span class="details th-del">Supprimer</span>
                    </div>
                </div>
            </li>

            <hr>

            <?php
                // Aujourd'hui
                if (isset($niveauEx)) {
                    $query = "SELECT * FROM fiche WHERE jour = :jour AND niveau = :niveau ORDER BY fullname ASC";
                    $repLst = $bdd->prepare($query);
                    $repLst->execute(
                        array (
                            'jour' => $jours,
                            'niveau' => $niveauEx
                        )
                    );

                    while ($donLst = $repLst->fetch()) {
                    ?>
                    
                        <li>
                            <div class="list-details">
                                <div class="details-box" style="text-transform: uppercase;">
                                    <span class="details">
                                        <?php echo $donLst['fullname']; ?>
                                    </span>
                                </div>

                                <div class="details-box">
                                    <span class="details">
                                    <?php
                                        $sec = $donLst['section'];

                                        $repSec = $bdd->query("SELECT * FROM section WHERE idS = $sec");
                                        while ($donSec = $repSec->fetch()) {
                                            echo $donSec['paroisse'];
                                        }
                                    ?>
                                    </span>
                                </div>

                                <div class="details-box">
                                    <span class="details">
                                        <?php
                                            $doy = $donLst['doyenne'];

                                            $repDoy = $bdd->query("SELECT * FROM doyen WHERE idD = $doy");
                                            while ($donDoy = $repDoy->fetch()) {
                                                echo $donDoy['doyenne'];
                                            }
                                        ?>
                                    </span>
                                </div>

                                <!-- Modifier -->
                                <div class="details-box fa-mm">
                                    <span class="details fa">
                                        <a href="mdf-cvav.php?id=<?= $donLst['idFiche']; ?>">
                                            <i class="fa fa-pencil-square" aria-hidden="true"></i>
                                        </a>
                                    </span>
                                </div>

                                <!-- Supprimer -->
                                <div class="details-box fa-mm">
                                    <span class="details fa">
                                        <a href="del-cvav.php?id=<?= $donLst['idFiche']; ?>">
                                            <i class="fa fa-window-close" aria-hidden="true"></i>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </li>
                    <?php

                    }
                }

                // All
                if (isset($niveauIn)) {
                
                    $repLst = $bdd->query("SELECT * FROM fiche WHERE niveau = $niveauIn");

                    while ($donLst = $repLst->fetch()) {
                    ?>
                        <li>
                            <div class="list-details">
                                <div class="details-box" style="text-transform: uppercase;">
                                    <span class="details">
                                        <?php echo $donLst['fullname']; ?>
                                    </span>
                                </div>

                                <div class="details-box">
                                    <span class="details">
                                    <?php
                                        $sec = $donLst['section'];

                                        $repSec = $bdd->query("SELECT * FROM section WHERE idS = $sec");
                                        while ($donSec = $repSec->fetch()) {
                                            echo $donSec['paroisse'];
                                        }
                                    ?>
                                    </span>
                                </div>

                                <div class="details-box">
                                    <span class="details">
                                        <?php
                                            $doy = $donLst['doyenne'];

                                            $repDoy = $bdd->query("SELECT * FROM doyen WHERE idD = $doy");
                                            while ($donDoy = $repDoy->fetch()) {
                                                echo $donDoy['doyenne'];
                                            }
                                        ?>
                                    </span>
                                </div>

                                <!-- Modifier -->
                                <div class="details-box fa-mm">
                                    <span class="details fa">
                                        <a href="mdf-cvav.php?id=<?= $donLst['idFiche']; ?>">
                                            <i class="fa fa-pencil-square" aria-hidden="true"></i>
                                        </a>
                                    </span>
                                </div>

                                <!-- Supprimer -->
                                <div class="details-box fa-mm">
                                    <span class="details fa">
                                        <a href="del-fiche.php?id=<?= $donLst['idFiche']; ?>" onclick="return supFunc();">
                                            <i class="fa fa-window-close" aria-hidden="true"></i>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </li>
                    <?php
                    }
                    
                }
            ?>
        </ul>
    </section>
    <!-- End List Area -->

    <?php include 'footer.php'; ?>

    <script src="script.js"></script>
    <script>
        function supFunc() {
            var rep = confirm("Voulez-vous supprimer cet Militant ?");

            if (rep == true) {
                return true;
            } else {
                return false;
            }
        }
    </script>
</body>
</html>