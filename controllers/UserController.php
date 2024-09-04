<?php
session_start();
require_once '../config/config.php';
require_once '../models/User.php';

$user = new User($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['register'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $registrationResult = $user->register($username, $email, $password);

        if ($registrationResult === true) {
            header("Location: ../views/login.php");
        } else {
            if ($registrationResult === 'username') {
                $message = "Error: Username already exists.";
            } elseif ($registrationResult === 'email') {
                $message = "Error: Email already exists.";
            } else {
                $message = "Error: Could not register user.";
            }

            // Mostrar mensaje de alerta y redirigir a register.php
            echo "<script>
                    alert('$message');
                    window.location.href = '../views/register.php';
                  </script>";
        }
    }

    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user_data = $user->login($email, $password);
        if ($user_data) {
            $_SESSION['user_id'] = $user_data['id'];
            header("Location: ../views/dashboard.php");
        } else {
            echo "<script>
                    alert('Invalid email or password.');
                    window.location.href = '../views/login.php';
                  </script>";
        }
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../views/login.php");
}
?>
