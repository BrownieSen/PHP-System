<?php
session_start();

if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: Login.html");
    exit();
}

$username = isset($_POST["username"]) ? trim($_POST["username"]) : (isset($_SESSION["user"]["username"]) ? $_SESSION["user"]["username"] : "");

if ($username === "") {
    echo "Missing username.";
    exit();
}

// Collect updates
$firstname = trim($_POST["firstname"]);
$lastname = trim($_POST["lastname"]);
$middlename = trim($_POST["middlename"]);
$age = trim($_POST["age"]);
$gender = trim($_POST["gender"]);
$cellphone = trim($_POST["cellphone"]);
$email = trim($_POST["email"]);
$bday = trim($_POST["bday"]);
$department = trim($_POST["department"]);
$course = trim($_POST["course"]);

// Basic validation (you can expand)
$errors = array();
if ($firstname === "")
    $errors[] = "First name required.";
if ($lastname === "")
    $errors[] = "Last name required.";
if (!is_numeric($age) || $age <= 0)
    $errors[] = "Invalid age.";
if ($gender === "")
    $errors[] = "Gender required.";
if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    $errors[] = "Invalid email.";

if (!empty($errors)) {
    foreach ($errors as $e)
        echo "<p style='color:red;'>" . htmlspecialchars($e) . "</p>";
    echo "<p><a href='EditProfile.php'>Go back</a></p>";
    exit();
}

// Update session
$_SESSION["user"] = array(
    "username" => $username,
    "firstname" => $firstname,
    "lastname" => $lastname,
    "middlename" => $middlename,
    "age" => $age,
    "gender" => $gender,
    "cellphone" => $cellphone,
    "email" => $email,
    "bday" => $bday,
    "department" => $department,
    "course" => $course
);

// Update users.txt (canonical 12-field format)
// username|hash|firstname|lastname|middlename|age|gender|cellphone|email|bday|department|course
if (file_exists("users.txt")) {
    $lines = file("users.txt", FILE_IGNORE_NEW_LINES);
    $newLines = array();

    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === "")
            continue;
        $data = explode("|", $line);
        if ($data[0] === $username) {
            $hashedPassword = isset($data[1]) ? $data[1] : "";
            $newLineArray = array(
                $username,
                $hashedPassword,
                $firstname,
                $lastname,
                $middlename,
                $age,
                $gender,
                $cellphone,
                $email,
                $bday,
                $department,
                $course
            );
            $newLines[] = implode("|", $newLineArray);
        } else {
            $newLines[] = $line; // keep untouched
        }
    }

    // write back with a trailing newline
    file_put_contents("users.txt", implode(PHP_EOL, $newLines) . PHP_EOL);
}

header("Location: Home.php");
exit();
?>
