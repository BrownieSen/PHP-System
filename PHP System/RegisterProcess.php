<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);
    $middlename = trim($_POST["middlename"]);
    $gender = trim($_POST["gender"]);
    $age = trim($_POST["age"]);
    $cellphone = trim($_POST["cellphone"]);
    $email = trim($_POST["email"]);
    $bday = trim($_POST["bday"]);
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);
    $department = trim($_POST["department"]);
    $course = trim($_POST["course"]);

    $errors = [];

    // --- VALIDATION ---
    if (empty($firstname))
        $errors[] = "First name is required.";
    if (empty($lastname))
        $errors[] = "Last name is required.";
    if (empty($age) || !is_numeric($age) || $age <= 0 || $age > 120)
        $errors[] = "Enter a valid age.";
    if (empty($gender))
        $errors[] = "Gender is required.";
    if (empty($cellphone) || !preg_match("/^[0-9]{10,15}$/", $cellphone))
        $errors[] = "Enter a valid cellphone number.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
        $errors[] = "Enter a valid email address.";
    if (empty($bday))
        $errors[] = "Birthday is required.";
    if (empty($username))
        $errors[] = "Username is required.";
    if (empty($password))
        $errors[] = "Password is required.";
    if ($password !== $confirm_password)
        $errors[] = "Passwords do not match.";
    if (empty($department))
        $errors[] = "Department is required.";
    if (empty($course))
        $errors[] = "Course is required.";

    // Check if username already exists in users.txt
    if (file_exists("users.txt")) {
        $file = fopen("users.txt", "r");
        while (($line = fgets($file)) !== false) {
            $data = explode("|", trim($line));
            if (count($data) > 0 && $data[0] === $username) {
                $errors[] = "Username already taken.";
                break;
            }
        }
        fclose($file);
    }

    // --- SUCCESS ---
    if (empty($errors)) {
        // Save to session
        $_SESSION["user"] = [
            "firstname" => $firstname,
            "lastname" => $lastname,
            "middlename" => $middlename,
            "age" => $age,
            "gender" => $gender,
            "cellphone" => $cellphone,
            "email" => $email,
            "bday" => $bday,
            "username" => $username,
            "department" => $department,
            "course" => $course
        ];


        // Save to users.txt
        $file = fopen("users.txt", "a");
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // safer than plain text
        $line = $username . "|" . $hashedPassword . "|" . $firstname . "|" . $lastname . "|" . $middlename . "|" .
            $age . "|" . $gender . "|" . $cellphone . "|" . $email . "|" . $bday . "|" . $department . "|" . $course . "\n";
        fwrite($file, $line);
        fclose($file);

        header("Location: RegisterSucess.php");
        exit();
    } else {
        // Show errors
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
        echo "<p><a href='Register.html'>Go back</a></p>";
    }
}
?>
