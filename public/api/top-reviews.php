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
         LIMIT ?"
    );
    $stmt->execute([$userId, $type, $limit]);
    echo json_encode(['success' => true, 'reviews' => $stmt->fetchAll()]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Erreur base de données']);
}
