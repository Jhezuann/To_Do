<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require '../config/config.php';

if (isset($_GET['id'])) {
    $task_id = $_GET['id'];

    // Consultar la tarea actual
    $sql = "SELECT * FROM tasks WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $task_id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $task = $result->fetch_assoc();
    $stmt->close();

    if (!$task) {
        echo "Task not found.";
        exit;
    }
} else {
    echo "No task ID provided.";
    exit;
}

// Actualizar la tarea
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $priority = $_POST['priority'];
    $status = $_POST['status'];

    // Verifica que los valores estén correctos
    var_dump($status);  // Para depurar y verificar el valor del status

    // Usa 's' para todos los parámetros, porque todos son cadenas en la consulta
    $sql = "UPDATE tasks SET title = ?, description = ?, due_date = ?, priority = ?, status = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $title, $description, $due_date, $priority, $status, $task_id, $_SESSION['user_id']);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error updating task: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Edit Task - ToDo App</title>
</head>
<body>
    <div class="edit-task-container">
        <h2>Edit Task</h2>
        <form method="POST">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($task['title']); ?>" required>
            
            <label for="description">Description</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($task['description']); ?></textarea>
            
            <label for="due_date">Due Date</label>
            <input type="date" id="due_date" name="due_date" value="<?php echo htmlspecialchars($task['due_date']); ?>" required>
            
            <label for="priority">Priority</label>
            <select id="priority" name="priority" required>
                <option value="low" <?php if($task['priority'] === 'low') echo 'selected'; ?>>Low</option>
                <option value="medium" <?php if($task['priority'] === 'medium') echo 'selected'; ?>>Medium</option>
                <option value="high" <?php if($task['priority'] === 'high') echo 'selected'; ?>>High</option>
            </select>
            
            <label for="status">Status</label>
            <select id="status" name="status" required>
                <option value="incomplete" <?php if($task['status'] === 'incomplete') echo 'selected'; ?>>Incomplete</option>
                <option value="complete" <?php if($task['status'] === 'complete') echo 'selected'; ?>>Complete</option>
            </select>
            
            <button type="submit">Update Task</button>
        </form>
        <a class="back-btn" href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
