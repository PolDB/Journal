<?php
session_start();
require '../models/PDO.php';
require '../models/fonctions.php';
banUser();
include '../views/header.html';
include '../views/footer.html';
