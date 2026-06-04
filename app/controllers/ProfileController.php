<?php

class ProfileController extends Controller
{
    private const PROFILE_URL = '/Critiverse/public/profile';

    public function index(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/Critiverse/public/login');
            return;
        }

        $userModel = new User();
        $user      = $userModel->findById((int)$_SESSION['user_id']);

        $pdo = getDatabaseConnection();

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM reviews WHERE user_id = ?");
        $stmt->execute([$user['id']]);
        $reviewCount = (int)$stmt->fetchColumn();

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
        $action    = $_POST['action'] ?? '';

        match ($action) {
            'update_info'     => $this->handleUpdateInfo($userId, $user, $userModel),
            'update_password' => $this->handleUpdatePassword($userId, $user, $userModel),
            'update_profile'  => $this->handleUpdateProfile($userId, $user, $userModel),
            default           => $this->redirect(self::PROFILE_URL),
        };
    }

    private function handleUpdateInfo(int $userId, array $user, User $userModel): void
    {
        $username = trim($_POST['username'] ?? '');
        $email    = trim($_POST['email']    ?? '');

        if (mb_strlen($username) < 3) {
            $this->abortWithError('Le pseudo doit faire au moins 3 caractères.');
            return;
        }
        if ($username !== $user['username'] && $userModel->usernameExists($username)) {
            $this->abortWithError('Ce pseudo est déjà pris.');
            return;
        }
        if ($email !== $user['email'] && $userModel->emailExists($email)) {
            $this->abortWithError('Cet email est déjà utilisé.');
            return;
        }

        $userModel->updateInfo($userId, $username, $email);
        $_SESSION['username'] = $username;
        $this->redirect(self::PROFILE_URL . '?success=info');
    }

    private function handleUpdatePassword(int $userId, array $user, User $userModel): void
    {
        $current = $_POST['current_password'] ?? '';
        $new     = $_POST['new_password']     ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        if (!password_verify($current, $user['password'])) {
            $this->abortWithError('Mot de passe actuel incorrect.');
            return;
        }
        if (mb_strlen($new) < 6) {
            $this->abortWithError('Le nouveau mot de passe doit faire au moins 6 caractères.');
            return;
        }
        if ($new !== $confirm) {
            $this->abortWithError('Les mots de passe ne correspondent pas.');
            return;
        }

        $userModel->updatePassword($userId, $new);
        $this->redirect(self::PROFILE_URL . '?success=password');
    }

    private function handleUpdateProfile(int $userId, array $user, User $userModel): void
    {
        $bio    = mb_substr(trim($_POST['bio'] ?? ''), 0, 300);
        $avatar = $this->handleAvatarUpload($userId, $user);

        if ($avatar === false) {
            return;
        }

        $userModel->updateProfile($userId, $bio, $avatar);
        $this->redirect(self::PROFILE_URL . '?success=profile');
    }

    private function handleAvatarUpload(int $userId, array $user): string|null|false
    {
        if (empty($_FILES['avatar']['name']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $file  = $_FILES['avatar'];
        $error = $this->validateAvatarFile($file);

        if ($error !== null) {
            $this->abortWithError($error);
            return false;
        }

        return $this->saveAvatarFile($userId, $user, $file);
    }

    private function validateAvatarFile(array $file): ?string
    {
        $imgInfo      = @getimagesize($file['tmp_name']);
        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

        if ($imgInfo === false) {
            $error = 'Le fichier uploadé n\'est pas une image valide.';
        } elseif (!in_array($imgInfo['mime'], $allowedMimes)) {
            $error = 'Format non supporté (JPG, PNG, GIF, WEBP uniquement).';
        } elseif ($file['size'] > 2 * 1024 * 1024) {
            $error = 'L\'image ne doit pas dépasser 2 Mo.';
        } else {
            $error = null;
        }

        return $error;
    }

    private function saveAvatarFile(int $userId, array $user, array $file): string
    {
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/Critiverse/public/uploads/avatars/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (!empty($user['avatar'])) {
            $old = $_SERVER['DOCUMENT_ROOT'] . $user['avatar'];
            if (file_exists($old)) {
                unlink($old);
            }
        }

        $ext      = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename = 'avatar_' . $userId . '_' . time() . '.' . $ext;
        move_uploaded_file($file['tmp_name'], $uploadDir . $filename);

        return '/Critiverse/public/uploads/avatars/' . $filename;
    }

    private function abortWithError(string $message): void
    {
        $_SESSION['profile_error'] = $message;
        $this->redirect(self::PROFILE_URL);
    }
}
