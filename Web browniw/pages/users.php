<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../classes/functions.php';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/sidebar.php';

$users = read_users();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_user'])) {
        $del = $_POST['del_username'];
        foreach ($users as $i => $u) {
            if ($u['username'] === $del) {
                array_splice($users, $i, 1);
                break;
            }
        }
        if (save_users($users)) $message = 'User deleted.';
        else $message = 'Failed to delete.';
        $users = read_users();
    }
}

// editing handled on this page via query param ?edit=username
$editUser = null;
if (!empty($_GET['edit'])) {
    $editUser = find_user($_GET['edit']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_edit'])) {
    $orig = $_POST['orig_username'];
    foreach ($users as $i => $u) {
        if ($u['username'] === $orig) {
            $users[$i]['fname'] = $_POST['edit_fname'];
            $users[$i]['mname'] = $_POST['edit_mname'];
            $users[$i]['lname'] = $_POST['edit_lname'];
            $users[$i]['age'] = $_POST['edit_age'];
            $users[$i]['mobile'] = $_POST['edit_mobile'];
            $users[$i]['email'] = $_POST['edit_email'];
            $users[$i]['birthdate'] = $_POST['edit_birthdate'];
            $users[$i]['gender'] = $_POST['edit_gender'];
            $users[$i]['username'] = $_POST['edit_username'];
            $users[$i]['password'] = $_POST['edit_password'];
            $users[$i]['course'] = $_POST['edit_course'];
            $users[$i]['role'] = $_POST['edit_role']; // renamed as department
            break;
        }
    }
    if (save_users($users)) {
        $message = 'Changes saved.';
        $users = read_users();
    } else {
        $message = 'Failed to save changes.';
    }
    $editUser = null;
}

include_once __DIR__ . '/../classes/functions.php';
?>
<main class="main-content">
  <div class="card">
    <h2>Users Management</h2>
    <?php if ($message): ?><div class="alert"><?=htmlspecialchars($message)?></div><?php endif; ?>

    <section class="panel">
      <h3>Existing Users</h3>
      <table class="table">
        <thead><tr><th>Name</th><th>Username</th><th>Course</th><th>Role</th><th>Actions</th></tr></thead>
        <tbody>
          <?php foreach ($users as $u): ?>
            <tr>
              <td><?=htmlspecialchars($u['fname'].' '.$u['mname'].' '.$u['lname'])?></td>
              <td><?=htmlspecialchars($u['username'])?></td>
              <td><?=htmlspecialchars($u['course'])?></td>
              <td><?=htmlspecialchars($u['role'])?></td>
              <td>
                <a class="btn small" href="?edit=<?=urlencode($u['username'])?>">Edit</a>
                <form style="display:inline" method="POST" onsubmit="return confirm('Delete user <?=htmlspecialchars($u['username'])?>?');">
                  <input type="hidden" name="del_username" value="<?=htmlspecialchars($u['username'])?>">
                  <button class="btn small danger" name="delete_user" type="submit">Delete</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>

    <?php if ($editUser): ?>
      <section class="panel">
        <h3>Edit User: <?=htmlspecialchars($editUser['username'])?></h3>
        <form method="POST" class="edit-form">
          <input type="hidden" name="orig_username" value="<?=htmlspecialchars($editUser['username'])?>">
          <div class="two-cols">
            <label>First Name<input name="edit_fname" value="<?=htmlspecialchars($editUser['fname'])?>" required></label>
            <label>Middle Name<input name="edit_mname" value="<?=htmlspecialchars($editUser['mname'])?>"></label>
          </div>
          <div class="two-cols">
            <label>Last Name<input name="edit_lname" value="<?=htmlspecialchars($editUser['lname'])?>" required></label>
            <label>Age<input name="edit_age" value="<?=htmlspecialchars($editUser['age'])?>" required></label>
          </div>
          <div class="two-cols">
            <label>Mobile<input name="edit_mobile" value="<?=htmlspecialchars($editUser['mobile'])?>" required></label>
            <label>Email<input name="edit_email" value="<?=htmlspecialchars($editUser['email'])?>" required></label>
          </div>
          <div class="two-cols">
            <label>Birthdate<input type="date" name="edit_birthdate" value="<?=htmlspecialchars($editUser['birthdate'])?>" required></label>
            <label>Gender
              <select name="edit_gender" required>
                <option value="">Select Gender</option>
                <option value="Male" <?= ($editUser['gender'] == 'Male') ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= ($editUser['gender'] == 'Female') ? 'selected' : '' ?>>Female</option>
                <option value="Other" <?= ($editUser['gender'] == 'Other') ? 'selected' : '' ?>>Other</option>
              </select>
            </label>
          </div>
          <div class="two-cols">
            <label>Username<input name="edit_username" value="<?=htmlspecialchars($editUser['username'])?>" required></label>
            <label>Password<input name="edit_password" value="<?=htmlspecialchars($editUser['password'])?>" required></label>
          </div>
        <div class="two-cols">
          <label>Department
            <select name="edit_role" id="edit_role" required>
              <option value="COMSOC" <?= ($editUser['role'] == 'COMSOC') ? 'selected' : '' ?>>COMSOC</option>
              <option value="STIGMA" <?= ($editUser['role'] == 'STIGMA') ? 'selected' : '' ?>>STIGMA</option>
              <option value="THM" <?= ($editUser['role'] == 'THM') ? 'selected' : '' ?>>THM</option>
            </select>
          </label>

          <label>Course
            <select name="edit_course" id="edit_course" required>
              <option value="CS" <?= ($editUser['course'] == 'CS') ? 'selected' : '' ?>>CS</option>
              <option value="IT" <?= ($editUser['course'] == 'IT') ? 'selected' : '' ?>>IT</option>
              <option value="BMMA" <?= ($editUser['course'] == 'BMMA') ? 'selected' : '' ?>>BMMA</option>
              <option value="HM" <?= ($editUser['course'] == 'HM') ? 'selected' : '' ?>>HM</option>
              <option value="TM" <?= ($editUser['course'] == 'TM') ? 'selected' : '' ?>>TM</option>
            </select>
          </label>
        </div>

        <div class="form-row">
          <button class="btn" name="save_edit" type="submit">Save</button>
          <a class="btn outline" href="users.php">Cancel</a>
        </div>
        </form>


        <script type="text/javascript">
        document.getElementById('edit_role').addEventListener('change', function() {
          const dept = this.value;
          const courseSelect = document.getElementById('edit_course');
          courseSelect.innerHTML = '';

          if (dept === 'COMSOC') {
            courseSelect.innerHTML = `
              <option value="CS">CS</option>
              <option value="IT">IT</option>`;
          } else if (dept === 'STIGMA') {
            courseSelect.innerHTML = `<option value="BMMA">BMMA</option>`;
          } else if (dept === 'THM') {
            courseSelect.innerHTML = `
              <option value="HM">HM</option>
              <option value="TM">TM</option>`;
          }
        });
        </script>
      </section>
    <?php endif; ?>

  </div>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
