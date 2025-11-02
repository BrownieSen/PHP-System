<?php
session_start();
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: Login.html");
    exit();
}

$currentUser = isset($_SESSION["user"]) ? $_SESSION["user"] : array();

// Use safe retrieval to avoid undefined-key warnings
$firstname = isset($currentUser["firstname"]) ? $currentUser["firstname"] : "";
$lastname = isset($currentUser["lastname"]) ? $currentUser["lastname"] : "";
$middlename = isset($currentUser["middlename"]) ? $currentUser["middlename"] : "";
$age = isset($currentUser["age"]) ? $currentUser["age"] : "";
$gender = isset($currentUser["gender"]) ? $currentUser["gender"] : "";
$cellphone = isset($currentUser["cellphone"]) ? $currentUser["cellphone"] : "";
$email = isset($currentUser["email"]) ? $currentUser["email"] : "";
$bday = isset($currentUser["bday"]) ? $currentUser["bday"] : "";
$department = isset($currentUser["department"]) ? $currentUser["department"] : "";
$course = isset($currentUser["course"]) ? $currentUser["course"] : "";
$username = isset($currentUser["username"]) ? $currentUser["username"] : "";
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Profile</title>
  <link rel="stylesheet" href="Style.css">
</head>
<body class="register-page">
  <div class="register-container">
    <h2>Edit Profile</h2>

    <form action="EditProcess.php" method="post">
      <div class="form-group">
        <label>First Name:</label>
        <input type="text" name="firstname" value="<?php echo htmlspecialchars($firstname); ?>" required>
      </div>

      <div class="form-group">
        <label>Last Name:</label>
        <input type="text" name="lastname" value="<?php echo htmlspecialchars($lastname); ?>" required>
      </div>

      <div class="form-group">
        <label>Middle Name:</label>
        <input type="text" name="middlename" value="<?php echo htmlspecialchars($middlename); ?>">
      </div>

      <div class="form-group">
        <label>Age:</label>
        <input type="number" name="age" value="<?php echo htmlspecialchars($age); ?>" required>
      </div>

      <div class="form-group">
        <label>Gender:</label>
        <select name="gender" required>
          <option value="">-- Select Gender --</option>
          <option value="Male" <?php if ($gender === "Male")
              echo "selected"; ?>>Male</option>
          <option value="Female" <?php if ($gender === "Female")
              echo "selected"; ?>>Female</option>
          <option value="Other" <?php if ($gender === "Other")
              echo "selected"; ?>>Other</option>
        </select>
      </div>

      <div class="form-group">
        <label>Cellphone:</label>
        <input type="text" name="cellphone" value="<?php echo htmlspecialchars($cellphone); ?>" required>
      </div>

      <div class="form-group">
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
      </div>

      <div class="form-group">
        <label>Birthday:</label>
        <input type="date" name="bday" value="<?php echo htmlspecialchars($bday); ?>" required>
      </div>

      <div class="form-group">
        <label>Department:</label>
        <select name="department" required>
          <option value="">-- Select Department --</option>
          <option value="COMSOC" <?php if ($department === "COMSOC")
              echo "selected"; ?>>COMSOC</option>
          <option value="STIGMA" <?php if ($department === "STIGMA")
              echo "selected"; ?>>STIGMA</option>
          <option value="THM" <?php if ($department === "THM")
              echo "selected"; ?>>THM</option>
        </select>
      </div>

      <div class="form-group">
        <label>Course:</label>
        <select name="course" required>
          <option value="">-- Select Course --</option>
          <option value="BSCS" <?php if ($course === "BSCS")
              echo "selected"; ?>>BSCS</option>
          <option value="BSIT" <?php if ($course === "BSIT")
              echo "selected"; ?>>BSIT</option>
          <option value="BSEMC" <?php if ($course === "BSEMC")
              echo "selected"; ?>>BSEMC</option>
        </select>
      </div>

      <!-- hidden username so we know which user to update -->
      <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">

      <div class="submit-row" style="grid-column: span 2; text-align: center;">
        <input type="submit" value="Save Changes">
      </div>
    </form>
  </div>
</body>
</html>
