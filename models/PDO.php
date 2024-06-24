<?php

// info de connexion à la bdd
$dbname = "espace_admin";
$host = "localhost";
$username = "root";
$password = "";

try {
    // connexion à la bdd
    $bdd = new PDO('mysql:host=localhost;dbname=espace_admin;charset=utf8;', 'root', '');

    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // vérification si la connexion à la bdd a fonctionné 
    if (!$bdd) {
        echo "message : Impossible de se connecter à la bdd";
        die();
    } else {
    }
} catch (PDOException $e) {
    // Capture des exceptions PDO (erreurs de base de données)
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    die();
}
