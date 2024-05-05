<?php

// info de connexion à la bdd
$dbname ="espace_admin";
$host ="localhost";
$username ="root";
$password = "";

// connexion à la bdd
$bdd = new PDO('mysql:host=localhost;dbname=espace_admin;charset=utf8;','root', '');

// vérification si la connexion à la bdd a fonctionné 
if (!$bdd){
    echo "message : Impossible de se connecter à la bdd"; 
    die();
}else {
    
}
?>