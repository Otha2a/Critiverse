<?php
/**
 * Vue du formulaire de contact
 * Variables attendues : $title, $heading
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
        <a href="/apropos">À propos</a> |
        <a href="/contact">Contact</a>
    </nav>

    <header>
        <h1><?= htmlspecialchars($heading) ?></h1>
    </header>

    <main>
        <form method="get" action="/contact">
            <div>
                <label for="name">Nom :</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div>
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="message">Message :</label>
                <textarea id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit">Envoyer</button>
        </form>
    </main>
</body>
</html>