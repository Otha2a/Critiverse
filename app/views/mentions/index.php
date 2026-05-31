<?php
$activePage = '';
$css        = 'contacts';
$title      = 'Mentions légales - Critiverse';
require_once __DIR__ . '/../layouts/header.php';
?>

<main style="max-width:800px;margin:50px auto;padding:0 24px 60px;">

    <div style="background:white;border-radius:16px;padding:48px 52px;box-shadow:0 4px 20px rgba(0,0,0,.08);">

        <h1 style="font-size:1.8rem;font-weight:800;margin:0 0 6px;color:#111;">Mentions légales</h1>
        <p style="color:#888;font-size:14px;margin:0 0 40px;">Dernière mise à jour : mai 2025</p>

        <!-- Éditeur -->
        <section style="margin-bottom:36px;">
            <h2 style="font-size:1.1rem;font-weight:700;color:#2f6df6;margin:0 0 14px;padding-bottom:8px;border-bottom:2px solid #e8f0fe;">1. Éditeur du site</h2>
            <p style="font-size:14px;color:#444;line-height:1.8;margin:0;">
                Le site <strong>Critiverse</strong> est édité par une équipe étudiante dans le cadre d'un projet pédagogique.<br>
                Email de contact : <a href="mailto:support@critiverse.fr" style="color:#2f6df6;text-decoration:none;">support@critiverse.fr</a><br>
                Pays : France
            </p>
        </section>

        <!-- Hébergement -->
        <section style="margin-bottom:36px;">
            <h2 style="font-size:1.1rem;font-weight:700;color:#2f6df6;margin:0 0 14px;padding-bottom:8px;border-bottom:2px solid #e8f0fe;">2. Hébergement</h2>
            <p style="font-size:14px;color:#444;line-height:1.8;margin:0;">
                Ce site est hébergé localement via <strong>XAMPP</strong> dans un cadre de développement.<br>
                En production, l'hébergement sera assuré par un prestataire agréé établi en France.
            </p>
        </section>

        <!-- Propriété intellectuelle -->
        <section style="margin-bottom:36px;">
            <h2 style="font-size:1.1rem;font-weight:700;color:#2f6df6;margin:0 0 14px;padding-bottom:8px;border-bottom:2px solid #e8f0fe;">3. Propriété intellectuelle</h2>
            <p style="font-size:14px;color:#444;line-height:1.8;margin:0;">
                L'ensemble des contenus présents sur Critiverse (logo, design, code source, textes) sont protégés par le droit d'auteur.<br>
                Les affiches et données de films/séries/animés proviennent des APIs <strong>TMDB</strong> et <strong>MyAnimeList (Jikan)</strong> et restent la propriété de leurs ayants droit respectifs.<br>
                Toute reproduction sans autorisation est interdite.
            </p>
        </section>

        <!-- Données personnelles -->
        <section style="margin-bottom:36px;">
            <h2 style="font-size:1.1rem;font-weight:700;color:#2f6df6;margin:0 0 14px;padding-bottom:8px;border-bottom:2px solid #e8f0fe;">4. Données personnelles (RGPD)</h2>
            <p style="font-size:14px;color:#444;line-height:1.8;margin:0;">
                Critiverse collecte uniquement les données nécessaires au fonctionnement du service : pseudo, adresse email et mot de passe hashé.<br>
                Ces données ne sont ni vendues ni transmises à des tiers.<br>
                Conformément au <strong>Règlement Général sur la Protection des Données (RGPD)</strong>, vous disposez d'un droit d'accès, de rectification et de suppression de vos données.<br>
                Pour exercer ces droits : <a href="mailto:support@critiverse.fr" style="color:#2f6df6;text-decoration:none;">support@critiverse.fr</a>
            </p>
        </section>

        <!-- Cookies -->
        <section style="margin-bottom:36px;">
            <h2 style="font-size:1.1rem;font-weight:700;color:#2f6df6;margin:0 0 14px;padding-bottom:8px;border-bottom:2px solid #e8f0fe;">5. Cookies</h2>
            <p style="font-size:14px;color:#444;line-height:1.8;margin:0;">
                Ce site utilise uniquement des cookies de session nécessaires au fonctionnement de l'authentification.<br>
                Aucun cookie publicitaire ou de tracking n'est utilisé.
            </p>
        </section>

        <!-- Responsabilité -->
        <section>
            <h2 style="font-size:1.1rem;font-weight:700;color:#2f6df6;margin:0 0 14px;padding-bottom:8px;border-bottom:2px solid #e8f0fe;">6. Limitation de responsabilité</h2>
            <p style="font-size:14px;color:#444;line-height:1.8;margin:0;">
                Les avis et critiques publiés sur Critiverse sont ceux de leurs auteurs et n'engagent pas l'équipe du site.<br>
                Critiverse se réserve le droit de supprimer tout contenu inapproprié signalé par la communauté.
            </p>
        </section>

    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
