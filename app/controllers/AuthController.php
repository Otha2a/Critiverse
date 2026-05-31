<?php

require_once __DIR__ . '/../models/User.php';

class AuthController extends Controller
{
    private const BASE  = '/Critiverse/public/';
    private const LOGIN = '/Critiverse/public/login';
    private const REG   = '/Critiverse/public/register';

    // ── GET /login ────────────────────────────────────────────────────────────
    public function loginForm(): void
    {
        // Mémoriser l'URL de retour si fournie (pages HTML statiques)
        if (!empty($_GET['redirect'])) {
            $_SESSION['redirect_after_login'] = $_GET['redirect'];
        }
        $error = $_SESSION['auth_error'] ?? null;
        unset($_SESSION['auth_error']);
        $this->render('auth/login', ['title' => 'Connexion - Critiverse', 'error' => $error]);
    }

    // ── POST /login ───────────────────────────────────────────────────────────
    public function loginProcess(): void
    {
        $email    = trim($_POST['email']    ?? '');
        $password =      $_POST['password'] ?? '';
        $userModel = new User();
        $user      = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['plan']     = $user['plan'] ?? 'gratuit';
            $redirect = $_SESSION['redirect_after_login'] ?? self::BASE;
            unset($_SESSION['redirect_after_login']);
            $this->redirect($redirect);
        } else {
            $_SESSION['auth_error'] = 'Email ou mot de passe incorrect.';
            $this->redirect(self::LOGIN);
        }
    }

    // ── GET /register ─────────────────────────────────────────────────────────
    public function registerForm(): void
    {
        $error = $_SESSION['auth_error'] ?? null;
        unset($_SESSION['auth_error']);
        $this->render('auth/register', ['title' => 'Inscription - Critiverse', 'error' => $error]);
    }

    // ── POST /register ────────────────────────────────────────────────────────
    public function registerProcess(): void
    {
        $username = trim($_POST['username'] ?? '');
        $email    = trim($_POST['email']    ?? '');
        $password =      $_POST['password'] ?? '';

        $error = $this->validateRegistration($username, $password, $email);
        if ($error) {
            $_SESSION['auth_error'] = $error;
            $this->redirect(self::REG);
            return;
        }

        $userModel = new User();
        $userModel->create($username, $email, $password);
        $user = $userModel->findByEmail($email);

        session_regenerate_id(true);
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['plan']     = 'gratuit';
        $this->redirect(self::BASE);
    }

    // ── GET /logout ───────────────────────────────────────────────────────────
    public function logout(): void
    {
        session_destroy();
        $this->redirect(self::BASE);
    }

    // ── Validation inscription ────────────────────────────────────────────────
    private function validateRegistration(string $username, string $password, string $email): ?string
    {
        $userModel = new User();
        $checks = [
            mb_strlen($username) < 3              => 'Le pseudo doit faire au moins 3 caractères.',
            mb_strlen($password) < 6              => 'Le mot de passe doit faire au moins 6 caractères.',
            $userModel->emailExists($email)       => 'Cet email est déjà utilisé.',
            $userModel->usernameExists($username) => 'Ce pseudo est déjà pris.',
        ];

        foreach ($checks as $failed => $message) {
            if ($failed) {
                return $message;
            }
        }

        return null;
    }
}
