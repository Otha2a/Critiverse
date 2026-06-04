<?php

class WatchlistController extends Controller
{
    public function index(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/Critiverse/public/login');
            return;
        }

        require_once __DIR__ . '/../../config/database.php';
        $pdo    = getDatabaseConnection();
        $userId = (int)$_SESSION['user_id'];

        // Crée la table si elle n'existe pas encore
        $pdo->exec("CREATE TABLE IF NOT EXISTS watchlist (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            media_type ENUM('film','serie','anime') NOT NULL,
            media_id INT NOT NULL,
            added_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            UNIQUE KEY unique_item (user_id, media_type, media_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $stmt = $pdo->prepare(
            "SELECT media_type, media_id, added_at FROM watchlist
             WHERE user_id = ? ORDER BY added_at DESC"
        );
        $stmt->execute([$userId]);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->render('watchlist/index', [
            'title' => 'Ma Watchlist - Critiverse',
            'items' => $items,
        ]);
    }
}
