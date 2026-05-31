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

<!-- APERÇU ACTUALITÉS -->
<section style="background:var(--bg-card);padding:48px 0 36px;">
    <h2 class="section-title fade-in">Dernières actualités</h2>
    <p class="section-sub fade-in">Les sorties et tendances du moment</p>
    <div id="actu-preview" style="display:flex;gap:18px;padding:20px 40px;overflow-x:auto;justify-content:center;flex-wrap:wrap;"></div>
    <div style="text-align:center;margin-top:12px;">
        <a href="/Critiverse/public/actualites" style="color:#2f6df6;font-weight:600;font-size:14px;text-decoration:none;">Voir toutes les actualités →</a>
    </div>
</section>

<!-- APERÇU CRITIQUES POPULAIRES -->
<section style="padding:48px 0 36px;background:var(--bg);">
    <h2 class="section-title fade-in">Critiques populaires</h2>
    <p class="section-sub fade-in">Les avis les plus likés de la communauté</p>
    <div id="critique-preview" style="max-width:860px;margin:0 auto;padding:0 24px;"></div>
    <div style="text-align:center;margin-top:20px;">
        <a href="/Critiverse/public/critiques" style="color:#2f6df6;font-weight:600;font-size:14px;text-decoration:none;">Voir toutes les critiques →</a>
    </div>
</section>

<script>
(function () {
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

    // Aperçu actualités (3 films populaires TMDB)
    (async function loadActu() {
        const TMDB_KEY = '7f41925d9303e23359cf5a62ee62de74';
        const IMG      = 'https://image.tmdb.org/t/p/w300';
        const box      = document.getElementById('actu-preview');
        try {
            const res  = await fetch(`https://api.themoviedb.org/3/movie/now_playing?api_key=${TMDB_KEY}&language=fr-FR&page=1`);
            const data = await res.json();
            (data.results || []).slice(0, 6).forEach(function (m) {
                if (!m.poster_path) return;
                const card = document.createElement('a');
                card.href  = '/Critiverse/public/films';
                card.style.cssText = 'display:flex;flex-direction:column;align-items:center;text-decoration:none;color:inherit;width:130px;flex-shrink:0;';
                card.innerHTML = `<img src="${IMG}${m.poster_path}" alt="${m.title}" style="width:130px;height:195px;object-fit:cover;border-radius:10px;box-shadow:0 4px 12px rgba(0,0,0,.15);">
                    <span style="font-size:12px;font-weight:600;margin-top:8px;text-align:center;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;width:100%;">${m.title}</span>
                    <span style="font-size:11px;color:#888;">★ ${m.vote_average.toFixed(1)}</span>`;
                box.appendChild(card);
            });
        } catch (e) { box.innerHTML = '<p style="color:#aaa;font-size:13px;">Impossible de charger les actualités.</p>'; }
    })();

    // Aperçu critiques (top 3 films depuis l'API locale)
    (async function loadCritiques() {
        const box = document.getElementById('critique-preview');
        const TMDB_KEY = '7f41925d9303e23359cf5a62ee62de74';
        const IMG = 'https://image.tmdb.org/t/p/w92';
        try {
            const res  = await fetch('/Critiverse/public/api/top-reviews.php?type=film&limit=3');
            const data = await res.json();
            if (!data.success || !data.reviews.length) {
                box.innerHTML = '<p style="color:#aaa;font-size:13px;text-align:center;">Aucune critique pour le moment — soyez le premier !</p>';
                return;
            }
            const cards = await Promise.all(data.reviews.map(async function (r) {
                let title = '?', poster = null;
                try {
                    const mr   = await fetch(`https://api.themoviedb.org/3/movie/${r.media_id}?api_key=${TMDB_KEY}&language=fr-FR`);
                    const md   = await mr.json();
                    title  = md.title || '?';
                    poster = md.poster_path ? IMG + md.poster_path : null;
                } catch (e) {}
                const stars = '★'.repeat(r.score) + '☆'.repeat(5 - r.score);
                return `<div style="display:flex;gap:14px;background:var(--bg-card);padding:16px;border-radius:12px;margin-bottom:12px;box-shadow:0 2px 10px rgba(0,0,0,.15);">
                    ${poster ? `<img src="${poster}" style="width:56px;height:84px;object-fit:cover;border-radius:6px;flex-shrink:0;">` : '<div style="width:56px;height:84px;background:#eee;border-radius:6px;flex-shrink:0;"></div>'}
                    <div>
                        <div style="font-weight:700;font-size:14px;margin-bottom:2px;color:var(--text);">${title}</div>
                        <div style="color:#ffca08;font-size:15px;">${stars}</div>
                        <div style="font-size:12px;color:var(--text-muted);margin-bottom:6px;">👤 ${r.username || 'Anonyme'}</div>
                        <div style="font-size:13px;color:var(--text-muted);line-height:1.5;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;">${r.comment}</div>
                        <div style="font-size:12px;color:var(--text-muted);margin-top:4px;">👍 ${r.likes} &nbsp; 👎 ${r.dislikes}</div>
                    </div>
                </div>`;
            }));
            box.innerHTML = cards.join('');
        } catch (e) { box.innerHTML = ''; }
    })();
})();
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
