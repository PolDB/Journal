<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();}
    require 'config.php';
    if(isset($_GET['id']) AND !empty($_GET['id'])) {
        $getid = $_GET['id'];
        $recupUser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
        $recupUser->execute(array($getid));
        if($recupUser->rowCount()>0){
            $banUser = $bdd->prepare('DELETE FROM membres WHERE id = ?');
            $banUser->execute(array($getid));

            header('location:membres.php');
        }else{
            echo "aucun membre n'a été trouvé";
        }
    }else{
        echo "l'identifiant n'a pas été trouvé"; 
    }

?>