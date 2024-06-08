<?php
session_start(); // Vous avez oublié le point-virgule ici
require "config.php";
include '../views/header.html';
if (isset($_POST['valider'])) {
    if (!empty($_POST['pseudo']) && !empty($_POST['mdp'])) { // Utilisation de && au lieu de AND
        // $pseudo_par_defaut = "paul";
        // $mdp_par_defaut = "paul123"; // Correction du mot de passe par défaut

        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mdp = sha1($_POST['mdp']);

        $recupUser = $bdd->prepare('SELECT id FROM membres WHERE pseudo = ? AND mdp = ?');
        $recupUser->execute(array($pseudo, $mdp));
        if ($recupUser->rowCount() > 0) {
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['mdp'] = $mdp;
            $_SESSION['id'] = $recupUser->fetch()['id'];
            header("Location:../models/articlesMembres.php"); // Redirection après une connexion réussie

        } else {
            echo "Votre pseudo ou mot de passe est incorrect"; // Correction de la syntaxe echo
        }
    } else {
        echo "Veuillez remplir tous les champs..."; // Correction de la syntaxe echo et ajout d'une accolade manquante
    }
}

include '../views/connexionMembres.html';
include '../views/footer.html';
