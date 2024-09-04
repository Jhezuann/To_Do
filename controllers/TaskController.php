<?php
session_start();
require_once '../config/config.php';
require_once '../models/Task.php';

$task = new Task($conn);

if (isset($_GET['delete'])) {
    $taskId = $_GET['delete'];

    if ($task->deleteTask($taskId)) {
        echo "<script>
                alert('Task deleted successfully.');
                window.location.href = '../views/dashboard.php';
              </script>";
    } else {
        echo "<script>
                alert('Error: Could not delete task.');
                window.location.href = '../views/dashboard.php';
              </script>";
    }
}
?>
