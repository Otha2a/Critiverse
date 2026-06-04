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
            plan       ENUM('gratuit','premium','pro') DEFAULT 'gratuit',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        // Migrations
        try {
            $this->pdo->exec("ALTER TABLE users ADD COLUMN plan ENUM('gratuit','premium','pro') DEFAULT 'gratuit'");
        } catch (PDOException) { /* colonne déjà existante */ }
        try {
            $this->pdo->exec("ALTER TABLE users ADD COLUMN bio TEXT NULL");
        } catch (PDOException) { /* colonne déjà existante */ }
        try {
            $this->pdo->exec("ALTER TABLE users ADD COLUMN avatar VARCHAR(255) NULL");
        } catch (PDOException) { /* colonne déjà existante */ }
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

    public function findByUsername(string $username): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    public function findById(int $id): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function updatePlan(int $id, string $plan): void
    {
        $stmt = $this->pdo->prepare("UPDATE users SET plan = ? WHERE id = ?");
        $stmt->execute([$plan, $id]);
    }

    public function updateInfo(int $id, string $username, string $email): void
    {
        $stmt = $this->pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
        $stmt->execute([$username, $email, $id]);
    }

    public function updateProfile(int $id, string $bio, ?string $avatar): void
    {
        if ($avatar !== null) {
            $stmt = $this->pdo->prepare("UPDATE users SET bio = ?, avatar = ? WHERE id = ?");
            $stmt->execute([$bio, $avatar, $id]);
        } else {
            $stmt = $this->pdo->prepare("UPDATE users SET bio = ? WHERE id = ?");
            $stmt->execute([$bio, $id]);
        }
    }

    public function updatePassword(int $id, string $password): void
    {
        $stmt = $this->pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([password_hash($password, PASSWORD_DEFAULT), $id]);
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
