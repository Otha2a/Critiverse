<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../config/database.php';

function getDB(): PDO
{
    $pdo = getDatabaseConnection();
    $pdo->exec("CREATE TABLE IF NOT EXISTS review_votes (
        id        INT AUTO_INCREMENT PRIMARY KEY,
        review_id INT NOT NULL,
        user_id   INT NOT NULL,
        vote      ENUM('like','dislike') NOT NULL,
        UNIQUE KEY unique_vote (review_id, user_id),
        INDEX idx_review (review_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    return $pdo;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Méthode non autorisée']);
    exit;
}

if (empty($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Connexion requise']);
    exit;
}

$body     = json_decode(file_get_contents('php://input'), true) ?? [];
$reviewId = (int)($body['review_id'] ?? 0);
$vote     = $body['vote'] ?? '';
$userId   = (int)$_SESSION['user_id'];

if ($reviewId <= 0 || !in_array($vote, ['like', 'dislike'], true)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Données invalides']);
    exit;
}

$pdo = getDB();

// Vote existant ?
$stmt = $pdo->prepare("SELECT id, vote FROM review_votes WHERE review_id = ? AND user_id = ?");
$stmt->execute([$reviewId, $userId]);
$existing = $stmt->fetch();

if ($existing) {
    if ($existing['vote'] === $vote) {
        // Même vote → on retire (toggle off)
        $pdo->prepare("DELETE FROM review_votes WHERE id = ?")->execute([$existing['id']]);
    } else {
        // Vote différent → on change
        $pdo->prepare("UPDATE review_votes SET vote = ? WHERE id = ?")->execute([$vote, $existing['id']]);
    }
} else {
    $pdo->prepare("INSERT INTO review_votes (review_id, user_id, vote) VALUES (?, ?, ?)")
        ->execute([$reviewId, $userId, $vote]);
}

// Retourner les nouveaux compteurs
$stmt = $pdo->prepare(
    "SELECT
        COUNT(CASE WHEN vote = 'like'    THEN 1 END) AS likes,
        COUNT(CASE WHEN vote = 'dislike' THEN 1 END) AS dislikes,
        MAX(CASE WHEN user_id = ?        THEN vote END) AS user_vote
     FROM review_votes
     WHERE review_id = ?"
);
$stmt->execute([$userId, $reviewId]);
$result = $stmt->fetch();

echo json_encode([
    'success'   => true,
    'likes'     => (int)$result['likes'],
    'dislikes'  => (int)$result['dislikes'],
    'user_vote' => $result['user_vote'],
]);
