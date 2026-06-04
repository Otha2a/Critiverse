<?php

class UserController extends Controller
{
    public function show(): void
    {
        $username = trim($_GET['u'] ?? '');

        if ($username === '') {
            $this->redirect('/Critiverse/public/');
            return;
        }

        $userModel = new User();
        $target    = $userModel->findByUsername($username);

        if (!$target) {
            header('HTTP/1.1 404 Not Found');
            $this->render('user/not_found', ['title' => 'Utilisateur introuvable']);
            return;
        }

        $pdo = getDatabaseConnection();

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM reviews WHERE user_id = ?");
        $stmt->execute([$target['id']]);
        $reviewCount = (int)$stmt->fetchColumn();

        $stmt = $pdo->prepare(
            "SELECT media_type, media_id, score, comment, created_at
             FROM reviews WHERE user_id = ? ORDER BY created_at DESC LIMIT 6"
        );
        $stmt->execute([$target['id']]);
        $reviews = $stmt->fetchAll();

        $this->render('user/index', [
            'title'       => $target['username'] . ' - Critiverse',
            'target'      => $target,
            'reviewCount' => $reviewCount,
            'reviews'     => $reviews,
        ]);
    }
}
