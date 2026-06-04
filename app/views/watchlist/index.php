<?php
$activePage = '';
$css        = 'watchlist';
$title      = 'Ma Watchlist - Critiverse';
require_once __DIR__ . '/../layouts/header.php';

$films  = array_values(array_filter($items, fn($i) => $i['media_type'] === 'film'));
$series = array_values(array_filter($items, fn($i) => $i['media_type'] === 'serie'));
$animes = array_values(array_filter($items, fn($i) => $i['media_type'] === 'anime'));
?>

<div class="wl-hero">
    <h1>🎯 Ma Watchlist</h1>
    <p>Retrouvez tous les films, séries et animes que vous avez sauvegardés.</p>
</div>

<!-- ── Films ── -->
<div class="wl-section">
    <div class="wl-section-header">
        <h2>🎬 Films</h2>
        <span class="wl-count" id="wl-count-film"><?= count($films) ?></span>
    </div>
    <div class="wl-grid" id="wl-grid-film"></div>
</div>

<!-- ── Séries ── -->
<div class="wl-section">
    <div class="wl-section-header">
        <h2>📺 Séries</h2>
        <span class="wl-count" id="wl-count-serie"><?= count($series) ?></span>
    </div>
    <div class="wl-grid" id="wl-grid-serie"></div>
</div>

<!-- ── Animes ── -->
<div class="wl-section">
    <div class="wl-section-header">
        <h2>⚔️ Animes</h2>
        <span class="wl-count" id="wl-count-anime"><?= count($animes) ?></span>
    </div>
    <div class="wl-grid" id="wl-grid-anime"></div>
</div>

<script>
const TMDB_KEY = '7f41925d9303e23359cf5a62ee62de74';
const TMDB     = 'https://api.themoviedb.org/3';
const IMG      = 'https://image.tmdb.org/t/p/w300';

const FILMS  = <?= json_encode($films)  ?>;
const SERIES = <?= json_encode($series) ?>;
const ANIMES = <?= json_encode($animes) ?>;

function formatDate(iso) {
    return new Date(iso).toLocaleDateString('fr-FR', {day:'2-digit', month:'short', year:'numeric'});
}

function buildCard(id, title, poster, detailUrl, type, addedAt) {
    const img = poster
        ? `<a href="${detailUrl}"><img src="${poster}" alt="${title}" loading="lazy"></a>`
        : `<a href="${detailUrl}" class="wl-no-poster">${type==='film'?'🎬':type==='serie'?'📺':'⚔️'}</a>`;
    return `
    <div class="wl-card" id="wl-card-${type}-${id}">
        <div class="wl-card-img">${img}</div>
        <div class="wl-card-body">
            <a href="${detailUrl}" class="wl-card-title" title="${title}">${title}</a>
            <div class="wl-card-date">📅 ${formatDate(addedAt)}</div>
            <button class="wl-remove-btn" onclick="removeItem('${type}', ${id}, this)">🗑️ Retirer</button>
        </div>
    </div>`;
}

async function removeItem(type, id, btn) {
    btn.disabled = true;
    btn.textContent = '...';
    try {
        const res  = await fetch('/Critiverse/public/api/watchlist.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({type, media_id: id})
        });
        const data = await res.json();
        if (data.action === 'removed') {
            const card = document.getElementById(`wl-card-${type}-${id}`);
            card.style.transition = 'opacity 0.3s, transform 0.3s';
            card.style.opacity    = '0';
            card.style.transform  = 'scale(0.9)';
            setTimeout(() => { card.remove(); updateCount(type); }, 300);
        }
    } catch (e) {
        btn.disabled = false;
        btn.textContent = '🗑️ Retirer';
    }
}

function updateCount(type) {
    const grid  = document.getElementById(`wl-grid-${type}`);
    const count = document.getElementById(`wl-count-${type}`);
    const n     = grid ? grid.querySelectorAll('.wl-card').length : 0;
    if (count) count.textContent = n;
    if (n === 0 && grid) {
        grid.innerHTML = '<p class="wl-empty">Aucun élément dans cette section.</p>';
    }
}

async function loadSection(items, type, gridId, getInfo) {
    const grid = document.getElementById(gridId);
    if (!grid) return;
    if (!items.length) {
        grid.innerHTML = '<p class="wl-empty">Aucun élément sauvegardé pour le moment.</p>';
        return;
    }
    grid.innerHTML = '<p class="wl-loading">Chargement...</p>';
    const cards = [];
    for (const item of items) {
        try {
            const info = await getInfo(item.media_id);
            cards.push(buildCard(item.media_id, info.title, info.poster, info.url, type, item.added_at));
        } catch (e) { /* ignore */ }
        if (type === 'anime') await new Promise(r => setTimeout(r, 350));
    }
    grid.innerHTML = cards.join('') || '<p class="wl-empty">Aucun élément sauvegardé.</p>';
    document.getElementById(`wl-count-${type}`).textContent = cards.length;
}

async function getFilmInfo(id) {
    const r = await fetch(`${TMDB}/movie/${id}?api_key=${TMDB_KEY}&language=fr-FR`);
    const d = await r.json();
    return { title: d.title||'?', poster: d.poster_path ? IMG+d.poster_path : null, url: `/Critiverse/public/notation-film?id=${id}` };
}

async function getSerieInfo(id) {
    const r = await fetch(`${TMDB}/tv/${id}?api_key=${TMDB_KEY}&language=fr-FR`);
    const d = await r.json();
    return { title: d.name||'?', poster: d.poster_path ? IMG+d.poster_path : null, url: `/Critiverse/public/notation-serie?id=${id}` };
}

async function getAnimeInfo(id) {
    const r = await fetch(`https://api.jikan.moe/v4/anime/${id}`);
    const d = await r.json();
    return { title: d.data?.title||'?', poster: d.data?.images?.jpg?.image_url||null, url: `/Critiverse/public/notation?id=${id}` };
}

loadSection(FILMS,  'film',  'wl-grid-film',  getFilmInfo);
loadSection(SERIES, 'serie', 'wl-grid-serie', getSerieInfo);
loadSection(ANIMES, 'anime', 'wl-grid-anime', getAnimeInfo);
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
