<?php
$activePage = 'forum';
$css        = 'accueil';
$title      = $title ?? 'Forum - Critiverse';
require_once __DIR__ . '/../layouts/header.php';
?>

<style>
.forum-wrap { max-width: 900px; margin: 0 auto; padding: 36px 24px; }
.forum-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 28px; flex-wrap: wrap; gap: 14px;
}
.forum-header h1 { font-size: 26px; margin: 0; }
.btn-new-topic {
    background: #2f6df6; color: white; text-decoration: none;
    padding: 11px 24px; border-radius: 24px; font-weight: 700; font-size: 14px;
    transition: background .2s;
}
.btn-new-topic:hover { background: #2559c7; }
.btn-login-prompt {
    background: #f1f1f1; color: #555; border: 1px solid #ddd; text-decoration: none;
    padding: 11px 20px; border-radius: 24px; font-size: 14px;
    transition: background .2s;
}
.btn-login-prompt:hover { background: #e5e5e5; }
.topic-list { display: flex; flex-direction: column; gap: 2px; }
.topic-row {
    background: white; border-radius: 10px; padding: 18px 22px;
    display: flex; align-items: center; gap: 18px;
    box-shadow: 0 1px 6px rgba(0,0,0,.06);
    text-decoration: none; color: inherit;
    transition: box-shadow .15s, transform .15s;
}
.topic-row:hover { box-shadow: 0 4px 16px rgba(0,0,0,.12); transform: translateX(2px); }
.topic-icon { font-size: 26px; flex-shrink: 0; }
.topic-body { flex: 1; overflow: hidden; }
.topic-title { font-size: 16px; font-weight: 700; color: #111; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.topic-meta  { font-size: 12px; color: #888; margin-top: 4px; }
.topic-replies {
    text-align: center; min-width: 54px; flex-shrink: 0;
    font-size: 13px; color: #555;
}
.topic-replies strong { display: block; font-size: 18px; color: #2f6df6; }
.empty-forum { text-align: center; padding: 60px 20px; color: #999; font-size: 16px; }
.pagination { display: flex; align-items: center; justify-content: center; gap: 12px; margin-top: 32px; }
.pagination a {
    padding: 9px 22px; border-radius: 22px; background: #2f6df6; color: white;
    text-decoration: none; font-weight: 700; font-size: 14px;
    transition: background .2s;
}
.pagination a:hover { background: #2559c7; }
.pagination a.disabled { background: #ccc; pointer-events: none; }
.pagination span { font-size: 14px; color: #555; font-weight: 600; }
</style>

<div class="forum-wrap">
    <div class="forum-header">
        <h1>💬 Forum</h1>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/Critiverse/public/forum/new" class="btn-new-topic">+ Nouveau sujet</a>
        <?php else: ?>
            <a href="/Critiverse/public/login" class="btn-login-prompt">Connectez-vous pour poster</a>
        <?php endif; ?>
    </div>

    <?php if (empty($topics)): ?>
        <div class="empty-forum">
            Aucun sujet pour le moment. Soyez le premier à en créer un !
        </div>
    <?php else: ?>
        <div class="topic-list">
            <?php foreach ($topics as $t): ?>
            <a class="topic-row" href="/Critiverse/public/forum/topic?id=<?= $t['id'] ?>">
                <span class="topic-icon">💬</span>
                <div class="topic-body">
                    <div class="topic-title"><?= htmlspecialchars($t['title']) ?></div>
                    <div class="topic-meta">
                        👤 <?= htmlspecialchars($t['username']) ?> &nbsp;·&nbsp;
                        <?= date('d/m/Y à H:i', strtotime($t['created_at'])) ?>
                    </div>
                </div>
                <div class="topic-replies">
                    <strong><?= (int)$t['reply_count'] ?></strong>
                    réponse<?= $t['reply_count'] != 1 ? 's' : '' ?>
                </div>
            </a>
            <?php endforeach; ?>
        </div>

        <?php if ($pages > 1): ?>
        <div class="pagination">
            <a href="?page=<?= $page - 1 ?>" class="<?= $page <= 1 ? 'disabled' : '' ?>">← Précédent</a>
            <span>Page <?= $page ?> / <?= $pages ?></span>
            <a href="?page=<?= $page + 1 ?>" class="<?= $page >= $pages ? 'disabled' : '' ?>">Suivant →</a>
        </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
