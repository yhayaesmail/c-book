<?php
require_once 'models/User.php';

class AuthController
{
    private $userModel;

    public function __construct()
    {
        global $pdo;
        $this->userModel = new User($pdo);
    }

    public function register()
    {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = sanitize($_POST['name'] ?? '');
            $email = sanitize($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            if ($name && filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($password) >= 6) {
                try {
                    $this->userModel->register($name, $email, $password);
                    redirect('auth/login?registered=1');
                } catch (Exception $e) {
                    $error = 'Email already exists.';
                }
            } else {
                $error = 'Please enter valid data.';
            }
        }
        $title = 'Register';
        require 'views/auth/register.php';
    }

    public function login()
    {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->userModel->login($_POST['email'] ?? '', $_POST['password'] ?? '');
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['membership_type'] = $user['membership_type'] ?? 'none';
                redirect('home');
            } else {
                $error = 'Invalid credentials.';
            }
        }
        $title = 'Login';
        require 'views/auth/login.php';
    }

    public function logout()
    {
        session_destroy();
        redirect('auth/login');
    }

    public function verify()
    {
        $token = $_GET['token'] ?? '';
        if ($token !== '') {
            $this->userModel->verifyEmail($token);
        }
        redirect('auth/login?verified=1');
    }
}
