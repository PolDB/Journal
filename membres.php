<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();}
require 'config.php';
if(!$_SESSION['mdp']){
    header('location:connexionAdmin.php'); 
}

include 'membres.html';
$recupUsers = $bdd->query('SELECT * FROM membres');
while($user = $recupUsers->fetch()){
    ?><p><?= $user['pseudo'];?> <a href="ban.php?id=<?= $user['id']; ?>">Bannir le membres</a></p><?php
}

?>
