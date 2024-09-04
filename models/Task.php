<?php
class Task {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addTask($user_id, $title, $description, $due_date, $priority) {
        $query = "INSERT INTO tasks (user_id, title, description, due_date, priority) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("issss", $user_id, $title, $description, $due_date, $priority);
        return $stmt->execute();
    }

    public function getTasksByUser($user_id) {
        $query = "SELECT * FROM tasks WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
