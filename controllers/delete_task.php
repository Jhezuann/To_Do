<?php
require '../config/config.php';  // Asegúrate de que el archivo config.php tiene la conexión a la base de datos
require 'TaskController.php';    // Incluye el controlador de tareas

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['id'];
    $user_id = $_SESSION['user_id'];

    $taskController = new TaskController($conn);
    if ($taskController->deleteTask($task_id, $user_id)) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error deleting task.";
    }
} else {
    echo "Invalid request.";
}
?>
