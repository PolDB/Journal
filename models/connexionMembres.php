<?php
include '../models/fonctions.php'; // Correction du point-virgule manquant
require '../models/PDO.php';
afficherBoutons();
loginUser();
include '../views/connexionMembres.html';
include '../views/footer.html';
