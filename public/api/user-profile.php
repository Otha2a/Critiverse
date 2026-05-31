<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../../config/database.php';

$username = trim($_GET['username'] ?? '');
if ($username === '') {
    http_response_code(400);
    echo json_encode(['success' => false]);
    exit;
}

try {
    $pdo = getDatabaseConnection();

    // Infos utilisateur
    $stmt = $pdo->prepare("SELECT id, username, plan, created_at FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo json_encode(['success' => false, 'error' => 'Utilisateur introuvable']);
        exit;
    }

    // Nombre de critiques
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM reviews WHERE user_id = ?");
    $stmt->execute([$user['id']]);
    $reviewCount = (int)$stmt->fetchColumn();

    // 3 dernières critiques
    $stmt = $pdo->prepare(
        "SELECT media_type, media_id, score, comment, created_at
         FROM reviews WHERE user_id = ?
         ORDER BY created_at DESC LIMIT 3"
    );
    $stmt->execute([$user['id']]);
    $recentReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success'       => true,
        'username'      => $user['username'],
        'plan'          => $user['plan'] ?? 'gratuit',
        'member_since'  => $user['created_at'],
        'review_count'  => $reviewCount,
        'reviews'       => $recentReviews,
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false]);
}
