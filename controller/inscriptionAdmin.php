<?php
session_start();
require "config.php";
require "../views/header.html";
require "../views\inscriptionAdmin.html";

if (isset($_POST['envoi'])) {
    if (!empty($_POST['pseudo']) and !empty($_POST['password'])) {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mdp = sha1($_POST['password']);
        $insertUser = $bdd->prepare('INSERT INTO admin (pseudo, mdp)VALUES(?, ?)');
        $insertUser->execute(array($pseudo, $password));

        $recupUser = $bdd->prepare('SELECT id FROM admin WHERE pseudo = ? AND mdp = ?');
        $recupUser->execute(array($pseudo, $password));
        if ($recupUser->rowCount() > 0) {
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['password'] = $password;
            $_SESSION['id'] = $recupUser->fetch()['id'];
        }
        echo $_SESSION['id'];
    } else {
        echo 'veuillez remplir tous les champs...';
    }
}
require "../views/footer.html";
