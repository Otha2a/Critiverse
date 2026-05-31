<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/Critiverse/archives/images/autres/logo.png">
    <title><?= htmlspecialchars($title ?? 'Critiverse') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <?php
        $styleVer = @filemtime($_SERVER['DOCUMENT_ROOT'] . '/Critiverse/public/assets/css/style.css') ?: time();
        $cssFile  = htmlspecialchars($css ?? 'accueil');
        $cssVer   = @filemtime($_SERVER['DOCUMENT_ROOT'] . '/Critiverse/public/assets/css/' . $cssFile . '.css') ?: time();
    ?>
    <link rel="stylesheet" href="/Critiverse/public/assets/css/style.css?v=<?= $styleVer ?>">
    <link rel="stylesheet" href="/Critiverse/public/assets/css/<?= $cssFile ?>.css?v=<?= $cssVer ?>">
    <?php if (!empty($extraCss)): ?><style><?= $extraCss ?></style><?php endif; ?>
    <script>
        /* Anti-flash : applique le thème avant tout rendu */
        (function(){
            var t = localStorage.getItem('critiverse-theme') || 'dark';
            document.documentElement.setAttribute('data-theme', t);
        })();
    </script>
</head>
<body>
<?php
$activeStyle = ' class="active"';
$nav = $activePage ?? '';
?>
<header class="site-header">

    <!-- Gauche : logo + recherche -->
    <div class="header-left">
        <a href="/Critiverse/public/">
            <img src="/Critiverse/archives/images/autres/logo.png" class="logo" alt="Logo">
        </a>
        <div class="header-search">
            <input type="text" id="searchInput" placeholder="<?= htmlspecialchars($searchPlaceholder ?? 'Rechercher') ?>">
            <button type="button" onclick="if(typeof doSearch==='function')doSearch()">🔎</button>
        </div>
    </div>

    <!-- Centre : navigation principale -->
    <nav class="header-nav">
        <a href="/Critiverse/public/"<?= $nav==='accueil'    ? $activeStyle:''?>>Accueil</a>
        <a href="/Critiverse/public/actualites"<?= $nav==='actualites'? $activeStyle:''?>>Actualités</a>
        <a href="/Critiverse/public/films"<?= $nav==='films'  ? $activeStyle:''?>>Films</a>
        <a href="/Critiverse/public/series"<?= $nav==='series'? $activeStyle:''?>>Séries</a>
        <a href="/Critiverse/public/animes"<?= $nav==='animes'? $activeStyle:''?>>Animes</a>
        <a href="/Critiverse/public/critiques"<?= $nav==='critiques'  ? $activeStyle:''?>>Critiques</a>
        <a href="/Critiverse/public/abonnement"<?= $nav==='abonnement' ? $activeStyle:''?>>Abonnement</a>
    </nav>

    <!-- Droite : utilisateur -->
    <div class="header-right">
        <button class="theme-toggle" id="theme-toggle" title="Changer le thème" onclick="toggleTheme()">🌙</button>
        <?php if (isset($_SESSION['user_id'])): ?>
            <?php
            $plan = $_SESSION['plan'] ?? 'gratuit';
            $badge = match($plan) {
                'premium' => '<span class="plan-badge plan-premium">⭐ Premium</span>',
                'pro'     => '<span class="plan-badge plan-pro">👑 Pro</span>',
                default   => ''
            };
            ?>
            <?php if (in_array($plan, ['premium', 'pro'])): ?>
                <?php
                $msgModel = new Message();
                $unread   = $msgModel->countUnread((int)$_SESSION['user_id']);
                ?>
                <a href="/Critiverse/public/messages" class="msg-icon-link" title="Messages privés">
                    💬<?php if ($unread > 0): ?><span class="msg-notif"><?= $unread ?></span><?php endif; ?>
                </a>
            <?php endif; ?>
            <a href="/Critiverse/public/profile" class="header-username" title="Mon profil">
                👤 <?= htmlspecialchars($_SESSION['username']) ?> <?= $badge ?>
            </a>
            <a href="/Critiverse/public/logout"><button type="button">Déconnexion</button></a>
        <?php else: ?>
            <a href="/Critiverse/public/login"><button type="button">Se connecter</button></a>
            <a href="/Critiverse/public/register"><button type="button" class="btn-outline">S'inscrire</button></a>
        <?php endif; ?>
    </div>

</header>
<?php
// Rétrocompatibilité : $activeStyle utilisé dans les sous-navs des pages films/séries/animes
$activeStyle = ' style="background:rgba(91,126,245,0.15);color:#5b7ef5;"';

// Bannière pub pour les utilisateurs plan gratuit connectés
if (isset($_SESSION['user_id']) && ($plan ?? 'gratuit') === 'gratuit'):
?>
<div class="pub-banner">
    📢 <strong>Publicité</strong> — Passez à <a href="/Critiverse/public/abonnement">Premium</a> pour supprimer les publicités et accéder à plus de fonctionnalités !
</div>
<?php endif; ?>
