<?php
class Task {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Método para eliminar una tarea por ID
    public function deleteTask($id) {
        $stmt = $this->conn->prepare("DELETE FROM tasks WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
