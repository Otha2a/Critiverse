<?php
$activePage = 'actualites';
$css        = 'actualites';
require_once __DIR__ . '/../layouts/header.php';
?>
    <main>
        <section class="galerie">
            <h1>Actualité Films</h1>
            <div class="galerie-container">
                <figure>
                    <a href="/Critiverse/archives/images/films/avatar_fire.jpg"><img src="/Critiverse/archives/images/films/avatar_fire.jpg" class="F_reduit" alt="Avatar Fire"></a>
                    <a href="/Critiverse/archives/images/films/une_bataille.jpg"><img src="/Critiverse/archives/images/films/une_bataille.jpg" class="F_reduit" alt="Une Bataille"></a>
                    <a href="/Critiverse/archives/images/films/zootopie_2.jpg"><img src="/Critiverse/archives/images/films/zootopie_2.jpg" class="F_reduit" alt="Zootopie 2"></a>
                    <figcaption>Les meilleurs films de 2025</figcaption>
                </figure>
                <figure>
                    <img src="/Critiverse/archives/images/films/les_rayons.jpg" class="F_reduit" alt="Les Rayons">
                    <img src="/Critiverse/archives/images/films/gourou.jpg" class="F_reduit" alt="Gourou">
                    <img src="/Critiverse/archives/images/films/alter-ego.jpg" class="F_reduit" alt="Alter Ego">
                    <figcaption>Les films français de 2026</figcaption>
                </figure>
            </div>
        </section>
    </main>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
