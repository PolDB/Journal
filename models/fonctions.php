

<?php
//fichier php regroupant les actions de mon site sous formes de fonctions//
session_start();
require '../models/PDO.php';
function afficherBoutons() // fonction qui affiche les boutons de connexion membre et inscription si l'utilisateur n'est pas connu, et les retirent lorsque l'on se situe sur une page ou l'id  utilisateur est connu
{
    // Vérifier si l'utilisateur est connecté en vérifiant la présence d'une variable de session par exemple
    if (isset($_SESSION['id'])) {
        // Si connecté, afficher le bouton de déconnexion
        include '../views/header.html';
    } else {
        // Si non connecté, afficher les boutons de connexion et d'inscription
        include '../views/headerUser.html';
    }
}

function banUser() //fonctions qui ban les users 
{
    global $bdd;
    if (isset($_GET['id']) and !empty($_GET['id'])) {
        $getid = $_GET['id'];
        $recupUser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
        $recupUser->execute(array($getid));
        if ($recupUser->rowCount() > 0) {
            $banUser = $bdd->prepare('DELETE FROM membres WHERE id = ?');
            $banUser->execute(array($getid));

            header('location:../models/membres.php');
        } else {
            echo "aucun membre n'a été trouvé";
        }
    } else {
        echo "l'identifiant n'a pas été trouvé";
    }
}

function loginAdmin() //connexion de l'admin
{
    global $bdd;
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
}

function loginUser() //connexion de l'utilisateur
{
    global $bdd;
    if (isset($_POST['valider'])) {
        if (!empty($_POST['pseudo']) && !empty($_POST['mdp'])) { // Utilisation de && au lieu de AND

            $pseudo = htmlspecialchars($_POST['pseudo']);
            $mdp = $_POST['mdp'];

            // Récupération de l'utilisateur par pseudo
            $recupUser = $bdd->prepare('SELECT id, mdp FROM membres WHERE pseudo = ?');
            $recupUser->execute(array($pseudo));

            if ($recupUser->rowCount() > 0) {
                $user = $recupUser->fetch();
                // Vérification du mot de passe
                if (password_verify($mdp, $user['mdp'])) {
                    $_SESSION['pseudo'] = $pseudo;
                    $_SESSION['id'] = $user['id'];
                    header("Location:../models/articlesMembres.php"); // Redirection après une connexion réussie
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
}

function signUpAdmin() //inss ription de l'admin
{
    global $bdd;

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
}

function signUpUsers() //inscription de l'utilisateur
{
    global $bdd;
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
}

function updatePost() //mise à jour de la donnée
{
    global $bdd;
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

                header('Location:../models/articles.php');
            } else {
                echo "";
            }
        } else {
            echo "aucun identifiant trouvé";
        }
    }
}

function post() //post d'une nouvelle donnée
{
    global $bdd;
    if (!$_SESSION['id']) {
        header('location:../controller/connexionAdmin.php');
    }

    if (isset($_POST['envoi'])) {
        if (!empty($_POST['titre']) and !empty($_POST['contenu'])) {
            $titre = htmlspecialchars($_POST['titre']);
            $contenu = nl2br(htmlspecialchars($_POST['contenu']));

            $insertArticle = $bdd->prepare('INSERT INTO articles(titre, contenu) VALUES (?,?)');
            $insertArticle->execute(array($titre, $contenu));

            echo "l'article a bien été envoyé";
            header('location:../models/articles.php');
        } else {
            echo "veuillez remplir tous les champs...";
        }
    }
}

function deletePost() //supression de la donnée
{
    global $bdd;
    if (isset($_GET['id']) and !empty($_GET['id'])) {
        $getid = $_GET['id'];
        $recupArticle = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
        $recupArticle->execute(array($getid));
        if ($recupArticle->rowCount() > 0) {
            $deleteArticle = $bdd->prepare('DELETE FROM articles WHERE id = ?');
            $deleteArticle->execute(array($getid));
            header('Location:../models/articles.php');
        } else {
            echo "aucun article trouvé";
        }
    } else {
        echo "aucun identifiant trouvé";
    }
}

function postUsers() // affichage des post si on on est membre
{
    global $bdd;
    // Inclusion du fichier articlesMembres.html
    include '../views/articlesMembres.html';

    // Récupération des articles depuis la base de données
    $recupArticles = $bdd->query('SELECT * FROM articles');

    // Parcours des résultats et affichage des articles
    while ($article = $recupArticles->fetch()) {
        echo '<div class="article" style="border: 1px solid black;">';
        echo '<h1>' . htmlspecialchars($article['Titre']) . '</h1>';
        echo '<p>' . htmlspecialchars($article['Contenu']) . '</p>';
        echo '</div>';
    }
}

function postAdmin() //affichage des post sii on est admin, avec les opitons de crud de modification et de supression
{
    global $bdd;
    if (!$_SESSION['id']) {
        header('location:../models/connexionAdmin.php');
    }
    include '../views/articles.html';
    $recupArticles = $bdd->query('SELECT * FROM articles');
    while ($article = $recupArticles->fetch()) {

        while ($article = $recupArticles->fetch()) {
            echo '<div class="article" style="border: 1px solid black;">';
            echo '<h1>' . htmlspecialchars($article['Titre']) . '</h1>';
            echo '<p>' . htmlspecialchars($article['Contenu']) . '</p>';
            echo '<a href="../models/supprimerArticle.php?id=' . $article['Id'] . '">';
            echo '<button>Supprimer l\'article</button></a>';
            echo '<a href="../models/modifierArticle.php?id=' . $article['Id'] . '">';
            echo '<button>Modifier l\'article</button></a>';
            echo '</div>';
        }
    }
}

function logout() //déconnexion 
{
    $_SESSION = array();
    session_destroy();
    header('location:../models/sample.php');
}

function displayUsers() //affichage des utilisateurs que l'on peut supprimer si l'on est admin
{
    global $bdd;
    if (!isset($_SESSION['id'])) {
        header('Location: ../models/connexionAdmin.php');
        exit();
    }

    include '../views/header.html';
    include '../views/membres.html';

    $recupUsers = $bdd->query('SELECT * FROM membres');
    while ($user = $recupUsers->fetch()) {
        echo '<p>' . htmlspecialchars($user['pseudo']) . ' <a href="../models/ban.php?id=' . $user['id'] . '">Bannir le membre</a></p>';
    }
}

function displaySample() //affichgae de la page d'acceuil lorsque l'on est pas pas connecté
{
    global $bdd;
    $recupArticles = $bdd->query('SELECT * FROM articles');
    $articles = $recupArticles->fetchAll();

    for ($i = 0; $i < min(3, count($articles)); $i++) {
        $article = $articles[$i];
        echo '<div class="article" style="border: 1px solid black;">';
        echo '<h1>' . htmlspecialchars($article['Titre']) . '</h1>';
        echo '<p>' . htmlspecialchars($article['Contenu']) . '</p>';
        echo '</div>';
    }
}
