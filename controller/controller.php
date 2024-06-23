<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!$_SESSION['id']) {
    header('location: ../models/sample.php');
}
include '../views/header.html';
include '../views/index.html';
include '../views/footer.html';
