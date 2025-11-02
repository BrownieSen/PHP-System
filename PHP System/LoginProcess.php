<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $validUser = false;
    $userData = array();

    if (file_exists("users.txt")) {
        $file = fopen("users.txt", "r");
        while (($line = fgets($file)) !== false) {
            $line = trim($line);
            if ($line === "")
                continue;
            $data = explode("|", $line);

            // must have at least username and hash
            if (count($data) < 2)
                continue;

            $storedUser = $data[0];
            $storedHash = $data[1];

            if ($username === $storedUser && password_verify($password, $storedHash)) {
                // Map fields defensively depending on file format
                // New format: 12 fields -> username|hash|firstname|lastname|middlename|age|gender|cellphone|email|bday|department|course
                if (count($data) >= 12) {
                    list($storedUser, $storedHash, $firstname, $lastname, $middlename, $age, $gender, $cellphone, $email, $bday, $department, $course) = $data;
                } else {
                    // Older format (no gender). Fill missing fields to avoid notices.
                    // Expected older order used previously: username|hash|firstname|lastname|middlename|age|cellphone|email|bday|department|course
                    $data = array_pad($data, 12, "");
                    list($storedUser, $storedHash, $firstname, $lastname, $middlename, $age, $maybeCellphoneOrGender, $maybeCellphoneOrEmail, $maybeEmailOrBday, $maybeBdayOrDept, $maybeDeptOrCourse, $maybeCourse) = $data;
                    // Determine whether a gender exists or not: if the candidate is clearly numeric cellphone (digits), assume it's cellphone and gender missing
                    if (preg_match('/^[0-9]+$/', $maybeCellphoneOrGender)) {
                        $gender = ""; // missing
                        $cellphone = $maybeCellphoneOrGender;
                        $email = $maybeCellphoneOrEmail;
                        $bday = $maybeEmailOrBday;
                        $department = $maybeBdayOrDept;
                        $course = $maybeDeptOrCourse;
                    } else {
                        // fallback: treat position 6 as gender if not numeric
                        $gender = $maybeCellphoneOrGender;
                        $cellphone = $maybeCellphoneOrEmail;
                        $email = $maybeEmailOrBday;
                        $bday = $maybeBdayOrDept;
                        $department = $maybeDeptOrCourse;
                        $course = $maybeCourse;
                    }
                }

                $validUser = true;
                $userData = array(
                    "username" => $storedUser,
                    "firstname" => $firstname ?? "",
                    "lastname" => $lastname ?? "",
                    "middlename" => $middlename ?? "",
                    "age" => $age ?? "",
                    "gender" => $gender ?? "",
                    "cellphone" => $cellphone ?? "",
                    "email" => $email ?? "",
                    "bday" => $bday ?? "",
                    "department" => $department ?? "",
                    "course" => $course ?? ""
                );
                break;
            }
        }
        fclose($file);
    }

    if ($validUser) {
        $_SESSION["user"] = $userData;
        $_SESSION["logged_in"] = true;
        header("Location: Home.php");
        exit();
    } else {
        header("Location: Login.html?error=1");
        exit();
    }
}
?>
