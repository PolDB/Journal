<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../controller/config.php';
if (!$_SESSION['mdp']) {
    header('location:../controller/connexionAdmin.php');
}

include '../views/membres.html';
$recupUsers = $bdd->query('SELECT * FROM membres');
while ($user = $recupUsers->fetch()) {
?><p><?= $user['pseudo']; ?> <a href="../controller/ban.php?id=<?= $user['id']; ?>">Bannir le membres</a></p><?php
                                                                                                            }

                                                                                                                ?>