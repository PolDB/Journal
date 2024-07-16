<?php
session_start();
require '../models/PDO.php';
require '../models/fonctions.php';
banUser();
afficherBoutons();
include '../views/footer.html';
