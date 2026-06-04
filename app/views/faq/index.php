<?php
$activePage = '';
$css        = 'contacts';
$title      = 'FAQ - Critiverse';
require_once __DIR__ . '/../layouts/header.php';
?>

<main style="max-width:800px;margin:50px auto;padding:0 24px 60px;">

    <div style="background:white;border-radius:16px;padding:48px 52px;box-shadow:0 4px 20px rgba(0,0,0,.08);">

        <h1 style="font-size:1.8rem;font-weight:800;margin:0 0 6px;color:#111;">Foire aux questions</h1>
        <p style="color:#888;font-size:14px;margin:0 0 40px;">Retrouvez les réponses aux questions les plus fréquentes sur Critiverse.</p>

        <!-- Q1 -->
        <section style="margin-bottom:32px;">
            <h2 style="font-size:1.05rem;font-weight:700;color:#2f6df6;margin:0 0 10px;padding-bottom:8px;border-bottom:2px solid #e8f0fe;">
                C'est quoi Critiverse ?
            </h2>
            <p style="font-size:14px;color:#444;line-height:1.8;margin:0;">
                Critiverse est une plateforme communautaire dédiée aux critiques de films, séries et animés. Tu peux noter des œuvres, lire les avis d'autres membres, participer au forum et suivre tes contenus préférés via ta watchlist.
            </p>
        </section>

        <!-- Q2 -->
        <section style="margin-bottom:32px;">
            <h2 style="font-size:1.05rem;font-weight:700;color:#2f6df6;margin:0 0 10px;padding-bottom:8px;border-bottom:2px solid #e8f0fe;">
                Comment créer un compte ?
            </h2>
            <p style="font-size:14px;color:#444;line-height:1.8;margin:0;">
                Clique sur <strong>S'inscrire</strong> dans le menu en haut à droite. Remplis le formulaire avec un pseudo, une adresse e-mail et un mot de passe. Ton compte est actif immédiatement.
            </p>
        </section>

        <!-- Q3 -->
        <section style="margin-bottom:32px;">
            <h2 style="font-size:1.05rem;font-weight:700;color:#2f6df6;margin:0 0 10px;padding-bottom:8px;border-bottom:2px solid #e8f0fe;">
                Comment noter un film ou une série ?
            </h2>
            <p style="font-size:14px;color:#444;line-height:1.8;margin:0;">
                Rends-toi sur la page <strong>Notation</strong> depuis le menu principal. Choisis la catégorie (film, série ou animé), sélectionne l'œuvre et attribue-lui une note accompagnée d'un avis.
            </p>
        </section>

        <!-- Q4 -->
        <section style="margin-bottom:32px;">
            <h2 style="font-size:1.05rem;font-weight:700;color:#2f6df6;margin:0 0 10px;padding-bottom:8px;border-bottom:2px solid #e8f0fe;">
                C'est quoi la Watchlist ?
            </h2>
            <p style="font-size:14px;color:#444;line-height:1.8;margin:0;">
                La Watchlist est ta liste personnelle de films, séries et animés que tu souhaites regarder ou que tu as déjà vus. Tu peux y ajouter ou retirer des contenus à tout moment depuis ton profil.
            </p>
        </section>

        <!-- Q5 -->
        <section style="margin-bottom:32px;">
            <h2 style="font-size:1.05rem;font-weight:700;color:#2f6df6;margin:0 0 10px;padding-bottom:8px;border-bottom:2px solid #e8f0fe;">
                Comment fonctionne l'abonnement Premium ?
            </h2>
            <p style="font-size:14px;color:#444;line-height:1.8;margin:0;">
                L'abonnement Premium donne accès à des fonctionnalités exclusives : statistiques avancées, badge Premium sur le profil, accès prioritaire aux actualités. Consulte la page <a href="/Critiverse/public/abonnement" style="color:#2f6df6;text-decoration:none;">Abonnement</a> pour voir les offres disponibles.
            </p>
        </section>

        <!-- Q6 -->
        <section style="margin-bottom:32px;">
            <h2 style="font-size:1.05rem;font-weight:700;color:#2f6df6;margin:0 0 10px;padding-bottom:8px;border-bottom:2px solid #e8f0fe;">
                Comment modifier mon profil ou ma photo ?
            </h2>
            <p style="font-size:14px;color:#444;line-height:1.8;margin:0;">
                Connecte-toi, puis clique sur ton avatar en haut à droite pour accéder à ton profil. Tu peux y changer ton pseudo, ta bio et ta photo de profil.
            </p>
        </section>

        <!-- Q7 -->
        <section>
            <h2 style="font-size:1.05rem;font-weight:700;color:#2f6df6;margin:0 0 10px;padding-bottom:8px;border-bottom:2px solid #e8f0fe;">
                J'ai un problème, qui contacter ?
            </h2>
            <p style="font-size:14px;color:#444;line-height:1.8;margin:0;">
                Utilise notre <a href="/Critiverse/public/contact" style="color:#2f6df6;text-decoration:none;">formulaire de contact</a> ou envoie un e-mail à <a href="mailto:support@critiverse.fr" style="color:#2f6df6;text-decoration:none;">support@critiverse.fr</a>. Nous répondons sous 48 h.
            </p>
        </section>

    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
