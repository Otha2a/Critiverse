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
</head>
<body>
    <header>
        <div class="search">
            <a href="/Critiverse/public/"><img src="/Critiverse/archives/images/autres/logo.png" class="logo" alt="Logo"></a>
            <input type="text" id="searchInput" placeholder="<?= htmlspecialchars($searchPlaceholder ?? 'Rechercher') ?>">
            <button type="button" onclick="if(typeof doSearch==='function')doSearch()">🔎</button>
        </div>
        <div style="display:flex;align-items:center;gap:10px;">
            <?php if (isset($_SESSION['user_id'])): ?>
                <span style="font-weight:bold;padding:8px 12px;">👤 <?= htmlspecialchars($_SESSION['username']) ?></span>
                <a href="/Critiverse/public/logout">
                    <button type="button">Déconnexion</button>
                </a>
            <?php else: ?>
                <a href="/Critiverse/public/login">
                    <button type="button">Se connecter</button>
                </a>
                <a href="/Critiverse/public/register">
                    <button type="button">S'inscrire</button>
                </a>
            <?php endif; ?>
        </div>
    </header>
    <?php
    $activeStyle = ' style="background-color:rgb(235,183,125);"';
    $nav = $activePage ?? '';
    ?>
    <nav class="navbar">
        <ul>
            <li><a href="/Critiverse/public/"<?= $nav==='accueil'    ? $activeStyle:''?>>Accueil</a></li>
            <li><a href="/Critiverse/public/actualites"<?= $nav==='actualites'? $activeStyle:''?>>Actualités</a></li>
            <li><a href="/Critiverse/public/films"<?= $nav==='films'  ? $activeStyle:''?>>Films</a></li>
            <li><a href="/Critiverse/public/series"<?= $nav==='series'? $activeStyle:''?>>Séries</a></li>
            <li><a href="/Critiverse/public/animes"<?= $nav==='animes'? $activeStyle:''?>>Animes</a></li>
            <li><a href="/Critiverse/public/critiques"<?= $nav==='critiques'? $activeStyle:''?>>Critiques Populaires</a></li>
        </ul>
    </nav>
