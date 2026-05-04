<?php
/**
 * Vue de la page d’accueil
 * Variables attendues : $title, $welcome, $description
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
        <h1><?= htmlspecialchars($welcome) ?></h1>
        <p><?= htmlspecialchars($description) ?></p>
    </header>

    <main>
        <section>
            <h2>Quelques idées pour commencer</h2>
            <ul>
                <li>Reproduire la section accueil de votre site statique depuis <code>archives/pages/accueil.html</code>.</li>
                <li>Ajouter une carte de présentation pour les films récents.</li>
                <li>Créer une route pour les films avec <code>/movies</code> ensuite.</li>
                <li>Aller à la page <a href="/apropos">À propos</a>.</li>
            </ul>
        </section>

        <section>
            <h2>Étapes réalisées</h2>
            <p>La route <code>/</code> est maintenant active et affiche cette page.</p>
        </section>
    </main>
</body>
</html>
