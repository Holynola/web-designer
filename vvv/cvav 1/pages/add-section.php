<?php
    include('dbConf.php');

    if (isset($_POST["choi"])) {
        $doy = $_POST['choi'];

        if ($doy == "0") {
            echo '<option value="">Choisir le Doyenné</option>';
        } else {
            $query = $bdd->query("SELECT * FROM section WHERE idDoy = $doy ORDER BY paroisse ASC");

                echo '<option value="">Choisir la section</option>';
            while ($row = $query->fetch()) {
                echo '<option value="'.$row['idS'].'">'.$row['paroisse'].'</option>';
            }
        }
    }
?>

