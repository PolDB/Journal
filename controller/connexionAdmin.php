<?php
session_start(); // Vous avez oublié le point-virgule ici
require "config.php";
include '../views/header.html';
if (isset($_POST['valider'])) {
    if (!empty($_POST['pseudo']) && !empty($_POST['password'])) { // Utilisation de && au lieu de AND
        // $pseudo_par_defaut = "paul";
        // $mdp_par_defaut = "paul123"; // Correction du mot de passe par défaut

        $pseudo_saisi = htmlspecialchars($_POST['pseudo']);
        $mdp_saisi = sha1($_POST['password']);
        $recupUser = $bdd->prepare('SELECT id FROM admin WHERE pseudo = ? AND password = ?');
        $recupUser->execute(array($pseudo, $password));
        if ($recupUser->rowCount() > 0) {
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['password'] = $password;
            $_SESSION['id'] = $recupUser->fetch()['id'];
            header("Location:../models/index.php"); // Redirection après une connexion réussie

        } else {
            echo "Votre pseudo ou mot de passe est incorrect"; // Correction de la syntaxe echo
        }
    } else {
        echo "Veuillez remplir tous les champs..."; // Correction de la syntaxe echo et ajout d'une accolade manquante
    }
}

include '../views/connexionAdmin.html';
include '../views/footer.html';
