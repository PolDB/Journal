<?php // Correction du point-virgule manquant
require "config.php";
include "../models/fonctions.php";

afficherBoutons();

if (isset($_POST['valider'])) {
    if (!empty($_POST['pseudo']) && !empty($_POST['mdp'])) { // Utilisation de && au lieu de AND

        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mdp = $_POST['mdp'];

        // Récupération de l'utilisateur par pseudo
        $recupUser = $bdd->prepare('SELECT id, mdp FROM admin WHERE pseudo = ?');
        $recupUser->execute(array($pseudo));

        if ($recupUser->rowCount() > 0) {
            $user = $recupUser->fetch();
            // Vérification du mot de passe
            if (password_verify($mdp, $user['mdp'])) {
                $_SESSION['pseudo'] = $pseudo;
                $_SESSION['id'] = $user['id'];
                header("Location:../models/index.php"); // Redirection après une connexion réussie
                exit;
            } else {
                echo "Votre pseudo ou mot de passe est incorrect"; // Message d'erreur en cas de mot de passe incorrect
            }
        } else {
            echo "Votre pseudo ou mot de passe est incorrect"; // Message d'erreur en cas de pseudo incorrect
        }
    } else {
        echo "Veuillez remplir tous les champs..."; // Message d'erreur si des champs sont vides
    }
}

include '../views/connexionAdmin.html';
include '../views/footer.html';
