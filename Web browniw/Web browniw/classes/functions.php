<?php
// classes/functions.php - shared helpers for reading/saving users
class User {
    private $fname;
    private $mname;
    private $lname;
    private $age;
    private $mobile;
    private $email;
    private $birthdate;
    private $gender;
    private $username;
    private $password;
    private $course;
    private $role;

    public function __construct($data) {
        $this->fname = $data['fname'] ?? '';
        $this->mname = $data['mname'] ?? '';
        $this->lname = $data['lname'] ?? '';
        $this->age = $data['age'] ?? '';
        $this->mobile = $data['mobile'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->birthdate = $data['birthdate'] ?? '';
        $this->gender = $data['gender'] ?? '';
        $this->username = $data['username'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->course = $data['course'] ?? '';
        $this->role = $data['role'] ?? '';
    }

    // --- Getters ---
    public function getFname() { return $this->fname; }
    public function getMname() { return $this->mname; }
    public function getLname() { return $this->lname; }
    public function getAge() { return $this->age; }
    public function getMobile() { return $this->mobile; }
    public function getEmail() { return $this->email; }
    public function getBirthdate() { return $this->birthdate; }
    public function getGender() { return $this->gender; }
    public function getUsername() { return $this->username; }
    public function getPassword() { return $this->password; }
    public function getCourse() { return $this->course; }
    public function getRole() { return $this->role; }

    // --- Setters ---
    public function setFname($val) { $this->fname = $val; }
    public function setMname($val) { $this->mname = $val; }
    public function setLname($val) { $this->lname = $val; }
    public function setAge($val) { $this->age = $val; }
    public function setMobile($val) { $this->mobile = $val; }
    public function setEmail($val) { $this->email = $val; }
    public function setBirthdate($val) { $this->birthdate = $val; }
    public function setGender($val) { $this->gender = $val; }
    public function setUsername($val) { $this->username = $val; }
    public function setPassword($val) { $this->password = $val; }
    public function setCourse($val) { $this->course = $val; }
    public function setRole($val) { $this->role = $val; }

    // Convert object back to array for saving
    public function toArray() {
        return [
            'fname' => $this->fname,
            'mname' => $this->mname,
            'lname' => $this->lname,
            'age' => $this->age,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'birthdate' => $this->birthdate,
            'gender' => $this->gender,
            'username' => $this->username,
            'password' => $this->password,
            'course' => $this->course,
            'role' => $this->role
        ];
    }
}
?>
<?php
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
        if (count($parts) >= 13) {
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
                'department' => $parts[10],
                'course' => $parts[11],
                'role' => isset($parts[12]) ? $parts[11] : ''
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
    $u['username'],$u['password'],$u['department'],$u['course'],$u['role']
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
