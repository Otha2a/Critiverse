<?php
$activePage = 'contact';
$css        = 'contacts';
$title      = 'Contact - Critiverse';
require_once __DIR__ . '/../layouts/header.php';

$success = isset($_GET['success']);
$error   = $_GET['error'] ?? null;
?>

<main style="display:flex;justify-content:center;padding:60px 20px;min-height:60vh;">
    <div class="contact-box">
        <h2>Nous contacter</h2>
        <p class="contact-info">Une question ou une suggestion ? Écrivez-nous !</p>

        <?php if ($success): ?>
            <div style="background:#e8f5e9;color:#2e7d32;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:14px;">
                Votre message a bien été envoyé, merci !
            </div>
        <?php elseif ($error === 'validation'): ?>
            <div style="background:#ffe0e0;color:#c00;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:14px;">
                Tous les champs sont requis.
            </div>
        <?php elseif ($error === 'db'): ?>
            <div style="background:#ffe0e0;color:#c00;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:14px;">
                Erreur lors de l'envoi du message, réessayez plus tard.
            </div>
        <?php endif; ?>

        <form method="POST" action="/Critiverse/public/contact">
            <label>Nom</label>
            <input type="text" name="name" placeholder="Votre nom" required>

            <label>Email</label>
            <input type="email" name="email" placeholder="votre@email.com" required>

            <label>Message</label>
            <textarea name="message" rows="6" placeholder="Votre message..." required></textarea>

            <button type="submit" class="btn-send">Envoyer</button>
        </form>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
