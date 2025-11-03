<?php
// includes/header.php
if (session_status() == PHP_SESSION_NONE) session_start();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Web Browniw</title>
  <link rel="stylesheet" href="/Web browniw/assets/css/style.css">
</head>
<body>
<header class="site-header">
  <div class="header-inner">
    <h1>Web Browniw</h1>
    <div class="header-right">
      <?php if (!empty($_SESSION['username'])): ?>
        <span class="who">Welcome, <?=htmlspecialchars($_SESSION['username'])?></span>
        <a class="btn small" href="/Web browniw/pages/logout.php">Logout</a>
      <?php endif; ?>
    </div>
  </div>
</header>
<div class="layout">
