<?php
require "config.php";
require "../views/headerUser.html";
require "../views/inscriptionMembres.html";

if (isset($_POST['envoi'])) {
    if (!empty($_POST['pseudo']) && !empty($_POST['mdp'])) {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mdp = $_POST['mdp'];

        // Hash du mot de passe
        $hashedMdp = password_hash($mdp, PASSWORD_DEFAULT);

        // Insertion de l'utilisateur dans la base de données
        $insertUser = $bdd->prepare('INSERT INTO membres (pseudo, mdp) VALUES (?, ?)');
        $insertUser->execute(array($pseudo, $hashedMdp));

        // Récupération de l'utilisateur pour créer la session
        $recupUser = $bdd->prepare('SELECT id FROM membres WHERE pseudo = ?');
        $recupUser->execute(array($pseudo));
        if ($recupUser->rowCount() > 0) {
            $user = $recupUser->fetch();
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['id'] = $user['id'];
            header("Location:connexionMembres.php");
            exit;
        }
    } else {
        echo 'Veuillez remplir tous les champs...';
    }
}
require "../views/footer.html";
