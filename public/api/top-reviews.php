<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../config/database.php';

$type  = $_GET['type']  ?? '';
$limit = min((int)($_GET['limit'] ?? 10), 20);

if (!in_array($type, ['anime', 'film', 'serie'], true)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Type invalide']);
    exit;
}

$userId = (int)($_SESSION['user_id'] ?? 0);

try {
    $pdo  = getDatabaseConnection();

    // Crée les tables si elles n'existent pas encore
    $pdo->exec("CREATE TABLE IF NOT EXISTS reviews (
        id         INT AUTO_INCREMENT PRIMARY KEY,
        media_type ENUM('anime','film','serie') NOT NULL,
        media_id   INT NOT NULL,
        score      TINYINT NOT NULL,
        comment    TEXT NOT NULL,
        user_id    INT NULL,
        username   VARCHAR(50) NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_media (media_type, media_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $pdo->exec("CREATE TABLE IF NOT EXISTS review_votes (
        id        INT AUTO_INCREMENT PRIMARY KEY,
        review_id INT NOT NULL,
        user_id   INT NOT NULL,
        vote      ENUM('like','dislike') NOT NULL,
        UNIQUE KEY unique_vote (review_id, user_id),
        INDEX idx_review (review_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $stmt = $pdo->prepare(
        "SELECT r.id, r.media_id, r.score, r.comment, r.username, r.created_at,
                COUNT(CASE WHEN v.vote = 'like'    THEN 1 END) AS likes,
                COUNT(CASE WHEN v.vote = 'dislike' THEN 1 END) AS dislikes,
                MAX(CASE WHEN v.user_id = ?        THEN v.vote END) AS user_vote
         FROM reviews r
         LEFT JOIN review_votes v ON v.review_id = r.id
         WHERE r.media_type = ?
         GROUP BY r.id
         ORDER BY r.score DESC, likes DESC, r.created_at DESC
         LIMIT {$limit}"
    );
    $stmt->execute([$userId, $type]);
    echo json_encode(['success' => true, 'reviews' => $stmt->fetchAll()]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Erreur base de données']);
}
