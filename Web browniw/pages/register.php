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
          <div class="gender-group">
            <label><input type="radio" name="gender" value="Male" <?= (isset($old['gender']) && $old['gender']=='Male') ? 'checked':'' ?> required> Male</label>
            <label><input type="radio" name="gender" value="Female" <?= (isset($old['gender']) && $old['gender']=='Female') ? 'checked':'' ?> required> Female</label>
          </div>
        </label>
      </div>
      <div class="two-cols">
        <label>Username<input name="username" value="<?=htmlspecialchars($old['username'] ?? '')?>" required></label>
        <label>Password<input type="password" name="password" required></label>
      </div>
      <div class="two-cols">
        <label>Confirm Password<input type="password" name="confirm_password" required></label>
        <label>Course
          <select name="course" id="courseSelect" required>
            <option value="">Select</option>
            <option value="CS" <?= (isset($old['course']) && $old['course']=='CS')?'selected':'' ?>>CS</option>
            <option value="IT" <?= (isset($old['course']) && $old['course']=='IT')?'selected':'' ?>>IT</option>
            <option value="THM" <?= (isset($old['course']) && $old['course']=='THM')?'selected':'' ?>>THM</option>
          </select>
        </label>
      </div>

      <div class="form-row">
        <button class="btn" type="submit">Submit</button>
        <button class="btn outline" type="reset">Reset</button>
      </div>
    </form>
  </div>
</main>

<script>
// set role behaviour client-side (informational only)
document.addEventListener('DOMContentLoaded', function(){
  var course = document.getElementById('courseSelect');
  course.addEventListener('change', function(){
    // you asked role mapping: CS/IT => COMSOC, THM => HM
    // This demo does not show role field (role auto assigned server-side),
    // but we keep client-side hint if needed.
    var val = course.value;
    var hint = document.getElementById('roleHint');
    if(!hint){
      hint = document.createElement('div');
      hint.id = 'roleHint';
      hint.style.marginTop = '8px';
      course.parentNode.appendChild(hint);
    }
    if (val === 'THM') hint.textContent = 'Role will be: HM';
    else if (val === 'CS' || val === 'IT') hint.textContent = 'Role will be: COMSOC';
    else hint.textContent = '';
  });
});
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
