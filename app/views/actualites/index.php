<?php
$activePage = 'actualites';
$css        = 'actualites';
require_once __DIR__ . '/../layouts/header.php';

$gradients = [
    'linear-gradient(135deg,#667eea,#764ba2)',
    'linear-gradient(135deg,#f093fb,#f5576c)',
    'linear-gradient(135deg,#4facfe,#00f2fe)',
    'linear-gradient(135deg,#43e97b,#38f9d7)',
    'linear-gradient(135deg,#fa709a,#fee140)',
    'linear-gradient(135deg,#a18cd1,#fbc2eb)',
    'linear-gradient(135deg,#fccb90,#d57eeb)',
    'linear-gradient(135deg,#ff9a9e,#fad0c4)',
    'linear-gradient(135deg,#a1c4fd,#c2e9fb)',
    'linear-gradient(135deg,#fd7043,#ff8a65)',
];

function etoiles(float $note): string {
    $sur5  = round($note / 2, 1);
    $plein = (int) floor($sur5);
    $demi  = ($sur5 - $plein) >= 0.5 ? 1 : 0;
    $vide  = 5 - $plein - $demi;
    return str_repeat('★', $plein) . str_repeat('½', $demi) . str_repeat('☆', $vide);
}
?>

<main class="actu-main">
    <div class="actu-hero">
        <h1>Actualités du moment</h1>
        <p>Films, séries et animés populaires — mis à jour en temps réel.</p>
    </div>

    <!-- ── FILMS ── -->
    <section class="actu-section">
        <div class="actu-section-header">
            <h2>🎬 Films tendance</h2>
            <span class="actu-badge">Sélection 2024</span>
        </div>
        <div class="actu-grid">
            <?php foreach ($films as $i => $film): ?>
                <div class="actu-card">
                    <div class="actu-card-img actu-noimg"
                         id="film-img-<?= $i ?>"
                         style="background:<?= $gradients[$i % count($gradients)] ?>">
                        <span id="film-letter-<?= $i ?>"><?= mb_strtoupper(mb_substr($film['title'], 0, 1)) ?></span>
                        <span class="actu-score"><?= number_format($film['note'], 1) ?></span>
                    </div>
                    <div class="actu-card-body">
                        <p class="actu-card-title"><?= htmlspecialchars($film['title']) ?></p>
                        <p class="actu-card-year"><?= $film['year'] ?> · <?= htmlspecialchars($film['genre']) ?></p>
                        <p class="actu-card-stars"><?= etoiles($film['note']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- ── SÉRIES ── -->
    <section class="actu-section">
        <div class="actu-section-header">
            <h2>📺 Séries du moment</h2>
            <span class="actu-badge">Via TVmaze</span>
        </div>
        <div class="actu-grid" id="grid-series">
            <p class="actu-loading">Chargement…</p>
        </div>
    </section>

    <!-- ── ANIMÉS ── -->
    <section class="actu-section">
        <div class="actu-section-header">
            <h2>⚔️ Animés populaires</h2>
            <span class="actu-badge">Via Jikan · MyAnimeList</span>
        </div>
        <div class="actu-grid" id="grid-animes">
            <p class="actu-loading">Chargement…</p>
        </div>
    </section>
</main>

<script>
// ── Affiches films via Wikipedia ─────────────────────────────────────
(function () {
    var films = <?= json_encode(array_values($films ?? [])) ?>;
    films.forEach(function (film, i) {
        fetch('https://en.wikipedia.org/api/rest_v1/page/summary/' + encodeURIComponent(film.wiki))
            .then(function (r) { return r.json(); })
            .then(function (data) {
                var src = (data.originalimage || data.thumbnail || {}).source;
                if (!src) return;
                var wrapper = document.getElementById('film-img-' + i);
                if (!wrapper) return;
                wrapper.style.background = '#111';
                var letter = document.getElementById('film-letter-' + i);
                if (letter) letter.remove();
                var img = document.createElement('img');
                img.src     = src;
                img.alt     = film.title;
                img.loading = 'lazy';
                img.style.cssText = 'width:100%;height:100%;object-fit:cover;display:block;';
                wrapper.insertBefore(img, wrapper.firstChild);
            })
            .catch(function () {});
    });
})();

// ── Helpers communs séries / animés ─────────────────────────────────
function noteEtoiles(note) {
    var sur5  = Math.round(note / 2 * 2) / 2;
    var plein = Math.floor(sur5);
    var demi  = (sur5 - plein) >= 0.5 ? 1 : 0;
    return '★'.repeat(plein) + (demi ? '½' : '') + '☆'.repeat(5 - plein - demi);
}

function creerCarte(poster, titre, annee, note) {
    var score = note ? parseFloat(note).toFixed(1) : null;
    return '<div class="actu-card">'
        + '<div class="actu-card-img">'
        + (poster ? '<img src="' + poster + '" alt="' + titre + '" loading="lazy">'
                  : '<div class="actu-noimg" style="background:#aaa"><span>'
                    + titre[0].toUpperCase() + '</span></div>')
        + (score ? '<span class="actu-score">' + score + '</span>' : '')
        + '</div>'
        + '<div class="actu-card-body">'
        + '<p class="actu-card-title">' + titre + '</p>'
        + (annee ? '<p class="actu-card-year">' + annee + '</p>' : '')
        + (score ? '<p class="actu-card-stars">' + noteEtoiles(parseFloat(note)) + '</p>' : '')
        + '</div></div>';
}

function afficherErreur(id) {
    document.getElementById(id).innerHTML =
        '<p class="actu-error">Impossible de charger les données.</p>';
}

// ── Séries : TVmaze schedule du jour ────────────────────────────────
(function () {
    var today = new Date().toISOString().slice(0, 10);
    fetch('https://api.tvmaze.com/schedule?country=US&date=' + today)
        .then(function (r) { return r.json(); })
        .then(function (data) {
            var vus = {}, items = [];
            for (var i = 0; i < data.length && items.length < 10; i++) {
                var show = data[i].show;
                if (show && !vus[show.id]) { vus[show.id] = true; items.push(show); }
            }
            if (!items.length) { afficherErreur('grid-series'); return; }
            document.getElementById('grid-series').innerHTML = items.map(function (s) {
                return creerCarte(
                    s.image ? s.image.medium : null,
                    s.name,
                    s.premiered ? s.premiered.slice(0, 4) : '',
                    s.rating && s.rating.average ? String(s.rating.average) : null
                );
            }).join('');
        })
        .catch(function () { afficherErreur('grid-series'); });
})();

// ── Animés : Jikan top airing ────────────────────────────────────────
(function () {
    fetch('https://api.jikan.moe/v4/top/anime?filter=airing&limit=10')
        .then(function (r) { return r.json(); })
        .then(function (data) {
            var items = data.data || [];
            if (!items.length) { afficherErreur('grid-animes'); return; }
            document.getElementById('grid-animes').innerHTML = items.map(function (a) {
                return creerCarte(
                    a.images && a.images.jpg ? a.images.jpg.image_url : null,
                    a.title_french || a.title,
                    a.year ? String(a.year) : '',
                    a.score ? String(a.score) : null
                );
            }).join('');
        })
        .catch(function () { afficherErreur('grid-animes'); });
})();
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
