<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { exit(0); }

require_once __DIR__ . '/../../config/database.php';

function getDB(): PDO
{
    $pdo = getDatabaseConnection();

    // Création de la table
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

    // Migration : ajout des colonnes user si elles n'existent pas encore
    try {
        $pdo->exec("ALTER TABLE reviews ADD COLUMN user_id INT NULL, ADD COLUMN username VARCHAR(50) NULL");
    } catch (PDOException) { /* colonnes déjà présentes */ }

    // Table des votes (nécessaire pour le LEFT JOIN dans le GET)
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

$method = $_SERVER['REQUEST_METHOD'];

// ── GET : récupérer les avis ─────────────────────────────────────────────────
if ($method === 'GET') {
    $type = $_GET['type'] ?? '';
    $id   = (int)($_GET['id'] ?? 0);

    if (!in_array($type, ['anime','film','serie'], true) || $id <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Paramètres invalides']);
        exit;
    }

    $userId = (int)($_SESSION['user_id'] ?? 0);
    $pdo    = getDB();
    $stmt   = $pdo->prepare(
        "SELECT r.id, r.score, r.comment, r.username, r.created_at,
                COUNT(CASE WHEN v.vote = 'like'    THEN 1 END) AS likes,
                COUNT(CASE WHEN v.vote = 'dislike' THEN 1 END) AS dislikes,
                MAX(CASE WHEN v.user_id = ?        THEN v.vote END) AS user_vote
         FROM reviews r
         LEFT JOIN review_votes v ON v.review_id = r.id
         WHERE r.media_type = ? AND r.media_id = ?
         GROUP BY r.id
         ORDER BY r.created_at DESC"
    );
    $stmt->execute([$userId, $type, $id]);
    echo json_encode(['success' => true, 'reviews' => $stmt->fetchAll()]);

// ── POST : enregistrer un avis ───────────────────────────────────────────────
} elseif ($method === 'POST') {

    // Vérification de la session
    if (empty($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['success' => false, 'error' => 'Vous devez être connecté pour poster un avis.']);
        exit;
    }

    $body    = json_decode(file_get_contents('php://input'), true) ?? [];
    $type    = $body['type']    ?? '';
    $id      = (int)($body['id']      ?? 0);
    $score   = (int)($body['score']   ?? 0);
    $comment = trim($body['comment']  ?? '');

    if (!in_array($type, ['anime','film','serie'], true)
        || $id <= 0
        || $score < 1 || $score > 5
        || $comment === ''
    ) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Données invalides']);
        exit;
    }

    $pdo  = getDB();
    $stmt = $pdo->prepare(
        "INSERT INTO reviews (media_type, media_id, score, comment, user_id, username)
         VALUES (?, ?, ?, ?, ?, ?)"
    );
    $stmt->execute([$type, $id, $score, $comment, $_SESSION['user_id'], $_SESSION['username']]);
    echo json_encode(['success' => true]);

} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Méthode non autorisée']);
}
