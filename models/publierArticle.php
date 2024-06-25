<?php
require '../models/PDO.php';
require '../models/fonctions.php';
afficherBoutons();
post();
include '../views/publierArticle.html';
include '../views/footer.html';
