<?php
$activePage = 'forum';
$css        = 'accueil';
require_once __DIR__ . '/../layouts/header.php';
?>

<style>
.topic-wrap { max-width: 860px; margin: 0 auto; padding: 36px 24px; }
.back-link { display: inline-flex; align-items: center; gap: 6px; color: #2f6df6; text-decoration: none; font-size: 14px; margin-bottom: 24px; }
.back-link:hover { text-decoration: underline; }
.topic-title-block { margin-bottom: 28px; }
.topic-title-block h1 { font-size: 24px; margin: 0 0 8px; color: #111; }
.topic-title-block .meta { font-size: 13px; color: #888; }
.post-card {
    background: white; border-radius: 12px; padding: 20px 24px;
    margin-bottom: 14px; box-shadow: 0 1px 6px rgba(0,0,0,.07);
}
.post-card.op { border-left: 4px solid #2f6df6; }
.post-header { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
.post-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: #2f6df6; color: white; display: flex;
    align-items: center; justify-content: center;
    font-weight: 700; font-size: 15px; flex-shrink: 0;
}
.post-author { font-weight: 700; font-size: 14px; color: #222; }
.post-date   { font-size: 12px; color: #aaa; margin-top: 2px; }
.post-content { font-size: 14px; color: #333; line-height: 1.7; white-space: pre-wrap; }
.reply-form-box {
    background: white; border-radius: 12px; padding: 24px;
    box-shadow: 0 1px 6px rgba(0,0,0,.07); margin-top: 28px;
}
.reply-form-box h3 { margin: 0 0 16px; font-size: 17px; }
.reply-form-box textarea {
    width: 100%; padding: 14px; border-radius: 10px;
    border: 1.5px solid #e0e0e0; font-size: 14px; resize: vertical;
    outline: none; transition: border-color .2s; box-sizing: border-box;
    font-family: inherit; line-height: 1.6;
}
.reply-form-box textarea:focus { border-color: #2f6df6; }
.reply-submit {
    margin-top: 14px; background: #2f6df6; color: white;
    border: none; border-radius: 24px; padding: 11px 28px;
    font-size: 14px; font-weight: 700; cursor: pointer; transition: background .2s;
}
.reply-submit:hover { background: #2559c7; }
.login-invite {
    text-align: center; padding: 28px; background: #f5f9ff;
    border-radius: 12px; margin-top: 28px; color: #555; font-size: 14px;
}
.login-invite a { color: #2f6df6; font-weight: 700; text-decoration: none; }
</style>

<div class="topic-wrap">
    <a href="/Critiverse/public/forum" class="back-link">← Retour au forum</a>

    <div class="topic-title-block">
        <h1><?= htmlspecialchars($topic['title']) ?></h1>
        <span class="meta">
            👤 <strong><?= htmlspecialchars($topic['username']) ?></strong>
            &nbsp;·&nbsp; <?= date('d/m/Y à H:i', strtotime($topic['created_at'])) ?>
            &nbsp;·&nbsp; <?= count($replies) ?> réponse<?= count($replies) != 1 ? 's' : '' ?>
        </span>
    </div>

    <!-- Message original -->
    <div class="post-card op">
        <div class="post-header">
            <div class="post-avatar"><?= mb_strtoupper(mb_substr($topic['username'], 0, 1)) ?></div>
            <div>
                <div class="post-author"><?= htmlspecialchars($topic['username']) ?></div>
                <div class="post-date"><?= date('d/m/Y à H:i', strtotime($topic['created_at'])) ?></div>
            </div>
        </div>
        <div class="post-content"><?= htmlspecialchars($topic['content']) ?></div>
    </div>

    <!-- Réponses -->
    <?php foreach ($replies as $r): ?>
    <div class="post-card">
        <div class="post-header">
            <div class="post-avatar" style="background:#7c3aed"><?= mb_strtoupper(mb_substr($r['username'], 0, 1)) ?></div>
            <div>
                <div class="post-author"><?= htmlspecialchars($r['username']) ?></div>
                <div class="post-date"><?= date('d/m/Y à H:i', strtotime($r['created_at'])) ?></div>
            </div>
        </div>
        <div class="post-content"><?= htmlspecialchars($r['content']) ?></div>
    </div>
    <?php endforeach; ?>

    <div id="bottom"></div>

    <!-- Formulaire de réponse -->
    <?php if (isset($_SESSION['user_id'])): ?>
    <div class="reply-form-box">
        <h3>Répondre</h3>
        <form method="POST" action="/Critiverse/public/forum/reply">
            <input type="hidden" name="topic_id" value="<?= (int)$topic['id'] ?>">
            <textarea name="content" rows="5" placeholder="Votre réponse..." required></textarea>
            <button type="submit" class="reply-submit">Envoyer</button>
        </form>
    </div>
    <?php else: ?>
    <div class="login-invite">
        <a href="/Critiverse/public/login">Connectez-vous</a> pour répondre à ce sujet.
    </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
