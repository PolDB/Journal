
<?php
//si l'utilisateur est connecté avec son id, il accède à sa session, sinon il est redirigé vers la page d'acceuil 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!$_SESSION['id']) {
    header('location: ../models/sample.php');
}
include '../views/header.html';
include '../views/index.html';
include '../views/footer.html';
