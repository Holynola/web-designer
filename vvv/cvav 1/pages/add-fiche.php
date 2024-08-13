<?php
    include('dbConf.php');

    $repFch = $bdd->query("SELECT idFiche FROM fiche");
    $count = $repFch->rowCount();

    if (isset($_POST['ajouter'])) {

        $genre = $_POST['genre'];
        $doyenne = $_POST['doyenne'];
        $section = $_POST['section'];
        $fullname = $_POST['fullname'];
        $birthday = $_POST['birthday'];
        $job = $_POST['job'];
        $niveau = $_POST['niveau'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $addyear = $_POST['addyear'];
        $sante = $_POST['sante'];
        $divers = $_POST['divers'];
        $titre = $_POST['titre'];
        $pfullname = $_POST['pfullname'];
        $pjob = $_POST['pjob'];
        $quartier = $_POST['quartier'];
        $pnumber = $_POST['pnumber'];
        $parent = $_POST['parent'];
        $jour = $_POST['jour'];

        $req = $bdd->prepare('INSERT INTO fiche (genre, doyenne, section, fullname, birthday, job, niveau, phone, email, addyear, sante, divers, titre, pfullname, pjob, quartier, pnumber, parent, jour) VALUES (:genre, :doyenne, :section, :fullname, :birthday, :job, :niveau, :phone, :email, :addyear, :sante, :divers, :titre, :pfullname, :pjob, :quartier, :pnumber, :parent, :jour)');
        $req->execute(array(
            'genre' => $genre,
            'doyenne' => $doyenne,
            'section' => $section,
            'fullname' => $fullname,
            'birthday' => $birthday,
            'job' => $job,
            'niveau' => $niveau,
            'phone' => $phone,
            'email' => $email,
            'addyear' => $addyear,
            'sante' => $sante,
            'divers' => $divers,
            'titre' => $titre,
            'pfullname' => $pfullname,
            'pjob' => $pjob,
            'quartier' => $quartier,
            'pnumber' => $pnumber,
            'parent' => $parent,
            'jour' => $jour
        ));

        header('Location: work.php?nbFiche='.$count);
    } else {
        header('Location: add-cvav.php');
    }

?>