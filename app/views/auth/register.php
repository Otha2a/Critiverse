<?php
$activePage = '';
$css        = 'accueil';
require_once __DIR__ . '/../layouts/header.php';
?>
<main style="display:flex;justify-content:center;align-items:center;min-height:60vh;padding:40px;">
    <div style="background:white;padding:40px;border-radius:15px;box-shadow:0 4px 20px rgba(0,0,0,.1);width:100%;max-width:400px;">
        <h2 style="margin-top:0;margin-bottom:24px;text-align:center;">Créer un compte</h2>

        <?php if (!empty($error)): ?>
            <div style="background:#ffe0e0;color:#c00;padding:12px;border-radius:8px;margin-bottom:16px;font-size:14px;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/Critiverse/public/register" style="display:flex;flex-direction:column;gap:14px;">
            <input type="text" name="username" placeholder="Pseudo (min. 3 caractères)" required
                   style="padding:12px;border-radius:8px;border:1px solid #ddd;font-size:14px;">
            <input type="email" name="email" placeholder="Email" required
                   style="padding:12px;border-radius:8px;border:1px solid #ddd;font-size:14px;">
            <input type="password" name="password" placeholder="Mot de passe (min. 6 caractères)" required
                   style="padding:12px;border-radius:8px;border:1px solid #ddd;font-size:14px;">
            <button type="submit"
                    style="background:#2f6df6;color:white;border:none;padding:13px;border-radius:8px;cursor:pointer;font-size:15px;font-weight:bold;">
                Créer mon compte
            </button>
        </form>

        <p style="text-align:center;margin-top:16px;font-size:14px;color:#555;">
            Déjà un compte ?
            <a href="/Critiverse/public/login" style="color:#2f6df6;font-weight:bold;">Se connecter</a>
        </p>
    </div>
</main>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
