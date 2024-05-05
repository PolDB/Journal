<?php
require '../controller/config.php';
if (session_status() === PHP_SESSION_NONE) { //session_status vérifie le statut actuel de la session, si PHP_SESSION_NONE, ça veut dire que la session n'existe pas alors elle va démarer, sans se code, la session se lançait en boucle infini.
    session_start();
}
if (!$_SESSION['mdp']) {
    header('location:connexionAdmin.php');
}

if (isset($_POST['envoi'])) {
    if (!empty($_POST['titre']) and !empty($_POST['contenu'])) {
        $titre = htmlspecialchars($_POST['titre']);
        $contenu = nl2br(htmlspecialchars($_POST['contenu']));

        $insertArticle = $bdd->prepare('INSERT INTO articles(titre, contenu) VALUES (?,?)');
        $insertArticle->execute(array($titre, $contenu));

        echo "l'article a bien été envoyé";
    } else {
        echo "veuillez remplir tous les champs...";
    }
}
include '../views/publierArticle.html';
