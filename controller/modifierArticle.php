<?php

include '..\controller\config.php';
if (isset($_GET['id']) and !empty($_GET['id'])) {
    $getid = $_GET['id'];

    $recupArticle = $bdd->prepare('SELECT * FROM articles WHERE Id = ?');
    $recupArticle->execute(array($getid));
    if ($recupArticle->rowCount() > 0) {
        $articleInfos = $recupArticle->fetch();
        $titre = $articleInfos['Titre'];
        $contenu = $articleInfos['Contenu'];

        if (isset($_POST['valider'])) {
            $titre_saisi = htmlspecialchars($_POST['Titre']);
            $contenu_saisi = nl2br(htmlspecialchars($_POST['Contenu']));

            $updateArticle = $bdd->prepare('UPDATE articles SET Titre = ?, Contenu = ? WHERE id = ?');
            $updateArticle->execute(array($titre_saisi, $contenu_saisi, $getid));

            header('Location:..\models\articles.php');
        } else {
            echo "Modifier votre article ci-desous !!";
        }
    } else {
        echo "aucun identifiant trouvé";
    }
}
include '..\views\modifierArticle.html';
