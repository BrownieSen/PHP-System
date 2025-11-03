<?php
// pages/login.php
session_start();
require_once __DIR__ . '/../classes/functions.php';

$err = '';
if (!empty($_POST['username'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    if (authenticate($username, $password)) {
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
        exit;
    } else {
        $err = 'Invalid credentials.';
    }
}

$success = $_SESSION['register_success'] ?? '';
unset($_SESSION['register_success']);
include __DIR__ . '/../includes/header.php';
?>
<main class="main-content no-sidebar">
  <div class="login-card">
    <h2>Login</h2>
    <?php if ($success): ?><div class="alert success"><?=htmlspecialchars($success)?></div><?php endif; ?>
    <?php if ($err): ?><div class="alert"><?=htmlspecialchars($err)?></div><?php endif; ?>
    <form method="POST" action="">
      <label>Username
        <input type="text" name="username" required />
      </label>
      <label>Password
        <input type="password" name="password" required />
      </label>
      <div class="form-row">
        <button class="btn" type="submit">Login</button>
        <a class="btn outline" href="register.php">Register</a>
      </div>
    </form>
    <p class="hint">Use the sample user: <code>admin / admin123</code></p>
  </div>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
