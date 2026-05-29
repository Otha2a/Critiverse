<?php
$activePage = '';
$css        = 'accueil';
$title      = 'Inscription - Critiverse';
require_once __DIR__ . '/../layouts/header.php';
?>

<style>
.auth-box {
    background: white;
    padding: 50px 44px;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0,0,0,.10);
    width: 100%;
    max-width: 460px;
}
.auth-box h2 { margin: 0 0 6px; font-size: 26px; text-align: center; }
.auth-box .subtitle { text-align: center; color: #777; font-size: 14px; margin-bottom: 36px; }
.auth-field { display: flex; flex-direction: column; gap: 7px; }
.auth-field label { font-weight: 600; font-size: 14px; color: #333; }
.auth-field input {
    padding: 14px 16px;
    border-radius: 10px;
    border: 1.5px solid #e0e0e0;
    font-size: 14px;
    outline: none;
    transition: border-color .2s;
    width: 100%;
    box-sizing: border-box;
}
.auth-field input:focus { border-color: #2f6df6; }
.auth-form { display: flex; flex-direction: column; gap: 22px; }
.auth-submit {
    background: #2f6df6;
    color: white;
    border: none;
    padding: 15px;
    border-radius: 10px;
    cursor: pointer;
    font-size: 15px;
    font-weight: 700;
    margin-top: 8px;
    transition: background .2s;
    width: 100%;
}
.auth-submit:hover { background: #2559c7; }
.auth-link { text-align: center; margin-top: 18px; font-size: 14px; color: #555; }
.auth-link a { color: #2f6df6; font-weight: 600; text-decoration: none; }
.auth-error { background: #ffe0e0; color: #c00; padding: 12px 16px; border-radius: 8px; font-size: 14px; }
</style>

<main style="display:flex;justify-content:center;align-items:center;min-height:62vh;padding:40px 20px;">
    <div class="auth-box">
        <h2>Créer un compte</h2>
        <p class="subtitle">Rejoignez la communauté Critiverse</p>

        <?php if (!empty($error)): ?>
            <div class="auth-error" style="margin-bottom:24px;"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="/Critiverse/public/register" class="auth-form">
            <div class="auth-field">
                <label for="username">Pseudo</label>
                <input type="text" id="username" name="username" placeholder="Minimum 3 caractères" required>
            </div>
            <div class="auth-field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="votre@email.com" required>
            </div>
            <div class="auth-field">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="Minimum 6 caractères" required>
            </div>
            <button type="submit" class="auth-submit">Créer mon compte</button>
        </form>

        <p class="auth-link">
            Déjà un compte ? <a href="/Critiverse/public/login">Se connecter</a>
        </p>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
