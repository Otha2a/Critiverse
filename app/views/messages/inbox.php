<?php
$activePage = 'messages';
$css        = 'messages';
$title      = $title ?? 'Messages privés - Critiverse';
require_once __DIR__ . '/../layouts/header.php';

function badgePlan(string $plan): string {
    return match($plan) {
        'premium' => '<span class="msg-badge premium">⭐ Premium</span>',
        'pro'     => '<span class="msg-badge pro">👑 Pro</span>',
        default   => ''
    };
}
?>

<div class="msg-layout">

    <!-- ── Colonne gauche : liste conversations + recherche ── -->
    <aside class="msg-sidebar">
        <h2>💬 Messages</h2>

        <form method="GET" action="/Critiverse/public/messages" class="msg-search-form">
            <input type="text" name="search" placeholder="Chercher un membre abonné..."
                   value="<?= htmlspecialchars($search) ?>">
            <button type="submit">🔎</button>
        </form>

        <?php if (!empty($users) && $search !== ''): ?>
            <p class="msg-section-label">Résultats</p>
            <ul class="msg-user-list">
                <?php foreach ($users as $u): ?>
                    <li class="msg-row-item">
                        <a href="/Critiverse/public/messages/conversation?user=<?= $u['id'] ?>"
                           class="msg-row-link" aria-label="Envoyer un message à <?= htmlspecialchars($u['username']) ?>"></a>
                        <div class="msg-row-content">
                            <span class="msg-avatar" style="background:<?= $u['plan']==='pro'?'#7c3aed':'#2f6df6' ?>">
                                <?= mb_strtoupper(mb_substr($u['username'],0,1)) ?>
                            </span>
                            <span class="msg-user-info">
                                <strong>
                                    <a href="/Critiverse/public/user?u=<?= urlencode($u['username']) ?>"
                                       class="msg-username-profile">
                                        <?= htmlspecialchars($u['username']) ?>
                                    </a>
                                </strong>
                                <?= badgePlan($u['plan']) ?>
                            </span>
                        </div>
                    </li>
                <?php endforeach; ?>
                <?php if (empty($users)): ?>
                    <li class="msg-empty">Aucun membre abonné trouvé.</li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>

        <p class="msg-section-label">Conversations</p>
        <?php if (empty($conversations)): ?>
            <p class="msg-empty">Aucune conversation pour l'instant.<br>Cherchez un membre abonné ci-dessus.</p>
        <?php else: ?>
            <ul class="msg-conv-list">
                <?php foreach ($conversations as $conv): ?>
                    <li class="msg-row-item <?= $conv['unread'] > 0 ? 'msg-unread' : '' ?>">
                        <a href="/Critiverse/public/messages/conversation?user=<?= $conv['other_id'] ?>"
                           class="msg-row-link" aria-label="Conversation avec <?= htmlspecialchars($conv['other_name']) ?>"></a>
                        <div class="msg-row-content">
                            <span class="msg-avatar" style="background:<?= $conv['other_plan']==='pro'?'#7c3aed':'#2f6df6' ?>">
                                <?= mb_strtoupper(mb_substr($conv['other_name'],0,1)) ?>
                            </span>
                            <span class="msg-conv-info">
                                <span class="msg-conv-name">
                                    <a href="/Critiverse/public/user?u=<?= urlencode($conv['other_name']) ?>"
                                       class="msg-username-profile">
                                        <?= htmlspecialchars($conv['other_name']) ?>
                                    </a>
                                    <?= badgePlan($conv['other_plan']) ?>
                                    <?php if ($conv['unread'] > 0): ?>
                                        <span class="msg-unread-dot"><?= $conv['unread'] ?></span>
                                    <?php endif; ?>
                                </span>
                                <span class="msg-conv-preview"><?= htmlspecialchars(mb_substr($conv['last_message'],0,40)) ?>...</span>
                            </span>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </aside>

    <!-- ── Zone droite : sélectionner une conversation ── -->
    <main class="msg-main msg-empty-state">
        <div>
            <span style="font-size:3rem;">💬</span>
            <h3>Sélectionnez une conversation</h3>
            <p>Cherchez un membre abonné ou cliquez sur une conversation existante.</p>
        </div>
    </main>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
