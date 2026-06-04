<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

$pdo = getDatabaseConnection();

$pdo->exec("CREATE TABLE IF NOT EXISTS watchlist (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT NOT NULL,
    media_type ENUM('film','serie','anime') NOT NULL,
    media_id   INT NOT NULL,
    added_at   DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_item (user_id, media_type, media_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (isset($_GET['check'])) {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['in_watchlist' => false]);
            exit;
        }
        $type = $_GET['type']     ?? '';
        $id   = (int)($_GET['media_id'] ?? 0);
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM watchlist WHERE user_id=? AND media_type=? AND media_id=?");
        $stmt->execute([(int)$_SESSION['user_id'], $type, $id]);
        echo json_encode(['in_watchlist' => (bool)$stmt->fetchColumn()]);
        exit;
    }

    $userId = (int)($_GET['user_id'] ?? 0);
    if ($userId === 0) {
        echo json_encode(['success' => false]);
        exit;
    }
    $stmt = $pdo->prepare("SELECT media_type, media_id, added_at FROM watchlist WHERE user_id=? ORDER BY added_at DESC");
    $stmt->execute([$userId]);
    echo json_encode(['success' => true, 'items' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'error' => 'Non connecté']);
        exit;
    }

    $data    = json_decode(file_get_contents('php://input'), true);
    $type    = $data['type']     ?? '';
    $mediaId = (int)($data['media_id'] ?? 0);
    $userId  = (int)$_SESSION['user_id'];

    if (!in_array($type, ['film', 'serie', 'anime']) || $mediaId === 0) {
        echo json_encode(['success' => false, 'error' => 'Données invalides']);
        exit;
    }

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM watchlist WHERE user_id=? AND media_type=? AND media_id=?");
    $stmt->execute([$userId, $type, $mediaId]);

    if ($stmt->fetchColumn()) {
        $stmt = $pdo->prepare("DELETE FROM watchlist WHERE user_id=? AND media_type=? AND media_id=?");
        $stmt->execute([$userId, $type, $mediaId]);
        echo json_encode(['success' => true, 'action' => 'removed']);
    } else {
        $stmt = $pdo->prepare("INSERT INTO watchlist (user_id, media_type, media_id) VALUES (?,?,?)");
        $stmt->execute([$userId, $type, $mediaId]);
        echo json_encode(['success' => true, 'action' => 'added']);
    }
    exit;
}

echo json_encode(['success' => false, 'error' => 'Méthode non supportée']);
