<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: Register.html");
    exit();
}
$user = $_SESSION["user"];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration Success</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="register-box">
        <h2>Registration Successful!</h2>
        <p>Welcome, <?php echo htmlspecialchars($user["firstname"]) . " " . htmlspecialchars($user["lastname"]); ?>.</p>
        <p>Your account has been created successfully.</p>
        <a href="Login.html">Proceed to Login</a>
    </div>
</body>
</html>
