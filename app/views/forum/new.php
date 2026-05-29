<?php
$activePage = 'forum';
$css        = 'accueil';
$title      = 'Nouveau sujet - Forum';
require_once __DIR__ . '/../layouts/header.php';
?>

<style>
.new-topic-wrap { max-width: 720px; margin: 0 auto; padding: 40px 24px; }
.back-link { display: inline-flex; align-items: center; gap: 6px; color: #2f6df6; text-decoration: none; font-size: 14px; margin-bottom: 28px; }
.back-link:hover { text-decoration: underline; }
.new-topic-box { background: white; border-radius: 14px; padding: 36px 36px; box-shadow: 0 2px 14px rgba(0,0,0,.09); }
.new-topic-box h1 { margin: 0 0 28px; font-size: 22px; }
.form-field { display: flex; flex-direction: column; gap: 8px; margin-bottom: 22px; }
.form-field label { font-weight: 700; font-size: 14px; color: #333; }
.form-field input, .form-field textarea {
    padding: 14px 16px; border-radius: 10px; border: 1.5px solid #e0e0e0;
    font-size: 14px; outline: none; transition: border-color .2s;
    font-family: inherit; box-sizing: border-box; width: 100%;
}
.form-field input:focus, .form-field textarea:focus { border-color: #2f6df6; }
.form-field textarea { resize: vertical; line-height: 1.6; }
.submit-btn {
    background: #2f6df6; color: white; border: none;
    border-radius: 24px; padding: 13px 32px;
    font-size: 15px; font-weight: 700; cursor: pointer;
    transition: background .2s;
}
.submit-btn:hover { background: #2559c7; }
.error-box { background: #ffe0e0; color: #c00; padding: 12px 16px; border-radius: 8px; margin-bottom: 22px; font-size: 14px; }
</style>

<div class="new-topic-wrap">
    <a href="/Critiverse/public/forum" class="back-link">← Retour au forum</a>

    <div class="new-topic-box">
        <h1>Créer un nouveau sujet</h1>

        <?php if (!empty($error)): ?>
            <div class="error-box"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="/Critiverse/public/forum/new">
            <div class="form-field">
                <label for="title">Titre du sujet</label>
                <input type="text" id="title" name="title" placeholder="Un titre clair et descriptif" required>
            </div>
            <div class="form-field">
                <label for="content">Contenu</label>
                <textarea id="content" name="content" rows="8" placeholder="Exprimez-vous..." required></textarea>
            </div>
            <button type="submit" class="submit-btn">Publier le sujet</button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
