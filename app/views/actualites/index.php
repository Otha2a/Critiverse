<?php
$activePage = 'actualites';
$css        = 'actualites';
require_once __DIR__ . '/../layouts/header.php';
?>

<main class="actu-main">
    <div class="actu-hero">
        <h1>Actualités du moment</h1>
        <p>Films, séries et animés récents — mis à jour en temps réel.</p>
    </div>

    <!-- ── FILMS ── -->
    <section class="actu-section">
        <div class="actu-section-header">
            <h2>🎬 Films en salle</h2>
            <span class="actu-badge">Via TMDB</span>
        </div>
        <div class="actu-carousel">
            <button class="actu-arrow" onclick="defileCarousel('grid-films',-1)">&#8249;</button>
            <div class="actu-grid" id="grid-films"><p class="actu-loading">Chargement…</p></div>
            <button class="actu-arrow" onclick="defileCarousel('grid-films', 1)">&#8250;</button>
        </div>
    </section>

    <!-- ── SÉRIES ── -->
    <section class="actu-section">
        <div class="actu-section-header">
            <h2>📺 Séries en cours</h2>
            <span class="actu-badge">Via TMDB</span>
        </div>
        <div class="actu-carousel">
            <button class="actu-arrow" onclick="defileCarousel('grid-series',-1)">&#8249;</button>
            <div class="actu-grid" id="grid-series"><p class="actu-loading">Chargement…</p></div>
            <button class="actu-arrow" onclick="defileCarousel('grid-series', 1)">&#8250;</button>
        </div>
    </section>

    <!-- ── ANIMÉS ── -->
    <section class="actu-section">
        <div class="actu-section-header">
            <h2>⚔️ Animés de la saison</h2>
            <span class="actu-badge">Via Jikan · MyAnimeList</span>
        </div>
        <div class="actu-carousel">
            <button class="actu-arrow" onclick="defileCarousel('grid-animes',-1)">&#8249;</button>
            <div class="actu-grid" id="grid-animes"><p class="actu-loading">Chargement…</p></div>
            <button class="actu-arrow" onclick="defileCarousel('grid-animes', 1)">&#8250;</button>
        </div>
    </section>
</main>

<script>
const TMDB_KEY = '7f41925d9303e23359cf5a62ee62de74';
const TMDB     = 'https://api.themoviedb.org/3';
const IMG      = 'https://image.tmdb.org/t/p/w300';

function noteEtoiles(note) {
    var sur5  = Math.round(note / 2 * 2) / 2;
    var plein = Math.floor(sur5);
    var demi  = (sur5 - plein) >= 0.5 ? 1 : 0;
    return '★'.repeat(plein) + (demi ? '½' : '') + '☆'.repeat(5 - plein - demi);
}

function creerCarte(poster, titre, annee, note, url) {
    var score = note ? parseFloat(note).toFixed(1) : null;
    var wrap  = url ? '<a href="' + url + '" style="text-decoration:none;color:inherit;">' : '';
    var wend  = url ? '</a>' : '';
    return '<div class="actu-card">'
        + wrap
        + '<div class="actu-card-img">'
        + (poster
            ? '<img src="' + poster + '" alt="' + titre + '" loading="lazy">'
            : '<div class="actu-noimg" style="background:#aaa"><span>' + titre[0].toUpperCase() + '</span></div>')
        + (score ? '<span class="actu-score">' + score + '</span>' : '')
        + '</div>'
        + '<div class="actu-card-body">'
        + '<p class="actu-card-title">' + titre + '</p>'
        + (annee ? '<p class="actu-card-year">' + annee + '</p>' : '')
        + (score ? '<p class="actu-card-stars">' + noteEtoiles(parseFloat(note)) + '</p>' : '')
        + '</div>'
        + wend
        + '</div>';
}

function defileCarousel(id, dir) {
    var el = document.getElementById(id);
    el.scrollBy({ left: dir * (180 + 16) * 3, behavior: 'smooth' });
}

function afficherErreur(id) {
    document.getElementById(id).innerHTML =
        '<p class="actu-error">Impossible de charger les données.</p>';
}

// ── Films en salle (TMDB now_playing page 1+2) ──────────────────────
Promise.all([
    fetch(TMDB + '/movie/now_playing?api_key=' + TMDB_KEY + '&language=fr-FR&page=1').then(function(r){return r.json();}),
    fetch(TMDB + '/movie/now_playing?api_key=' + TMDB_KEY + '&language=fr-FR&page=2').then(function(r){return r.json();})
]).then(function(pages) {
    var items = (pages[0].results || []).concat(pages[1].results || []).slice(0, 20);
    if (!items.length) { afficherErreur('grid-films'); return; }
    document.getElementById('grid-films').innerHTML = items.map(function(m) {
        return creerCarte(
            m.poster_path ? IMG + m.poster_path : null,
            m.title,
            m.release_date ? m.release_date.slice(0, 4) : '',
            m.vote_average ? String(m.vote_average) : null,
            '/Critiverse/public/notation-film?id=' + m.id
        );
    }).join('');
}).catch(function() { afficherErreur('grid-films'); });

// ── Séries en cours (TMDB on_the_air page 1+2) ──────────────────────
Promise.all([
    fetch(TMDB + '/tv/on_the_air?api_key=' + TMDB_KEY + '&language=fr-FR&page=1').then(function(r){return r.json();}),
    fetch(TMDB + '/tv/on_the_air?api_key=' + TMDB_KEY + '&language=fr-FR&page=2').then(function(r){return r.json();})
]).then(function(pages) {
    var items = (pages[0].results || []).concat(pages[1].results || []).slice(0, 20);
    if (!items.length) { afficherErreur('grid-series'); return; }
    document.getElementById('grid-series').innerHTML = items.map(function(s) {
        return creerCarte(
            s.poster_path ? IMG + s.poster_path : null,
            s.name,
            s.first_air_date ? s.first_air_date.slice(0, 4) : '',
            s.vote_average ? String(s.vote_average) : null,
            '/Critiverse/public/notation-serie?id=' + s.id
        );
    }).join('');
}).catch(function() { afficherErreur('grid-series'); });

// ── Animés de la saison (Jikan seasons/now) ──────────────────────────
fetch('https://api.jikan.moe/v4/seasons/now?limit=25')
    .then(function(r) { return r.json(); })
    .then(function(data) {
        var items = (data.data || []).slice(0, 20);
        if (!items.length) { afficherErreur('grid-animes'); return; }
        document.getElementById('grid-animes').innerHTML = items.map(function(a) {
            return creerCarte(
                a.images && a.images.jpg ? a.images.jpg.image_url : null,
                a.title_french || a.title,
                a.year ? String(a.year) : '',
                a.score ? String(a.score) : null,
                '/Critiverse/public/notation?id=' + a.mal_id
            );
        }).join('');
    })
    .catch(function() { afficherErreur('grid-animes'); });
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
