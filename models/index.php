<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(!$_SESSION['mdp']){
    header('location:connexionAdmin.php'); 
}
include 'index.html';
?>