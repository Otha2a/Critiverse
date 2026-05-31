<?php
// Gère la connexion à la base de données (PDO)

class Database {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = getDatabaseConnection();
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS contacts (
            id         INT AUTO_INCREMENT PRIMARY KEY,
            name       VARCHAR(100) NOT NULL,
            email      VARCHAR(100) NOT NULL,
            message    TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    }

    public function insertContact(string $name, string $email, string $message): bool {
        $stmt = $this->pdo->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $email, $message]);
    }
}