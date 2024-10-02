<?php
session_start();

require_once('../../core/db_connect.php');

$email = $_POST['email'];
$role = $_POST['role'];
$password = $_POST['password'];
echo $email;
// Kiểm tra thông tin đăng nhập
if (empty($email) || empty($password)) {
    header("Location: /app/views/pages/login.php?error=Vui lòng nhập đầy đủ thông tin.");
    exit();
} else {
    $login_query = "SELECT * FROM `users` WHERE `email`='$email' AND `role`='$role'";
    $login_query_run = mysqli_query($conn, $login_query);

    if (mysqli_num_rows($login_query_run) > 0) {
        $userdata   =   mysqli_fetch_array($login_query_run);
        if ($userdata['password'] == $password) {
            $_SESSION['auth'] = true;

            $userid     =   $userdata['id'];
            $username   =   $userdata['username'];
            $useremail  =   $userdata['email'];
            $userrole   =   $userdata['role'];

            $_SESSION['auth_user'] = [
                'id'    =>  $userid,
                'username'  =>  $username,
                'email' =>  $useremail,
                'role'  =>  $userrole
            ];
            header("Location: /"); // Đăng nhập thành công
            exit();
        } else {
            header("Location: /app/views/pages/login.php?error=Mật khẩu không đúng.");
            exit();
        }
    } else {
        header("Location: /app/views/pages/login.php?error=Email không đúng.");
        exit();
    }
}
