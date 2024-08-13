<?php

session_start();

date_default_timezone_set('Africa/Abidjan');

// Paramètres de connexion
$host = '127.0.0.1'; // Nom de l'hôte
$dbname = 'c163cav'; // Nom de la base de données
$user = 'c163Holynola'; // Nom d'utilisateur
$pass = '#x3BKjhC'; // Mot de passe
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

// Connexion à la base de données
try {
    $bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass, $options);
} catch(PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
