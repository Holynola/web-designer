<?php
    include('dbConf.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Militant | CV-AV BOUAKE</title>
    <link href="../font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/add-cvav.css">
    <script src="jquery-3.6.0.min.js"></script>
</head>
<body>
    
    <?php include 'header.php'; ?>

    <!-- Add Area -->
    <section class="add-area" id="add">
        <h1 class="section-title">Ajouter un Militant</h1>
        <form action="add-fiche.php" method="post" enctype="multipart/form-data">
            <ul class="add-content">
                <li>
                    <h2>1- Militant</h2>
                    <hr>

                    <div class="user-details">

                        <div class="input-box">
                            <span class="details">Genre</span>
                            
                            <!-- Ajout de la table gender -->
                            <?php
                                $repGen = $bdd->query('SELECT * FROM gender');

                                while ($donGen = $repGen->fetch()) {
                                    ?>
                                        <input type="radio" name="genre" value="<?php echo $donGen['idG']; ?>" required>
                                        <label for="<?php echo $donGen['idG']; ?>"><?php echo $donGen['genre']; ?></label>
                                    <?php
                                }
                            ?>
                        </div>    
                    
                        <div class="input-box">
                            <span class="details">Doyenné</span>
                            <select name="doyenne" id="doyenne" required>
                                <option value="0"></option>
                                <!-- Ajout de la table Doyen -->
                                <?php
                                    $repDoy = $bdd->query('SELECT * FROM doyen');

                                    while ($donDoy = $repDoy->fetch()) {
                                        ?>
                                            <option value="<?php echo $donDoy['idD']; ?>"><?php echo $donDoy['doyenne']; ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="input-box">
                            <span class="details">Section de base</span>
                            <select name="section" id="section" required>
                                <option value="">Choisir le Doyenné</option>
                            </select>
                        </div>

                        <div class="input-box">
                            <span class="details">Nom et Prénoms</span>
                            <input type="text" name="fullname" style="text-transform: uppercase;" required>
                        </div>

                        <div class="input-box">
                            <span class="details">Date de naissance</span>
                            <input type="date" name="birthday" required>
                        </div>

                        <div class="input-box">
                            <span class="details">Fonction</span>
                            <input type="text" name="job" required>
                        </div>

                        <div class="input-box">
                            <span class="details">Niveau</span>
                            <select name="niveau" name="niveau" required>
                                <option value=""></option>
                                <!-- Ajout de la table Level -->
                                <?php
                                    $repLev = $bdd->query('SELECT * FROM levels');

                                    while ($donLev = $repLev->fetch()) {
                                        ?>
                                            <option value="<?php echo $donLev['idL']; ?>"><?php echo $donLev['niveau']; ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="input-box">
                            <span class="details">Contact</span>
                            <input type="tel" name="phone" minlength="10" maxlength="10">
                        </div>

                        <div class="input-box">
                            <span class="details">E-mail</span>
                            <input type="email" name="email">
                        </div>

                        <div class="input-box">
                            <span class="details">Année d'adhésion</span>
                            <input type="number" name="addyear" minlength="4" maxlength="4">
                        </div>

                        <div class="input-box">
                            <span class="details">Maladie chronique</span>
                            <input type="text" name="sante">
                        </div>

                        <div class="input-box">
                            <span class="details">Divers</span>
                            <input type="text" name="divers">
                        </div>

                    </div>
                </li>
                <li>
                    <h2>2- Parent</h2>
                    <hr>

                    <div class="user-details">
                        
                        <div class="input-box">
                            <span class="details">Titre</span>
                            
                            <!-- Ajout de la table Title -->
                            <?php
                                $repTle = $bdd->query('SELECT * FROM title');

                                while ($donTle = $repTle->fetch()) {
                                    ?>
                                        <input type="radio" name="titre" value="<?php echo $donTle['idT']; ?>" required>
                                        <label for="<?php echo $donTle['idT']; ?>"><?php echo $donTle['titre']; ?></label>
                                    <?php
                                }
                            ?>
                        </div>
                        
                        <div class="input-box">
                            <span class="details">Nom et Prénoms</span>
                            <input type="text" name="pfullname" style="text-transform: uppercase;" required>
                        </div>

                        <div class="input-box">
                            <span class="details">Profession</span>
                            <input type="text" name="pjob" required>
                        </div>

                        <div class="input-box">
                            <span class="details">Quartier</span>
                            <input type="text" name="quartier" required>
                        </div>

                        <div class="input-box">
                            <span class="details">Contact</span>
                            <input type="tel" name="pnumber" minlength="10" maxlength="10" required>
                        </div>

                        <div class="input-box">
                            <span class="details">Lien de parenté</span>
                            <select name="parent" required>
                                <option value=""></option>
                                <!-- Ajout de la table Mifa -->
                                <?php
                                    $repMif = $bdd->query('SELECT * FROM mifa');

                                    while ($donMif = $repMif->fetch()) {
                                        ?>
                                            <option value="<?php echo $donMif['idM']; ?>"><?php echo $donMif['parent']; ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </li>

                <div style="display: none;">
                    <!-- Jour du calendrier -->
                    <input type="text" name="jour" value="<?php echo date('d-m-Y'); ?>" readonly>
                </div>

                <div class="button">
                    <input type="submit" name="ajouter" value="Enregistrer">
                </div>
            </ul>
        </form>
    </section>
    <!-- End Add Area -->

    <?php include 'footer.php'; ?>

    <script src="add-cvav.js"></script>
    <script src="script.js"></script>
</body>
</html>