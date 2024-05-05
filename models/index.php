<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!$_SESSION['mdp']) {
    header('location:../controller/connexionAdmin.php');
}
include 'index.html';
