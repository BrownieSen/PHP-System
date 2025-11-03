<?php
// classes/register.php - handle registration POST
require_once __DIR__ . '/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/register.php');
    exit;
}

// collect and validate
$fname = trim($_POST['fname'] ?? '');
$mname = trim($_POST['mname'] ?? '');
$lname = trim($_POST['lname'] ?? '');
$age = trim($_POST['age'] ?? '');
$mobile = trim($_POST['mobile'] ?? '');
$email = trim($_POST['email'] ?? '');
$birthdate = trim($_POST['birthdate'] ?? '');
$gender = trim($_POST['gender'] ?? '');
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');
$confirm = trim($_POST['confirm_password'] ?? '');
$department = $_POST['department'];
$course = $_POST['course'];
// determine role based on course
// determine role based on department
$role = '';
if ($department === 'COMSOC') {
    $role = 'COMSOC';
} elseif ($department === 'STIGMA') {
    $role = 'STIGMA';
} elseif ($department === 'THM') {
    $role = 'THM';
}


$errors = [];

if ($fname === '' || $lname === '' || $age === '' || $mobile === '' || $email === '' || $birthdate === '' || $gender === '' || $username === '' || $password === '' || $confirm === '' || $department === '' || $course === '') {
    $errors[] = 'All fields are required.';
}
if ($password !== $confirm) {
    $errors[] = 'Passwords do not match.';
}
if (username_exists($username)) {
    $errors[] = 'Username already exists.';
}

if (!empty($errors)) {
    // redirect back with errors (simple approach using session)
    session_start();
    $_SESSION['register_errors'] = $errors;
    $_SESSION['register_old'] = $_POST;
    header('Location: ../pages/register.php');
    exit;
}

// save user
$users = read_users();
$users[] = [
    'fname'=>$fname,'mname'=>$mname,'lname'=>$lname,'age'=>$age,
    'mobile'=>$mobile,'email'=>$email,'birthdate'=>$birthdate,'gender'=>$gender,
    'username'=>$username,'password'=>$password,
    'department'=>$department,'course'=>$course,'role'=>$role
];

if (save_users($users)) {
    session_start();
    $_SESSION['register_success'] = 'Account created successfully. You can now login.';
    header('Location: ../pages/login.php');
    exit;
} else {
    session_start();
    $_SESSION['register_errors'] = ['Failed to save user.'];
    $_SESSION['register_old'] = $_POST;
    header('Location: ../pages/register.php');
    exit;
}
