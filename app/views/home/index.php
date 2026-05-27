<?php
$activePage = 'accueil';
$css = 'accueil';
require_once __DIR__ . '/../layouts/header.php';
?>

<!-- HERO -->
<section class="hero">
    <p class="hero-eyebrow">Plateforme communautaire française</p>
    <h1 class="hero-title">Découvrez, notez et<br><span>partagez vos passions</span></h1>
    <p class="hero-sub">Films, séries, animes — un seul endroit pour tout noter, tout critiquer, tout suivre.</p>
    <div class="hero-btns">
        <a href="/Critiverse/public/films" class="btn-primary">Commencer à explorer</a>
        <a href="/Critiverse/public/critiques" class="btn-outline">Voir les critiques</a>
    </div>
</section>

<!-- CE QU'ON PROPOSE -->
<section class="offer-section">
    <h2 class="section-title fade-in">Ce qu'on vous propose</h2>
    <p class="section-sub fade-in">Tout ce dont vous avez besoin pour suivre vos œuvres préférées</p>
    <div class="offer-grid">
        <a href="/Critiverse/public/films" class="offer-card fade-in">
            <div class="offer-icon">🎬</div>
            <h3>Films</h3>
            <p>Des milliers de films à découvrir. Notez, commentez et retrouvez les avis de la communauté.</p>
            <span class="card-link">Explorer →</span>
        </a>
        <a href="/Critiverse/public/series" class="offer-card fade-in">
            <div class="offer-icon">📺</div>
            <h3>Séries</h3>
            <p>Les meilleures séries du moment, triées par genre. Suivez vos favoris et partagez votre avis.</p>
            <span class="card-link">Explorer →</span>
        </a>
        <a href="/Critiverse/public/animes" class="offer-card fade-in">
            <div class="offer-icon">⚔️</div>
            <h3>Animes</h3>
            <p>L'univers de l'animation japonaise. Action, isekai, romance, horreur — à vous de choisir.</p>
            <span class="card-link">Explorer →</span>
        </a>
        <a href="/Critiverse/public/critiques" class="offer-card fade-in">
            <div class="offer-icon">⭐</div>
            <h3>Critiques</h3>
            <p>Les meilleures critiques de la communauté classées par likes. Lisez, votez, réagissez.</p>
            <span class="card-link">Explorer →</span>
        </a>
    </div>
</section>

<!-- QUI SOMMES-NOUS -->
<section class="mission-section">
    <div class="mission-inner fade-in">
        <h2>Qui sommes-nous ?</h2>
        <p>CritiVerse est une plateforme française dédiée aux passionné·e·s de cinéma, de séries et d'animation. Inspiré par l'esprit communautaire de Letterboxd, nous offrons un espace clair et accessible pour partager des avis, noter des œuvres et suivre l'actualité audiovisuelle.</p>
        <p>Le site est organisé autour de trois univers : <strong>Films</strong>, <strong>Séries</strong> et <strong>Animes</strong>. Vous y trouverez des tops, des critiques, des recommandations et des actualités mises à jour régulièrement.</p>
    </div>
</section>

<!-- ÉQUIPE -->
<section class="team-section">
    <h2 class="section-title fade-in">L'équipe NAMBRO</h2>
    <p class="team-sub fade-in">7 passionnés derrière Critiverse</p>
    <div class="team-grid">
        <div class="team-card fade-in c1">N<span>Nour Al Mutwaly</span></div>
        <div class="team-card fade-in c2">A<span>Alexane-Lee Desmazon</span></div>
        <div class="team-card fade-in c3">M<span>Mathys Ly</span></div>
        <div class="team-card fade-in c4">B<span>Benjamin Muller</span></div>
        <div class="team-card fade-in c5">R<span>Raphaël Jannin</span></div>
        <div class="team-card fade-in c6">O<span>Othmane Chattou</span></div>
        <div class="team-card fade-in c7">D<span>David Demaire</span></div>
    </div>
</section>

<!-- À L'AFFICHE -->
<section class="preview-section">
    <h2 class="section-title fade-in">À l'affiche en ce moment</h2>
    <p class="section-sub fade-in">Une sélection de titres à découvrir sur Critiverse</p>
    <div class="poster-grid">
        <a href="/Critiverse/public/films" class="poster fade-in">
            <img src="/Critiverse/archives/images/films/interstellar.jpg" alt="Interstellar">
            <span class="poster-title">Interstellar</span>
        </a>
        <a href="/Critiverse/public/films" class="poster fade-in">
            <img src="/Critiverse/archives/images/films/inception.jpg" alt="Inception">
            <span class="poster-title">Inception</span>
        </a>
        <a href="/Critiverse/public/films" class="poster fade-in">
            <img src="/Critiverse/archives/images/films/matrix.jpg" alt="Matrix">
            <span class="poster-title">Matrix</span>
        </a>
        <a href="/Critiverse/public/films" class="poster fade-in">
            <img src="/Critiverse/archives/images/films/titanic.jpg" alt="Titanic">
            <span class="poster-title">Titanic</span>
        </a>
        <a href="/Critiverse/public/films" class="poster fade-in">
            <img src="/Critiverse/archives/images/films/gladiator.jpg" alt="Gladiator">
            <span class="poster-title">Gladiator</span>
        </a>
        <a href="/Critiverse/public/films" class="poster fade-in">
            <img src="/Critiverse/archives/images/films/intouchables.jpg" alt="Intouchables">
            <span class="poster-title">Intouchables</span>
        </a>
        <a href="/Critiverse/public/films" class="poster fade-in">
            <img src="/Critiverse/archives/images/films/forrest.jpg" alt="Forrest Gump">
            <span class="poster-title">Forrest Gump</span>
        </a>
        <a href="/Critiverse/public/series" class="poster fade-in">
            <img src="/Critiverse/archives/images/series/the_bear.jpg" alt="The Bear">
            <span class="poster-title">The Bear</span>
        </a>
        <a href="/Critiverse/public/series" class="poster fade-in">
            <img src="/Critiverse/archives/images/series/stranger.jpg" alt="Stranger Things">
            <span class="poster-title">Stranger Things</span>
        </a>
        <a href="/Critiverse/public/series" class="poster fade-in">
            <img src="/Critiverse/archives/images/series/got.jpg" alt="Game of Thrones">
            <span class="poster-title">Game of Thrones</span>
        </a>
        <a href="/Critiverse/public/series" class="poster fade-in">
            <img src="/Critiverse/archives/images/series/thewitcher.jpg" alt="The Witcher">
            <span class="poster-title">The Witcher</span>
        </a>
        <a href="/Critiverse/public/series" class="poster fade-in">
            <img src="/Critiverse/archives/images/series/prisonbreak.jpg" alt="Prison Break">
            <span class="poster-title">Prison Break</span>
        </a>
        <a href="/Critiverse/public/series" class="poster fade-in">
            <img src="/Critiverse/archives/images/series/dexter.jpg" alt="Dexter">
            <span class="poster-title">Dexter</span>
        </a>
        <a href="/Critiverse/public/series" class="poster fade-in">
            <img src="/Critiverse/archives/images/series/friends.jpg" alt="Friends">
            <span class="poster-title">Friends</span>
        </a>
    </div>
</section>

<script>
(function () {
    // Stagger delay automatique pour les posters
    document.querySelectorAll('.poster.fade-in').forEach(function (el, i) {
        el.style.transitionDelay = (i * 0.04) + 's';
    });

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.fade-in').forEach(function (el) {
        observer.observe(el);
    });
})();
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
