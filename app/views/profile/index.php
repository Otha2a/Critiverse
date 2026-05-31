<?php
$activePage = '';
$css        = 'profile';
$title      = $title ?? 'Mon profil - Critiverse';
require_once __DIR__ . '/../layouts/header.php';

$plan   = $user['plan'] ?? 'gratuit';
$colors = ['#2f6df6','#7c3aed','#16a34a','#e53935','#f59e0b','#0891b2'];
$color  = $colors[ord($user['username'][0]) % count($colors)];

$badgeHtml = match($plan) {
    'premium' => '<span class="prof-badge premium">⭐ Premium</span>',
    'pro'     => '<span class="prof-badge pro">👑 Pro</span>',
    default   => '<span class="prof-badge gratuit">Gratuit</span>',
};

$mediaLabel = fn($type) => match($type) {
    'film'  => '🎬 Film',
    'serie' => '📺 Série',
    'anime' => '⚔️ Animé',
    default => $type
};
?>

<div class="prof-layout">

    <!-- ── Colonne gauche : carte identité ── -->
    <aside class="prof-sidebar">
        <div class="prof-avatar" style="background:<?= $color ?>">
            <?= mb_strtoupper(mb_substr($user['username'], 0, 1)) ?>
        </div>
        <h1 class="prof-username"><?= htmlspecialchars($user['username']) ?></h1>
        <?= $badgeHtml ?>
        <p class="prof-since">
            Membre depuis <?= date('F Y', strtotime($user['created_at'])) ?>
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

        <a href="/Critiverse/public/abonnement" class="prof-upgrade-btn">
            <?= $plan === 'gratuit' ? '🚀 Passer Premium' : '⚙️ Gérer l\'abonnement' ?>
        </a>
    </aside>

    <!-- ── Colonne droite : édition + critiques ── -->
    <main class="prof-main">

        <?php if ($success === 'info'): ?>
            <div class="prof-alert success">✅ Profil mis à jour avec succès !</div>
        <?php elseif ($success === 'password'): ?>
            <div class="prof-alert success">✅ Mot de passe modifié avec succès !</div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="prof-alert error">⚠️ <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- Modifier les infos -->
        <section class="prof-section">
            <h2>✏️ Modifier mes informations</h2>
            <form method="POST" action="/Critiverse/public/profile/update" class="prof-form">
                <input type="hidden" name="action" value="update_info">
                <div class="prof-form-row">
                    <div class="prof-form-group">
                        <label>Pseudo</label>
                        <input type="text" name="username"
                               value="<?= htmlspecialchars($user['username']) ?>" required minlength="3">
                    </div>
                    <div class="prof-form-group">
                        <label>Email</label>
                        <input type="email" name="email"
                               value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>
                </div>
                <button type="submit" class="prof-btn">Enregistrer les modifications</button>
            </form>
        </section>

        <!-- Modifier le mot de passe -->
        <section class="prof-section">
            <h2>🔒 Changer le mot de passe</h2>
            <form method="POST" action="/Critiverse/public/profile/update" class="prof-form">
                <input type="hidden" name="action" value="update_password">
                <div class="prof-form-group">
                    <label>Mot de passe actuel</label>
                    <input type="password" name="current_password" required>
                </div>
                <div class="prof-form-row">
                    <div class="prof-form-group">
                        <label>Nouveau mot de passe</label>
                        <input type="password" name="new_password" required minlength="6">
                    </div>
                    <div class="prof-form-group">
                        <label>Confirmer</label>
                        <input type="password" name="confirm_password" required minlength="6">
                    </div>
                </div>
                <button type="submit" class="prof-btn">Changer le mot de passe</button>
            </form>
        </section>

        <!-- Mes critiques -->
        <section class="prof-section">
            <h2>⭐ Mes dernières critiques</h2>
            <?php if (empty($reviews)): ?>
                <p class="prof-empty">Tu n'as pas encore publié de critique.</p>
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
