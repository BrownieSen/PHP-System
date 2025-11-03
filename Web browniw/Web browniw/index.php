<?php
// index.php - redirect to login or dashboard
session_start();
if (!empty($_SESSION['username'])) {
    header('Location: pages/dashboard.php');
    exit;
} else {
    header('Location: pages/login.php');
    exit;
}
