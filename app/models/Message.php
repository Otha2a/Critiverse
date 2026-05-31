<?php

class Message
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
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS messages (
            id          INT AUTO_INCREMENT PRIMARY KEY,
            sender_id   INT NOT NULL,
            receiver_id INT NOT NULL,
            content     TEXT NOT NULL,
            read_at     DATETIME NULL,
            created_at  DATETIME DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_sender   (sender_id),
            INDEX idx_receiver (receiver_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    }

    public function send(int $senderId, int $receiverId, string $content): void
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO messages (sender_id, receiver_id, content) VALUES (?, ?, ?)"
        );
        $stmt->execute([$senderId, $receiverId, $content]);
    }

    public function getConversation(int $userId, int $otherId): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT m.*, u.username AS sender_name,
                    (SELECT plan FROM users WHERE id = m.sender_id) AS sender_plan
             FROM messages m
             JOIN users u ON u.id = m.sender_id
             WHERE (m.sender_id = ? AND m.receiver_id = ?)
                OR (m.sender_id = ? AND m.receiver_id = ?)
             ORDER BY m.created_at ASC"
        );
        $stmt->execute([$userId, $otherId, $otherId, $userId]);
        return $stmt->fetchAll();
    }

    public function markAsRead(int $receiverId, int $senderId): void
    {
        $stmt = $this->pdo->prepare(
            "UPDATE messages SET read_at = NOW()
             WHERE receiver_id = ? AND sender_id = ? AND read_at IS NULL"
        );
        $stmt->execute([$receiverId, $senderId]);
    }

    public function getConversations(int $userId): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT u.id AS other_id, u.username AS other_name, u.plan AS other_plan,
                    m.content AS last_message, m.created_at AS last_at,
                    SUM(CASE WHEN m.receiver_id = ? AND m.read_at IS NULL THEN 1 ELSE 0 END) AS unread
             FROM messages m
             JOIN users u ON u.id = IF(m.sender_id = ?, m.receiver_id, m.sender_id)
             WHERE m.sender_id = ? OR m.receiver_id = ?
             GROUP BY u.id
             ORDER BY last_at DESC"
        );
        $stmt->execute([$userId, $userId, $userId, $userId]);
        return $stmt->fetchAll();
    }

    public function countUnread(int $userId): int
    {
        $stmt = $this->pdo->prepare(
            "SELECT COUNT(*) FROM messages WHERE receiver_id = ? AND read_at IS NULL"
        );
        $stmt->execute([$userId]);
        return (int)$stmt->fetchColumn();
    }

    public function getPremiumUsers(int $excludeId, string $search = ''): array
    {
        if ($search !== '') {
            $stmt = $this->pdo->prepare(
                "SELECT id, username, plan FROM users
                 WHERE id != ? AND plan IN ('premium','pro')
                 AND username LIKE ?
                 ORDER BY username LIMIT 20"
            );
            $stmt->execute([$excludeId, '%' . $search . '%']);
        } else {
            $stmt = $this->pdo->prepare(
                "SELECT id, username, plan FROM users
                 WHERE id != ? AND plan IN ('premium','pro')
                 ORDER BY username LIMIT 20"
            );
            $stmt->execute([$excludeId]);
        }
        return $stmt->fetchAll();
    }
}
