<?php
session_start();

function afficherBoutons()
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
