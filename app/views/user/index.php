<?php
$css   = 'profile';
$title = $title ?? ($target['username'] . ' - Critiverse');

$plan   = $target['plan'] ?? 'gratuit';
$colors = ['#2f6df6','#7c3aed','#16a34a','#e53935','#f59e0b','#0891b2'];
$color  = $colors[ord($target['username'][0]) % count($colors)];

$badgeHtml = match($plan) {
    'premium' => '<span class="prof-badge premium">⭐ Premium</span>',
    'pro'     => '<span class="prof-badge pro">👑 Pro</span>',
    default   => '<span class="prof-badge gratuit">Gratuit</span>',
};

$mediaLabel = fn($type) => match($type) {
    'film'  => '🎬 Film',
    'serie' => '📺 Série',
    'anime' => '⚔️ Animé',
    default => $type,
};

require_once __DIR__ . '/../layouts/header.php';
?>

<div class="prof-layout">

    <!-- ── Sidebar ── -->
    <aside class="prof-sidebar">
        <div class="prof-avatar" style="background:<?= $color ?>">
            <?php if (!empty($target['avatar'])): ?>
                <img src="<?= htmlspecialchars($target['avatar']) ?>" alt="Avatar" class="prof-avatar-img">
            <?php else: ?>
                <?= mb_strtoupper(mb_substr($target['username'], 0, 1)) ?>
            <?php endif; ?>
        </div>

        <h1 class="prof-username"><?= htmlspecialchars($target['username']) ?></h1>
        <?= $badgeHtml ?>

        <?php if (!empty($target['bio'])): ?>
            <p class="prof-bio-display"><?= htmlspecialchars($target['bio']) ?></p>
        <?php endif; ?>

        <p class="prof-since">
            Membre depuis <?= date('F Y', strtotime($target['created_at'])) ?>
        </p>

        <div class="prof-stats">
            <div class="prof-stat">
                <span><?= $reviewCount ?></span>
                <small>Critiques</small>
            </div>
            <div class="prof-stat">
                <span><?= ucfirst($plan) ?></span>
                <small>Abonnement</small>
            </div>
        </div>

        <?php
        $currentPlan = $_SESSION['plan'] ?? 'gratuit';
        $canMessage  = in_array($currentPlan, ['premium', 'pro'])
                    && in_array($plan, ['premium', 'pro'])
                    && isset($_SESSION['user_id'])
                    && $_SESSION['user_id'] !== $target['id'];
        ?>
        <?php if ($canMessage): ?>
            <a href="/Critiverse/public/messages/conversation?with=<?= (int)$target['id'] ?>"
               class="prof-upgrade-btn" style="margin-top:12px;">
                💬 Envoyer un message
            </a>
        <?php endif; ?>
    </aside>

    <!-- ── Critiques ── -->
    <main class="prof-main">
        <section class="prof-section">
            <h2>⭐ Dernières critiques de <?= htmlspecialchars($target['username']) ?></h2>
            <?php if (empty($reviews)): ?>
                <p class="prof-empty">Aucune critique publiée pour le moment.</p>
            <?php else: ?>
                <div class="prof-reviews">
                    <?php foreach ($reviews as $r): ?>
                        <div class="prof-review-card">
                            <div class="prof-review-header">
                                <span class="prof-review-type"><?= $mediaLabel($r['media_type']) ?></span>
                                <span class="prof-review-stars">
                                    <?= str_repeat('★', $r['score']) . str_repeat('☆', 5 - $r['score']) ?>
                                    <small><?= $r['score'] ?>/5</small>
                                </span>
                                <span class="prof-review-date">
                                    <?= date('d/m/Y', strtotime($r['created_at'])) ?>
                                </span>
                            </div>
                            <p class="prof-review-comment"><?= htmlspecialchars($r['comment']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
