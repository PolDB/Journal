<?php
include '../models/fonctions.php';
require '../models/PDO.php';
afficherBoutons();
loginUser();
include '../views/connexionMembres.html';
include '../views/footer.html';
