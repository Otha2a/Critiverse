<?php
$activePage = 'contact';
$css        = 'contacts';
$title      = 'Nous contacter - Critiverse';
require_once __DIR__ . '/../layouts/header.php';

$success = isset($_GET['success']);
$error   = $_GET['error'] ?? null;
?>

<main class="contact-main">
    <div class="contact-wrapper">

        <!-- ── Colonne gauche : infos ── -->
        <div class="contact-info-col">
            <h1>Nous contacter</h1>
            <p>Une question, une suggestion ou un bug à signaler ? On vous répond dans les plus brefs délais.</p>

            <div class="contact-info-items">
                <div class="contact-info-item">
                    <span class="contact-icon">✉️</span>
                    <div>
                        <strong>Email</strong>
                        <p>support@critiverse.fr</p>
                    </div>
                </div>
                <div class="contact-info-item">
                    <span class="contact-icon">📍</span>
                    <div>
                        <strong>Localisation</strong>
                        <p>France</p>
                    </div>
                </div>
                <div class="contact-info-item">
                    <span class="contact-icon">⏱️</span>
                    <div>
                        <strong>Temps de réponse</strong>
                        <p>Sous 48h ouvrées</p>
                    </div>
                </div>
            </div>

            <div class="contact-socials">
                <a href="https://instagram.com/" title="Instagram"><img src="/Critiverse/archives/images/autres/instagram.png" alt="Instagram"></a>
                <a href="https://www.linkedin.com/" title="LinkedIn"><img src="/Critiverse/archives/images/autres/linkedin.png" alt="LinkedIn"></a>
                <a href="https://x.com/" title="X"><img src="/Critiverse/archives/images/autres/x.png" alt="X"></a>
            </div>
        </div>

        <!-- ── Colonne droite : formulaire ── -->
        <div class="contact-form-col">

            <?php if ($success): ?>
                <div class="contact-alert contact-alert-success">
                    ✅ Votre message a bien été envoyé, merci !
                </div>
            <?php elseif ($error === 'validation'): ?>
                <div class="contact-alert contact-alert-error">
                    ⚠️ Tous les champs sont requis.
                </div>
            <?php elseif ($error === 'db'): ?>
                <div class="contact-alert contact-alert-error">
                    ❌ Erreur lors de l'envoi, réessayez plus tard.
                </div>
            <?php endif; ?>

            <form method="POST" action="/Critiverse/public/contact" class="contact-form">
                <div class="form-group">
                    <label for="name">Nom complet</label>
                    <input type="text" id="name" name="name" placeholder="Jean Dupont" required>
                </div>
                <div class="form-group">
                    <label for="email">Adresse email</label>
                    <input type="email" id="email" name="email" placeholder="jean@email.com" required>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="6" placeholder="Décrivez votre demande..." required></textarea>
                </div>
                <button type="submit" class="btn-send">Envoyer le message →</button>
            </form>
        </div>

    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
