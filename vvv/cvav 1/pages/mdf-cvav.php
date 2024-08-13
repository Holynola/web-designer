<?php
    include('dbConf.php');

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        header("Location: work.php");
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification | CV-AV BOUAKE</title>
    <link href="../font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/add-cvav.css">
</head>
<body>
    
    <?php include 'header.php'; ?>

    <!-- Add Area -->
    <section class="add-area" id="add">
        <h1 class="section-title">Modification</h1>
        <form action="mdf-fiche.php?idt=<?= $id ?>" method="post" enctype="multipart/form-data">
            <ul class="add-content">
                <?php
                    $getFch = $bdd->query("SELECT * FROM fiche WHERE idFiche = $id");

                    while ($donFch = $getFch->fetch()) {
                        ?>
                            <li>
                                <h2>1- Militant</h2>
                                <hr>

                                <div class="user-details">

                                    <div class="input-box">
                                        <span class="details">Genre</span>
                                        <select name="genre" required>
                                            <optgroup label="--- Sélectionné ---">
                                                <?php
                                                    $gen = $donFch['genre'];
                                                    $reqGen = $bdd->query("SELECT * FROM gender WHERE idG = $gen");

                                                    while ($datGen = $reqGen->fetch()) {
                                                        ?>
                                                            <option value="<?= $datGen['idG'] ?>"><?= $datGen['genre'] ?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </optgroup>

                                            <optgroup label="-- Modifier la sélection --">
                                                <!-- Ajout de la table gender -->
                                                <?php
                                                    $repGen = $bdd->query('SELECT * FROM gender');

                                                    while ($donGen = $repGen->fetch()) {
                                                        ?>
                                                            <option value="<?= $donGen['idG'] ?>"><?= $donGen['genre'] ?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </optgroup>
                                        </select>
                                    </div>    
                                
                                    <div class="input-box">
                                        <span class="details">Doyenné</span>
                                        <select name="doyenne" required>
                                            <optgroup label="--- Sélectionné ---">
                                            <?php
                                                $doy = $donFch['doyenne'];
                                                $reqDoy = $bdd->query("SELECT * FROM doyen WHERE idD = $doy");

                                                while ($datDoy = $reqDoy->fetch()) {
                                                    ?>
                                                        <option value="<?= $datDoy['idD'] ?>"><?= $datDoy['doyenne'] ?></option>
                                                    <?php
                                                }
                                            ?>
                                            </optgroup>
                                            
                                            <optgroup label="-- Modifier la sélection --">
                                            <!-- Ajout de la table Doyen -->
                                            <?php
                                                $repDoy = $bdd->query('SELECT * FROM doyen');

                                                while ($donDoy = $repDoy->fetch()) {
                                                    ?>
                                                        <option value="<?php echo $donDoy['idD']; ?>"><?php echo $donDoy['doyenne']; ?></option>
                                                    <?php
                                                }
                                            
                                            ?>
                                            </optgroup>
                                        </select>
                                    </div>

                                    <div class="input-box">
                                        <span class="details">Section de base</span>
                                        <input type="text" name="section" value="<?= $donFch['section'] ?>" required>
                                    </div>

                                    <div class="input-box">
                                        <span class="details">Nom et Prénoms</span>
                                        <input type="text" name="fullname" value="<?= $donFch['fullname'] ?>" style="text-transform: uppercase;" required>
                                    </div>

                                    <div class="input-box">
                                        <span class="details">Date de naissance</span>
                                        <input type="date" name="birthday" value="<?= $donFch['birthday'] ?>" required>
                                    </div>

                                    <div class="input-box">
                                        <span class="details">Fonction</span>
                                        <input type="text" name="job" value="<?= $donFch['job'] ?>" required>
                                    </div>

                                    <div class="input-box">
                                        <span class="details">Niveau</span>
                                        <select name="niveau" name="niveau" required>
                                            <optgroup label="--- Sélectionné ---">
                                            <?php
                                                $niv = $donFch['niveau'];
                                                $reqLev = $bdd->query("SELECT * FROM levels WHERE idL = $niv");

                                                while ($datLev = $reqLev->fetch()) {
                                                    ?>
                                                        <option value="<?= $datLev['idL'] ?>"><?= $datLev['niveau'] ?></option>
                                                    <?php
                                                }
                                            ?>
                                            </optgroup>
                                            
                                            <optgroup label="-- Modifier la sélection --">
                                            <!-- Ajout de la table Level -->
                                            <?php
                                                $repLev = $bdd->query('SELECT * FROM levels');

                                                while ($donLev = $repLev->fetch()) {
                                                    ?>
                                                        <option value="<?php echo $donLev['idL']; ?>"><?php echo $donLev['niveau']; ?></option>
                                                    <?php
                                                }
                                            ?>
                                            </optgroup>
                                        </select>
                                    </div>

                                    <div class="input-box">
                                        <span class="details">Contact</span>
                                        <input type="tel" name="phone" value="<?= $donFch['phone'] ?>" minlength="10" maxlength="10">
                                    </div>

                                    <div class="input-box">
                                        <span class="details">E-mail</span>
                                        <input type="email" name="email" value="<?= $donFch['email'] ?>">
                                    </div>

                                    <div class="input-box">
                                        <span class="details">Année d'adhésion</span>
                                        <input type="number" name="addyear" value="<?= $donFch['addyear'] ?>" minlength="4" maxlength="4">
                                    </div>

                                    <div class="input-box">
                                        <span class="details">Maladie chronique</span>
                                        <input type="text" name="sante" value="<?= $donFch['sante'] ?>">
                                    </div>

                                    <div class="input-box">
                                        <span class="details">Divers</span>
                                        <input type="text" name="divers" value="<?= $donFch['divers'] ?>">
                                    </div>

                                </div>
                            </li>
                            <li>
                                <h2>2- Parent</h2>
                                <hr>

                                <div class="user-details">
                                    
                                    <div class="input-box">
                                        <span class="details">Titre</span>
                                        <select name="titre" required>
                                            <optgroup label="--- Sélectionné ---">
                                            <?php
                                                $tit = $donFch['titre'];
                                                $reqTit = $bdd->query("SELECT * FROM title WHERE idT = $tit");

                                                while ($donTit = $reqTit->fetch()) {
                                                    ?>
                                                        <option value="<?= $donTit['idT'] ?>"><?= $donTit['titre'] ?></option>
                                                    <?php
                                                }
                                            ?>
                                            </optgroup>

                                            <optgroup label="-- Modifier la sélection --">
                                            <!-- Ajout de la table Title -->
                                            <?php
                                                $repTle = $bdd->query('SELECT * FROM title');

                                                while ($donTle = $repTle->fetch()) {
                                                    ?>
                                                        <option value="<?= $donTle['idT'] ?>"><?= $donTle['titre'] ?></option>
                                                    <?php
                                                }
                                            ?>
                                            </optgroup>
                                        </select>
                                        
                                    </div>
                                    
                                    <div class="input-box">
                                        <span class="details">Nom et Prénoms</span>
                                        <input type="text" name="pfullname" value="<?= $donFch['pfullname'] ?>" style="text-transform: uppercase;" required>
                                    </div>

                                    <div class="input-box">
                                        <span class="details">Profession</span>
                                        <input type="text" name="pjob" value="<?= $donFch['pjob'] ?>" required>
                                    </div>

                                    <div class="input-box">
                                        <span class="details">Quartier</span>
                                        <input type="text" name="quartier" value="<?= $donFch['quartier'] ?>" required>
                                    </div>

                                    <div class="input-box">
                                        <span class="details">Contact</span>
                                        <input type="tel" name="pnumber" value="<?= $donFch['pnumber'] ?>" minlength="10" maxlength="10" required>
                                    </div>

                                    <div class="input-box">
                                        <span class="details">Lien de parenté</span>
                                        <select name="parent" required>
                                            <optgroup label="--- Sélectionné ---">
                                            <?php
                                                $mif = $donFch['parent'];
                                                $reqMif = $bdd->query("SELECT * FROM mifa WHERE idM = $mif");

                                                while ($datMif = $reqMif->fetch()) {
                                                    ?>
                                                        <option value="<?= $datMif['idM'] ?>"><?= $datMif['parent'] ?></option>
                                                    <?php
                                                }
                                            ?>
                                            </optgroup>
                                            
                                            <optgroup label="-- Modifier la sélection --">
                                            <!-- Ajout de la table Mifa -->
                                            <?php
                                                $repMif = $bdd->query('SELECT * FROM mifa');

                                                while ($donMif = $repMif->fetch()) {
                                                    ?>
                                                        <option value="<?php echo $donMif['idM']; ?>"><?php echo $donMif['parent']; ?></option>
                                                    <?php
                                                }
                                            ?>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </li>

                            <div style="display: none;">
                                <!-- Jour du calendrier -->
                                <input type="text" name="jour" value="<?= $donFch['jour'] ?>" readonly>
                            </div>
                        <?php
                    }
                ?>

                <div class="button">
                    <input type="submit" name="modifier" value="Modifier">
                </div>
            </ul>
        </form>
    </section>
    <!-- End Add Area -->

    <?php include 'footer.php'; ?>

    <script src="script.js"></script>
</body>
</html>