<?php
session_start(); // Vous avez oublié le point-virgule ici

if (isset($_POST['valider'])) {
    if (!empty($_POST['pseudo']) && !empty($_POST['mdp'])) { // Utilisation de && au lieu de AND
        $pseudo_par_defaut = "paul";
        $mdp_par_defaut = "paul123"; // Correction du mot de passe par défaut

        $pseudo_saisi = htmlspecialchars($_POST['pseudo']);
        $mdp_saisi = htmlspecialchars($_POST['mdp']);

        if ($pseudo_saisi == $pseudo_par_defaut && $mdp_saisi == $mdp_par_defaut) {
            $_SESSION['mdp'] = $pseudo_saisi; // Correction de l'assignation de la session
            // Vous avez oublié de spécifier une valeur pour $_SESSION['mdp'], 
            // je suppose que vous vouliez stocker le mot de passe, mais ce n'est pas recommandé
            header("Location:../models/index.php"); // Redirection après une connexion réussie

        } else {
            echo "Votre pseudo ou mot de passe est incorrect"; // Correction de la syntaxe echo
        }
    } else {
        echo "Veuillez remplir tous les champs..."; // Correction de la syntaxe echo et ajout d'une accolade manquante
    }
}


include '../views/header.html';
include '../views/connexionAdmin.html';
include '../views/footer.html';
