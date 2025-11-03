<?php
require_once __DIR__ . '/../includes/auth.php';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/sidebar.php';
include_once __DIR__ . '/../classes/functions.php';
$users = read_users();
?>
<main class="main-content">
  <div class="card">
    <h2>Dashboard</h2>
    <p>Welcome to the simplified Web Browniw dashboard.</p>
    <div class="grid">
      <div class="card-mini">
        <h3>Total users</h3>
        <p><?=count($users)?></p>
      </div>
      <div class="card-mini">
        <h3>Info</h3>
        <p>Manage users via the Users page.</p>
      </div>
    </div>
  </div>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
