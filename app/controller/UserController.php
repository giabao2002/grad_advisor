<?php
require_once("/xampp/htdocs/core/db_connect.php");

class UserController
{
    private $conn;


    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function index($limit = PHP_INT_MAX, $offset = 0)
    {
        $query = "SELECT * FROM users LIMIT $offset, $limit";
        $result = mysqli_query($this->conn, $query);

        $users = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }

        return $users;
    }

    public function count()
    {
        $query = "SELECT COUNT(*) as total FROM users";
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }

    public function store($data)
    {
        $username = $data['username'];
        $email = $data['email'];
        $role = $data['role'];
        $password = $data['password'];
        $query = "INSERT INTO users (username, email, role, password) VALUES ('$username', '$email', '$role', '$password')";
        if (mysqli_query($this->conn, $query)) {
            return true;
        } else {
            return false;
        }
    }

    public function update($id, $data)
    {
        $username = $data['username'];
        $email = $data['email'];
        $oldPassword = $data['oldPassword'];
        $newPassword = $data['newPassword'];
        $password = $newPassword ? $newPassword : $oldPassword;
        var_dump($password);
        $role = $data['role'];
        $query = "UPDATE users SET username='$username', email='$email', role='$role', password='$password' WHERE id=$id";
        if (mysqli_query($this->conn, $query)) {
            return true;
        } else {
            return false;
        }
    }

    public function destroy($id)
    {
        $query = "DELETE FROM users WHERE id=$id";
        if (mysqli_query($this->conn, $query)) {
            return true;
        } else {
            return false;
        }
    }

    public function show($email)
    {
        $query = "SELECT * FROM students WHERE email ='$email'";
        $result = mysqli_query($this->conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $user;
        } else {
            return [];
        }
    }
}

// Khởi tạo controller
$userController = new UserController($conn);

// Xử lý các request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'store':
                $data = [
                    'username' => $_POST['username'],
                    'email' => $_POST['email'],
                    'role' => $_POST['role'],
                    'password' => $_POST['password']
                ];
                $userController->store($data);
                header("Location: /?page=accounts");
                break;
            case 'update':
                if (isset($_POST['newPassword']) && isset($_POST['confirmPassword']) && $_POST['newPassword'] != $_POST['confirmPassword']) {
                    $message = urlencode("Mật khẩu nhập lại không khớp");
                    header("Location: /?page=accounts&message=$message");
                    break;
                }
                $id = $_POST['id'];
                $data = [
                    'username' => $_POST['username'],
                    'email' => $_POST['email'],
                    'role' => $_POST['role'],
                    'oldPassword' => $_POST['oldPassword'],
                    'newPassword' => $_POST['newPassword'] ?? null
                ];
                $userController->update($id, $data);
                // header("Location: /?page=accounts");
                break;
            case 'destroy':
                $id = $_POST['id'];
                $userController->destroy($id);
                header("Location: /?page=accounts");
                break;
        }
    }
}
