<?php
require '../controller/config.php';
include '../views/headerUser.html';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../views/sample.html';

$recupArticles = $bdd->query('SELECT * FROM articles');
$articles = $recupArticles->fetchAll();

for ($i = 0; $i < min(3, count($articles)); $i++) {
    $article = $articles[$i];
?>
    <div class="article" style="border: 1px solid black;">
        <h1><?= htmlspecialchars($article['Titre']); ?></h1>
        <p><?= htmlspecialchars($article['Contenu']); ?></p>
    </div>
<?php
}

include '../views/footer.html';
?>