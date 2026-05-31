<?php

class ProfileController extends Controller
{
    public function index(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/Critiverse/public/login');
            return;
        }

        $userModel = new User();
        $user      = $userModel->findById((int)$_SESSION['user_id']);

        $pdo = getDatabaseConnection();

        // Nombre de critiques
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM reviews WHERE user_id = ?");
        $stmt->execute([$user['id']]);
        $reviewCount = (int)$stmt->fetchColumn();

        // Dernières critiques
        $stmt = $pdo->prepare(
            "SELECT media_type, media_id, score, comment, created_at
             FROM reviews WHERE user_id = ? ORDER BY created_at DESC LIMIT 5"
        );
        $stmt->execute([$user['id']]);
        $reviews = $stmt->fetchAll();

        $success = $_GET['success'] ?? null;
        $error   = $_SESSION['profile_error'] ?? null;
        unset($_SESSION['profile_error']);

        $this->render('profile/index', [
            'title'       => 'Mon profil - Critiverse',
            'user'        => $user,
            'reviewCount' => $reviewCount,
            'reviews'     => $reviews,
            'success'     => $success,
            'error'       => $error,
        ]);
    }

    public function update(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/Critiverse/public/login');
            return;
        }

        $userId    = (int)$_SESSION['user_id'];
        $userModel = new User();
        $user      = $userModel->findById($userId);

        $action = $_POST['action'] ?? '';

        if ($action === 'update_info') {
            $username = trim($_POST['username'] ?? '');
            $email    = trim($_POST['email']    ?? '');

            if (mb_strlen($username) < 3) {
                $_SESSION['profile_error'] = 'Le pseudo doit faire au moins 3 caractères.';
                $this->redirect('/Critiverse/public/profile');
                return;
            }

            // Vérifier unicité si modifié
            if ($username !== $user['username'] && $userModel->usernameExists($username)) {
                $_SESSION['profile_error'] = 'Ce pseudo est déjà pris.';
                $this->redirect('/Critiverse/public/profile');
                return;
            }
            if ($email !== $user['email'] && $userModel->emailExists($email)) {
                $_SESSION['profile_error'] = 'Cet email est déjà utilisé.';
                $this->redirect('/Critiverse/public/profile');
                return;
            }

            $userModel->updateInfo($userId, $username, $email);
            $_SESSION['username'] = $username;
            $this->redirect('/Critiverse/public/profile?success=info');

        } elseif ($action === 'update_password') {
            $current  = $_POST['current_password']  ?? '';
            $new      = $_POST['new_password']       ?? '';
            $confirm  = $_POST['confirm_password']   ?? '';

            if (!password_verify($current, $user['password'])) {
                $_SESSION['profile_error'] = 'Mot de passe actuel incorrect.';
                $this->redirect('/Critiverse/public/profile');
                return;
            }
            if (mb_strlen($new) < 6) {
                $_SESSION['profile_error'] = 'Le nouveau mot de passe doit faire au moins 6 caractères.';
                $this->redirect('/Critiverse/public/profile');
                return;
            }
            if ($new !== $confirm) {
                $_SESSION['profile_error'] = 'Les mots de passe ne correspondent pas.';
                $this->redirect('/Critiverse/public/profile');
                return;
            }

            $userModel->updatePassword($userId, $new);
            $this->redirect('/Critiverse/public/profile?success=password');
        }

        $this->redirect('/Critiverse/public/profile');
    }
}
