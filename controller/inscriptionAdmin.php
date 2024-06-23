<?php
require "config.php";
require "../views/header.html";
require "../views/inscriptionMembres.html";

if (isset($_POST['envoi'])) {
    if (!empty($_POST['pseudo']) && !empty($_POST['mdp'])) { // Utilisation de && au lieu de and
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT); // Utilisation de password_hash

        // Insertion de l'administrateur dans la base de données
        $insertUser = $bdd->prepare('INSERT INTO admin (pseudo, mdp) VALUES (?, ?)');
        $insertUser->execute(array($pseudo, $mdp));

        // Récupération de l'administrateur pour créer la session
        $recupUser = $bdd->prepare('SELECT id FROM admin WHERE pseudo = ?');
        $recupUser->execute(array($pseudo));
        if ($recupUser->rowCount() > 0) {
            $user = $recupUser->fetch();
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['id'] = $user['id'];
            header("location:connexionAdmin.php"); // Redirection après une inscription réussie
            exit;
        }
    } else {
        echo 'Veuillez remplir tous les champs...';
    }
}

require "../views/footer.html";
