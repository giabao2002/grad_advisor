<?php
class AuthMiddleware
{
    public static function handle()
    {
        if (!isset($_SESSION['auth'])) {
            header('Location: app/views/pages/login.php');
            exit();
        }
    }
}
?>