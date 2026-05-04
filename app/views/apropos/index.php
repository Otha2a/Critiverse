<?php
/**
 * Vue de la page À Propos
 * Variables attendues : $title, $heading, $content
 */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <nav>
        <a href="/">Accueil</a> |
        <a href="/apropos">À propos</a>
    </nav>

    <header>
        <h1><?= htmlspecialchars($heading) ?></h1>
    </header>

    <main>
        <p><?= htmlspecialchars($content) ?></p>
        <p>Retourner à la page <a href="/">d’accueil</a>.</p>
    </main>
</body>
</html>
