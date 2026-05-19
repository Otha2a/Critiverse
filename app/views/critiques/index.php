<?php
$activePage = 'critiques';
$css        = 'critiques';
$title      = 'Critiques Populaires - Critiverse';
$isLoggedIn = isset($_SESSION['user_id']);
require_once __DIR__ . '/../layouts/header.php';
?>

<style>
.critiques-section { max-width: 1100px; margin: 40px auto; padding: 0 24px; }
.critiques-section h2 { font-size: 22px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
.section-tag { padding: 4px 12px; border-radius: 20px; font-size: 13px; font-weight: bold; color: white; }
.tag-film   { background: #2f6df6; }
.tag-serie  { background: #7c3aed; }
.tag-anime  { background: #e55e00; }
.critique-card {
    display: flex; gap: 18px; background: white;
    padding: 18px; border-radius: 12px; margin-bottom: 14px;
    box-shadow: 0 2px 10px rgba(0,0,0,.07); align-items: flex-start;
}
.critique-card img {
    width: 90px; height: 135px; object-fit: cover;
    border-radius: 8px; flex-shrink: 0;
    background: #eee;
}
.critique-card .no-poster {
    width: 90px; height: 135px; border-radius: 8px; flex-shrink: 0;
    background: #e0e0e0; display: flex; align-items: center;
    justify-content: center; font-size: 28px;
}
.critique-body { flex: 1; }
.critique-title { font-size: 16px; font-weight: bold; margin: 0 0 4px; color: #111; }
.critique-stars { color: #ffca08; font-size: 18px; margin-bottom: 4px; }
.critique-meta  { font-size: 13px; color: #888; margin-bottom: 8px; }
.critique-text  { font-size: 14px; color: #333; line-height: 1.6; margin-bottom: 10px; }
.vote-row { display: flex; gap: 10px; }
.vote-btn {
    border-radius: 20px; padding: 4px 14px; cursor: pointer;
    font-size: 13px; border: 1px solid #ddd; background: #f5f5f5; color: #555;
}
.vote-btn:hover { background: #eee; }
.empty-msg { color: #999; font-style: italic; padding: 20px 0; }
.loading-msg { color: #888; padding: 20px 0; }
hr.sep { border: none; border-top: 1px solid #eee; margin: 40px 0; }
</style>

<!-- ── FILMS ────────────────────────────────────────────────────────────────── -->
<div class="critiques-section">
    <h2><span class="section-tag tag-film">Films</span> Top 10 critiques Films</h2>
    <div id="list-film"><p class="loading-msg">Chargement...</p></div>
</div>

<hr class="sep">

<!-- ── SÉRIES ──────────────────────────────────────────────────────────────── -->
<div class="critiques-section">
    <h2><span class="section-tag tag-serie">Séries</span> Top 10 critiques Séries</h2>
    <div id="list-serie"><p class="loading-msg">Chargement...</p></div>
</div>

<hr class="sep">

<!-- ── ANIMÉS ──────────────────────────────────────────────────────────────── -->
<div class="critiques-section">
    <h2><span class="section-tag tag-anime">Animés</span> Top 10 critiques Animés</h2>
    <div id="list-anime"><p class="loading-msg">Chargement...</p></div>
</div>

<script>
const TMDB_KEY = '7f41925d9303e23359cf5a62ee62de74';
const TMDB     = 'https://api.themoviedb.org/3';
const IMG      = 'https://image.tmdb.org/t/p/w200';
const isLoggedIn = <?= $isLoggedIn ? 'true' : 'false' ?>;

// ── Fetch media info ─────────────────────────────────────────────────────────
async function getFilmInfo(id) {
    const r = await fetch(`${TMDB}/movie/${id}?api_key=${TMDB_KEY}&language=fr-FR`);
    const d = await r.json();
    return {
        title:  d.title || '?',
        poster: d.poster_path ? IMG + d.poster_path : null,
        url:    `/Critiverse/public/notation-film?id=${id}`
    };
}

async function getSerieInfo(id) {
    const r = await fetch(`${TMDB}/tv/${id}?api_key=${TMDB_KEY}&language=fr-FR`);
    const d = await r.json();
    return {
        title:  d.name || '?',
        poster: d.poster_path ? IMG + d.poster_path : null,
        url:    `/Critiverse/public/notation-serie?id=${id}`
    };
}

async function getAnimeInfo(id) {
    const r = await fetch(`https://api.jikan.moe/v4/anime/${id}`);
    const d = await r.json();
    return {
        title:  d.data?.title || '?',
        poster: d.data?.images?.jpg?.image_url || null,
        url:    `/Critiverse/public/notation?id=${id}`
    };
}

// ── Build card HTML ──────────────────────────────────────────────────────────
function buildCard(review, media, tagClass, emoji) {
    const stars   = '★'.repeat(review.score) + '☆'.repeat(5 - review.score);
    const date    = new Date(review.created_at).toLocaleDateString('fr-FR');
    const poster  = media.poster
        ? `<a href="${media.url}"><img src="${media.poster}" alt="${media.title}" loading="lazy"></a>`
        : `<div class="no-poster">${emoji}</div>`;
    const likeActive    = review.user_vote === 'like';
    const dislikeActive = review.user_vote === 'dislike';
    return `
    <div class="critique-card" data-review-id="${review.id}">
        ${poster}
        <div class="critique-body">
            <div class="critique-title">
                <a href="${media.url}" style="text-decoration:none;color:inherit;">${media.title}</a>
            </div>
            <div class="critique-stars">${stars} <span style="color:#555;font-size:13px;">${review.score}/5</span></div>
            <div class="critique-meta">👤 <strong>${review.username || 'Anonyme'}</strong> — Le ${date}</div>
            <div class="critique-text">${review.comment}</div>
            <div class="vote-row">
                <button type="button" class="vote-btn" data-vote="like" onclick="vote(${review.id},'like',this)"
                    style="${likeActive ? 'background:#e8f0fe;border-color:#2f6df6;color:#2f6df6;' : ''}">
                    👍 <span class="like-count">${review.likes}</span>
                </button>
                <button type="button" class="vote-btn" data-vote="dislike" onclick="vote(${review.id},'dislike',this)"
                    style="${dislikeActive ? 'background:#fce8e8;border-color:#e53935;color:#e53935;' : ''}">
                    👎 <span class="dislike-count">${review.dislikes}</span>
                </button>
            </div>
        </div>
    </div>`;
}

// ── Load a section ───────────────────────────────────────────────────────────
async function loadSection(type, containerId, getInfo, tagClass, emoji) {
    const container = document.getElementById(containerId);
    try {
        const res  = await fetch(`/Critiverse/public/api/top-reviews.php?type=${type}&limit=10`);
        const data = await res.json();

        if (!data.success || data.reviews.length === 0) {
            container.innerHTML = '<p class="empty-msg">Aucun avis publié pour le moment.</p>';
            return;
        }

        // Fetch media info (sequential for Jikan to respect rate limit)
        const cards = [];
        for (const review of data.reviews) {
            try {
                const media = await getInfo(review.media_id);
                cards.push(buildCard(review, media, tagClass, emoji));
            } catch {
                // ignore if media fetch fails
            }
            if (type === 'anime') await new Promise(r => setTimeout(r, 350));
        }

        container.innerHTML = cards.join('') || '<p class="empty-msg">Aucun avis publié pour le moment.</p>';
    } catch (err) {
        container.innerHTML = '<p class="empty-msg">Erreur lors du chargement.</p>';
        console.error(err);
    }
}

// ── Vote ─────────────────────────────────────────────────────────────────────
async function vote(reviewId, type, btn) {
    if (!isLoggedIn) { window.location.href = '/Critiverse/public/login'; return; }
    try {
        const res  = await fetch('/Critiverse/public/api/votes.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ review_id: reviewId, vote: type })
        });
        const data = await res.json();
        if (!data.success) return;
        const card       = btn.closest('.critique-card');
        const likeBtn    = card.querySelector('[data-vote="like"]');
        const dislikeBtn = card.querySelector('[data-vote="dislike"]');
        likeBtn.querySelector('.like-count').textContent       = data.likes;
        dislikeBtn.querySelector('.dislike-count').textContent = data.dislikes;
        [likeBtn, dislikeBtn].forEach(b => {
            b.style.background   = '#f5f5f5';
            b.style.borderColor  = '#ddd';
            b.style.color        = '#555';
        });
        if (data.user_vote === 'like') {
            likeBtn.style.background  = '#e8f0fe';
            likeBtn.style.borderColor = '#2f6df6';
            likeBtn.style.color       = '#2f6df6';
        } else if (data.user_vote === 'dislike') {
            dislikeBtn.style.background  = '#fce8e8';
            dislikeBtn.style.borderColor = '#e53935';
            dislikeBtn.style.color       = '#e53935';
        }
    } catch (err) { console.error('Erreur vote:', err); }
}

// ── Lancement ────────────────────────────────────────────────────────────────
loadSection('film',  'list-film',  getFilmInfo,  'tag-film',  '🎬');
loadSection('serie', 'list-serie', getSerieInfo, 'tag-serie', '📺');
loadSection('anime', 'list-anime', getAnimeInfo, 'tag-anime', '⚔️');
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
