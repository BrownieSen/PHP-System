<?php
// pages/register.php
session_start();
require_once __DIR__ . '/../classes/functions.php';
$errors = $_SESSION['register_errors'] ?? [];
$old = $_SESSION['register_old'] ?? [];
unset($_SESSION['register_errors'], $_SESSION['register_old']);
include __DIR__ . '/../includes/header.php';
?>
<main class="main-content no-sidebar">
  <div class="login-card">
    <h2>Signup</h2>
    <?php if (!empty($errors)): ?>
      <div class="alert">
        <?php foreach ($errors as $e) echo '<div>'.htmlspecialchars($e).'</div>'; ?>
      </div>
    <?php endif; ?>
    <form method="POST" action="/Web browniw/classes/register.php" id="regForm">
      <div class="two-cols">
        <label>First Name<input name="fname" value="<?=htmlspecialchars($old['fname'] ?? '')?>" required></label>
        <label>Middle Name<input name="mname" value="<?=htmlspecialchars($old['mname'] ?? '')?>"></label>
      </div>
      <div class="two-cols">
        <label>Last Name<input name="lname" value="<?=htmlspecialchars($old['lname'] ?? '')?>" required></label>
        <label>Age<input name="age" value="<?=htmlspecialchars($old['age'] ?? '')?>" required></label>
      </div>
      <div class="two-cols">
        <label>Mobile Number<input name="mobile" value="<?=htmlspecialchars($old['mobile'] ?? '')?>" required></label>
        <label>Email<input name="email" value="<?=htmlspecialchars($old['email'] ?? '')?>" required></label>
      </div>
      <div class="two-cols">
        <label>Birthdate<input type="date" name="birthdate" value="<?=htmlspecialchars($old['birthdate'] ?? '')?>" required></label>
        <label>Gender
          <select name="gender" id="gender" required>
            <option value="" disabled <?= (!isset($old['gender']) || $old['gender'] == '') ? 'selected' : '' ?>>Select Gender</option>
            <option value="Male" <?= (isset($old['gender']) && $old['gender'] == 'Male') ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= (isset($old['gender']) && $old['gender'] == 'Female') ? 'selected' : '' ?>>Female</option>
            <option value="Other" <?= (isset($old['gender']) && $old['gender'] == 'Other') ? 'selected' : '' ?>>Other</option>
          </select>
        </label>
      </div>
      <div class="two-cols">
        <label>Username<input name="username" value="<?=htmlspecialchars($old['username'] ?? '')?>" required></label>
        <label>Password<input type="password" name="password" required></label>
      </div>
      <div class="two-cols">
        <label>Confirm Password<input type="password" name="confirm_password" required></label>
        <label>Department
          <select name="department" id="departmentSelect" required>
            <option value="">Select Department</option>
            <option value="COMSOC" <?= (isset($old['department']) && $old['department'] == 'COMSOC') ? 'selected' : '' ?>>COMSOC</option>
            <option value="STIGMA" <?= (isset($old['department']) && $old['department'] == 'STIGMA') ? 'selected' : '' ?>>STIGMA</option>
            <option value="THM" <?= (isset($old['department']) && $old['department'] == 'THM') ? 'selected' : '' ?>>THM</option>
          </select>
        </label>

        <label>Course
          <select name="course" id="courseSelect" required>
            <option value="">Select Course</option>
          </select>
        </label>
      </div>

        <div class="form-row">
          <button class="btn" type="submit">Submit</button>
          <button class="btn outline" type="reset">Reset</button>
        </div>
        <div class="form-row" style="text-align:center;">
          <a class="btn outline" href="login.php">Back to Login</a>
        </div>
    </form>
  </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function(){
  const dept = document.getElementById('departmentSelect');
  const course = document.getElementById('courseSelect');

  dept.addEventListener('change', function() {
    const d = dept.value;
    course.innerHTML = '<option value="">Select Course</option>';
    if (d === 'COMSOC') {
      course.innerHTML += '<option value="CS">BS Computer Science</option>';
      course.innerHTML += '<option value="IT">BS Information Technology</option>';
    } else if (d === 'STIGMA') {
      course.innerHTML += '<option value="BMMA">Bachelor of Multimedia Arts</option>';
    } else if (d === 'THM') {
      course.innerHTML += '<option value="HM">Hospitality Management</option>';
      course.innerHTML += '<option value="TM">Tourism Management</option>';
    }
  });
});
</script>


<?php include __DIR__ . '/../includes/footer.php'; ?>
