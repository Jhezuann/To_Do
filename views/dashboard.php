<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require '../config/config.php';

$user_id = $_SESSION['user_id'];

// Consulta para obtener las tareas del usuario
$sql = "SELECT * FROM tasks WHERE user_id = ? ORDER BY due_date ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$tasks = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Dashboard - ToDo App</title>
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h1>Welcome to your Dashboard</h1>
            <a class="logout-btn" href="../controllers/UserController.php?logout=true">Logout</a>
        </header>
        
        <!-- Mostrar las tareas del usuario -->
        <div class="tasks">
            <?php if (count($tasks) > 0): ?>
                <ul>
                    <?php foreach ($tasks as $task): ?>
                        <li class="task-item">
                            <div class="task-header">
                                <h3><?php echo htmlspecialchars($task['title']); ?></h3>
                                <div class="task-actions">
                                    <a href="edit_task.php?id=<?php echo $task['id']; ?>">Edit</a>
                                    <a href="delete_task.php?id=<?php echo $task['id']; ?>" onclick="return confirmDeletion();">Delete</a>
                                </div>
                            </div>
                            <p><?php echo htmlspecialchars($task['description']); ?></p>
                            <p class="task-meta">Due: <?php echo htmlspecialchars($task['due_date']); ?></p>
                            <p class="task-meta">Status: <?php echo htmlspecialchars($task['status']); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No tasks found. <a href="add_task.php">Add a new task</a>.</p>
            <?php endif; ?>
        </div>

        <a class="add-task-btn" href="add_task.php">Add New Task</a>
    </div>
</body>
</html>

<script>
function confirmDeletion() {
    return confirm("Are you sure you want to delete this task?");
}
</script>
