<?php
// classes/functions.php - shared helpers for reading/saving users
function data_file_path() {
    return __DIR__ . '/../user.txt';
}

function read_users() {
    $file = data_file_path();
    $users = [];
    if (!file_exists($file)) return $users;
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $parts = explode('|', trim($line));
        // fname|mname|lname|age|mobile|email|birthdate|gender|username|password|course|role
        if (count($parts) >= 11) {
            $users[] = [
                'fname' => $parts[0],
                'mname' => $parts[1],
                'lname' => $parts[2],
                'age' => $parts[3],
                'mobile' => $parts[4],
                'email' => $parts[5],
                'birthdate' => $parts[6],
                'gender' => $parts[7],
                'username' => $parts[8],
                'password' => $parts[9],
                'course' => $parts[10],
                'role' => isset($parts[11]) ? $parts[11] : ''
            ];
        }
    }
    return $users;
}

function save_users(array $users) {
    $file = data_file_path();
    $handle = fopen($file, 'c+');
    if (!$handle) return false;
    if (!flock($handle, LOCK_EX)) {
        fclose($handle);
        return false;
    }
    ftruncate($handle, 0);
    rewind($handle);
    foreach ($users as $u) {
        $line = implode('|', [
            $u['fname'],$u['mname'],$u['lname'],$u['age'],
            $u['mobile'],$u['email'],$u['birthdate'],$u['gender'],
            $u['username'],$u['password'],$u['course'],$u['role']
        ]) . "\n";
        fwrite($handle, $line);
    }
    fflush($handle);
    flock($handle, LOCK_UN);
    fclose($handle);
    return true;
}

function find_user($username) {
    $users = read_users();
    foreach ($users as $u) {
        if ($u['username'] === $username) return $u;
    }
    return null;
}

function username_exists($username) {
    return find_user($username) !== null;
}

function authenticate($username, $password) {
    $u = find_user($username);
    if (!$u) return false;
    return $u['password'] === $password;
}
