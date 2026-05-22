<?php

class User
{
    private PDO $pdo;

    public function __construct()
    {
        require_once __DIR__ . '/../../config/database.php';
        $this->pdo = getDatabaseConnection();
        $this->createTable();
    }

    private function createTable(): void
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS users (
            id         INT AUTO_INCREMENT PRIMARY KEY,
            username   VARCHAR(50)  NOT NULL UNIQUE,
            email      VARCHAR(100) NOT NULL UNIQUE,
            password   VARCHAR(255) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    }

    public function create(string $username, string $email, string $password): void
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO users (username, email, password) VALUES (?, ?, ?)"
        );
        $stmt->execute([$username, $email, password_hash($password, PASSWORD_DEFAULT)]);
    }

    public function findByEmail(string $email): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function emailExists(string $email): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return (bool)$stmt->fetchColumn();
    }

    public function usernameExists(string $username): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return (bool)$stmt->fetchColumn();
    }
}
