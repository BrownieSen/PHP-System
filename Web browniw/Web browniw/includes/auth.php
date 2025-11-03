<?php
// includes/auth.php - protect pages
if (session_status() == PHP_SESSION_NONE) session_start();
if (empty($_SESSION['username'])) {
    header('Location: ../pages/login.php');
    exit;
}
