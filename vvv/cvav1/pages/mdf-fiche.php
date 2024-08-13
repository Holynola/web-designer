<?php
    include('dbConf.php');

    if (isset($_POST['modifier'])) {

        if (isset($_GET['idt'])) {
            
            // Préparation de la requête
            $mdfDon = $bdd->prepare('UPDATE fiche SET genre = :genre , doyenne = :doyenne , section = :section ,
             fullname = :fullname , birthday = :birthday , job = :job , niveau = :niveau , phone = :phone ,
              email = :email , addyear = :addyear , sante = :sante , divers = :divers , titre = :titre ,
               pfullname = :pfullname , pjob = :pjob , quartier = :quartier , pnumber = :pnumber ,
                parent = :parent , jour = :jour WHERE idFiche =:idf LIMIT 1');

            // Liaison du paramètre nommé
            $mdfDon->bindValue(':idf', $_GET['idt'], PDO::PARAM_INT);
            $mdfDon->bindParam(':genre', $_POST['genre']);
            $mdfDon->bindParam(':doyenne', $_POST['doyenne']);
            $mdfDon->bindParam(':section', $_POST['section']);
            $mdfDon->bindParam(':fullname', $_POST['fullname']);
            $mdfDon->bindParam(':birthday', $_POST['birthday']);
            $mdfDon->bindParam(':job', $_POST['job']);
            $mdfDon->bindParam(':niveau', $_POST['niveau']);
            $mdfDon->bindParam(':phone', $_POST['phone']);
            $mdfDon->bindParam(':email', $_POST['email']);
            $mdfDon->bindParam(':addyear', $_POST['addyear']);
            $mdfDon->bindParam(':sante', $_POST['sante']);
            $mdfDon->bindParam(':divers', $_POST['divers']);
            $mdfDon->bindParam(':titre', $_POST['titre']);
            $mdfDon->bindParam(':pfullname', $_POST['pfullname']);
            $mdfDon->bindParam(':pjob', $_POST['pjob']);
            $mdfDon->bindParam(':quartier', $_POST['quartier']);
            $mdfDon->bindParam(':pnumber', $_POST['pnumber']);
            $mdfDon->bindParam(':parent', $_POST['parent']);
            $mdfDon->bindParam(':jour', $_POST['jour']);

            // Exécution de la requête
            $executeIsOk = $mdfDon->execute();

            if ($executeIsOk) {
                $message = 'Modification effectuée avec succès.';
                header("Location: work.php?mdfMsg=$message");
            } else {
                $message ='Modification non effectuée.';
                header("Location: work.php?mdfMsg=$message");
            }
        
        } else {
            header("Location: work.php");
        }

    } else {
        header('Location: work.php');
    }

?>