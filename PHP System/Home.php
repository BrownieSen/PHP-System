<?php
session_start();

if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: Login.php");
    exit();
}

$currentUser = $_SESSION["user"];
$allUsers = isset($_SESSION["users"]) ? $_SESSION["users"] : [];
?>

<!DOCTYPE html>
<html>
<head>
  <title>Home</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="logout-wrapper">
    <form action="Logout.php" method="post">
      <input type="submit" value="Logout" class="logout-btn">
    </form>
  </div>

  <div class="top-banner">
    <h2>Welcome to the Home Page!</h2>
    <p>You are successfully logged in, <strong><?php echo htmlspecialchars($currentUser["username"]); ?></strong>.</p>
    <a href="EditProfile.php" class="edit-btn">Edit Profile</a>
</div>

  <div class="table-container">
    <table>
      <tr>
        <th>Username</th>
        <th>Age</th>
        <th>Gender</th>
        <th>Subjects</th>
      </tr>
      <?php foreach ($allUsers as $user): ?>
        <tr>
          <td><?php echo htmlspecialchars($user["username"]); ?></td>
          <td><?php echo htmlspecialchars($user["age"]); ?></td>
          <td><?php echo htmlspecialchars($user["gender"]); ?></td>
          <td>
            <?php
            if (isset($user["subjects"]) && is_array($user["subjects"])) {
                echo htmlspecialchars(implode(", ", $user["subjects"]));
            } else {
                echo "None";
            }
            ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</body>
</html>
