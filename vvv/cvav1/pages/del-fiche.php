<?php
    include('dbConf.php');

    if (isset($_GET['id'])) {

        // Préparation de la requête
        $delDon = $bdd->prepare('DELETE FROM fiche WHERE idFiche=:id LIMIT 1');

        // Liaison du paramètre nommé
        $delDon->bindValue(':id', $_GET['id'], PDO::PARAM_INT);

        // Exécution de la requête
        $executeIsOk = $delDon->execute();

        if ($executeIsOk) {
            $message = 'Le Militant a été supprimé.';
            header("Location: work.php?delMsg=$message");
        } else {
            $message = "Le Militant n'a pas été supprimé.";
            header("Location: work.php?delMsg=$message");
        }
    
    } else {
        header('Location: work.php');
    }
    
?>