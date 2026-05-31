<?php
$activePage = 'apropos';
$css        = 'apropos';
$title      = 'À propos - Critiverse';
require_once __DIR__ . '/../layouts/header.php';
?>

<!-- ── Hero ── -->
<section class="apropos-hero">
    <img src="/Critiverse/archives/images/autres/logo.png" alt="Logo Critiverse" class="apropos-logo">
    <h1>Bienvenue sur <span>Critiverse</span></h1>
    <p>La plateforme française pour les passionnés de cinéma, séries et animés.</p>
</section>

<!-- ── Mission & Vision ── -->
<section class="apropos-section apropos-cards-2">
    <div class="apropos-card">
        <div class="apropos-card-icon">🎯</div>
        <h2>Notre mission</h2>
        <p>Critiverse est une plateforme française dédiée aux passionné·e·s de cinéma, de séries et d'animation. Notre objectif est d'offrir un espace clair, moderne et accessible pour découvrir de nouvelles œuvres, partager des avis et suivre l'actualité du monde audiovisuel.</p>
    </div>
    <div class="apropos-card">
        <div class="apropos-card-icon">🌍</div>
        <h2>Notre vision</h2>
        <p>Inspiré par l'esprit communautaire de Letterboxd, Critiverse permet à chacun de noter des œuvres, rédiger des critiques et garder une trace de tout ce qu'il regarde. Nous voulons rassembler une communauté curieuse, bienveillante et passionnée.</p>
    </div>
</section>

<!-- ── Ce qu'on propose ── -->
<section class="apropos-section">
    <h2 class="apropos-section-title">Ce que nous proposons</h2>
    <div class="apropos-features">
        <div class="apropos-feature">
            <span>🎬</span>
            <h3>Films</h3>
            <p>Explorez les films populaires, notez-les et partagez vos critiques avec la communauté.</p>
        </div>
        <div class="apropos-feature">
            <span>📺</span>
            <h3>Séries</h3>
            <p>Suivez les séries en cours, découvrez les tendances et lisez les avis des autres membres.</p>
        </div>
        <div class="apropos-feature">
            <span>⚔️</span>
            <h3>Animés</h3>
            <p>Plongez dans l'univers de l'animation japonaise avec les tops saison et les critiques.</p>
        </div>
        <div class="apropos-feature">
            <span>⭐</span>
            <h3>Critiques</h3>
            <p>Consultez le top des meilleures critiques de la communauté, likez et débattez.</p>
        </div>
    </div>
</section>

<!-- ── Équipe ── -->
<section class="apropos-section">
    <h2 class="apropos-section-title">L'équipe <span style="color:#2f6df6;">NAMBRO</span></h2>
    <p class="apropos-section-sub">7 étudiants passionnés derrière ce projet.</p>
    <div class="apropos-team">
        <?php
        $membres = [
            ['nom' => 'Al Mutwaly Nour',      'role' => 'Développeur',  'initiales' => 'AN', 'couleur' => '#e74c3c'],
            ['nom' => 'Desmazon Alexane-Lee',  'role' => 'Développeuse', 'initiales' => 'DA', 'couleur' => '#9b59b6'],
            ['nom' => 'Ly Mathys',             'role' => 'Développeur',  'initiales' => 'LM', 'couleur' => '#2980b9'],
            ['nom' => 'Chattou Othmane',       'role' => 'Développeur',  'initiales' => 'CO', 'couleur' => '#27ae60'],
            ['nom' => 'Muller Benjamin',       'role' => 'Développeur',  'initiales' => 'MB', 'couleur' => '#e67e22'],
            ['nom' => 'Jannin Raphael',        'role' => 'Développeur',  'initiales' => 'JR', 'couleur' => '#16a085'],
            ['nom' => 'Demaire David',         'role' => 'Développeur',  'initiales' => 'DD', 'couleur' => '#8e44ad'],
        ];
        foreach ($membres as $m): ?>
            <div class="apropos-membre">
                <div class="apropos-avatar" style="background:<?= $m['couleur'] ?>;">
                    <?= $m['initiales'] ?>
                </div>
                <strong><?= htmlspecialchars($m['nom']) ?></strong>
                <span><?= $m['role'] ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
