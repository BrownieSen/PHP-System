<?php
// Load authentication, helpers, header, sidebar
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../classes/functions.php'; // includes User class
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/sidebar.php';

// Load users
$users = read_users();
$message = '';

// Handle deleting a user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $del = $_POST['del_username'];
    foreach ($users as $i => $u) {
        if ($u['username'] === $del) {
            array_splice($users, $i, 1);
            break;
        }
    }
    $message = save_users($users) ? 'User deleted.' : 'Failed to delete.';
    $users = read_users(); // reload after deletion
}

// Handle editing user (via ?edit=username)
$editUser = null;
if (!empty($_GET['edit'])) {
    $editUser = find_user($_GET['edit']);
}

// Handle saving edits
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_edit'])) {
    $orig = $_POST['orig_username'];

    foreach ($users as $i => $u) {
        $user = new User($u);

        if ($user->getUsername() === $orig) {
            $user->setFname($_POST['edit_fname']);
            $user->setMname($_POST['edit_mname']);
            $user->setLname($_POST['edit_lname']);
            $user->setAge($_POST['edit_age']);
            $user->setMobile($_POST['edit_mobile']);
            $user->setEmail($_POST['edit_email']);
            $user->setBirthdate($_POST['edit_birthdate']);
            $user->setGender($_POST['edit_gender']);
            $user->setUsername($_POST['edit_username']);
            $user->setPassword($_POST['edit_password']);
            $user->setCourse($_POST['edit_course']);
            $user->setRole($_POST['edit_role']);

            $users[$i] = $user->toArray(); // save back to array
            break;
        }
    }

    $message = save_users($users) ? 'Changes saved.' : 'Failed to save changes.';
    $users = read_users(); // reload users
    $editUser = null; // close edit form
}
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
        <?php foreach ($users as $u):
            $user = new User($u);
            ?>
        <tr>
            <td><?= htmlspecialchars($user->getFname() . ' ' . $user->getMname() . ' ' . $user->getLname()) ?></td>
            <td><?= htmlspecialchars($user->getUsername()) ?></td>
            <td><?= htmlspecialchars($user->getCourse()) ?></td>
            <td><?= htmlspecialchars($user->getRole()) ?></td>
            <td>
                <a class="btn small" href="?edit=<?= urlencode($user->getUsername()) ?>">Edit</a>
                <form style="display:inline" method="POST" onsubmit="return confirm('Delete user <?= htmlspecialchars($user->getUsername()) ?>?');">
                    <input type="hidden" name="del_username" value="<?= htmlspecialchars($user->getUsername()) ?>">
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
