<?php // Correction du point-virgule manquant
require '../models/PDO.php';
include "../models/fonctions.php";
afficherBoutons();
loginAdmin();
include '../views/connexionAdmin.html';
include '../views/footer.html';
