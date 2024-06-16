<?php
require '../controller/config.php';
include '../views/header.html';

if (session_status() === PHP_SESSION_NONE) { //session_status vérifie le statut actuel de la session, si PHP_SESSION_NONE, ça veut dire que la session n'existe pas alors elle va démarer, sans se code, la session se lançait en boucle infini.
    session_start();
}
if (!$_SESSION['mdp']) {
    header('location:../controller/connexionAdmin.php');
}
include '../views/articlesMembres.html';
$recupArticles = $bdd->query('SELECT * FROM articles');
while ($article = $recupArticles->fetch()) {
?>
    <div clas="article" style="border: 1px solid black;">
        <h1><?= $article['Titre']; ?></h1>
        <p><?= $article['Contenu']; ?></p>
    </div>
<?php
}

include '../views/footer.html';
