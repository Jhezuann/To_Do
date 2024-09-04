<?php
// Incluye la conexión a la base de datos
require '../config/config.php';

if (isset($_GET['id'])) {
    $taskId = $_GET['id'];

    // Preparar y ejecutar la consulta SQL para eliminar la tarea
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $taskId);

    if ($stmt->execute()) {
        // Redirige al dashboard después de eliminar la tarea
        header("Location: dashboard.php?message=Task+Deleted+Successfully");
    } else {
        // Muestra un mensaje de error si no se pudo eliminar la tarea
        echo "Error deleting task: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
