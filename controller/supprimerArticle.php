<?php
require 'config.php'; 
if(isset($_GET['id']) AND !empty($_GET['id'])){
    $getid = $_GET['id'];
    $recupArticle=$bdd->prepare('SELECT * FROM articles WHERE id = ?');
    $recupArticle->execute(array($getid));
    if($recupArticle->rowCount() > 0){
        $deleteArticle = $bdd->prepare('DELETE FROM articles WHERE id = ?');
        $deleteArticle->execute(array($getid));
        header('Location:articles.php');
    }else{
        echo "aucun article trouvé";
    }

} else {
    echo "aucun identifiant trouvé";
}