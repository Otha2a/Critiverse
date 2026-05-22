/**
 * critiverse.js — Script partagé pour toutes les pages HTML
 * Gère : auth header, commentaires BDD, likes/dislikes, page critiques
 */

const PHP_BASE = 'http://localhost/Critiverse/public';
const CRIT_API = PHP_BASE + '/api';
const TMDB_KEY = '7f41925d9303e23359cf5a62ee62de74';
const TMDB     = 'https://api.themoviedb.org/3';
const IMG      = 'https://image.tmdb.org/t/p/w200';

let CRIT_SESSION = { logged_in: false, username: null, user_id: null };

// ─── Détecter le type de page ────────────────────────────────────────────────
function detectPageType(path) {
    if (path.includes('notation-film'))  { return 'film'; }
    if (path.includes('notation-serie')) { return 'serie'; }
    if (path.includes('notation'))       { return 'anime'; }
    if (path.includes('critiques'))      { return 'critiques'; }
    return 'other';
}
const PAGE_TYPE = detectPageType(location.pathname);

// ─── Initialisation ──────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', async function () {
    CRIT_SESSION = await fetchSession();
    updateHeader(CRIT_SESSION);

    if (PAGE_TYPE === 'critiques') {
        loadCritiquesPage();
    }
});

// ─── Session ─────────────────────────────────────────────────────────────────
async function fetchSession() {
    try {
        const res = await fetch(`${CRIT_API}/session.php`);
        return await res.json();
    } catch {
        return { logged_in: false, username: null, user_id: null };
    }
}

// ─── Header ──────────────────────────────────────────────────────────────────
function updateHeader(session) {
    const searchDiv = document.querySelector('.search');
    if (!searchDiv) { return; }

    if (session.logged_in) {
        searchDiv.querySelectorAll('button').forEach(btn => {
            const t = btn.textContent.trim();
            if (t === 'Se connecter' || t === "S'inscrire") {
                btn.style.display = 'none';
            }
        });
        const dropdown = searchDiv.querySelector('.dropdown');
        if (dropdown) { dropdown.style.display = 'none'; }

        const span = document.createElement('span');
        span.style.cssText = 'font-weight:bold;padding:8px 12px;font-size:14px;';
        span.textContent = '👤 ' + session.username;

        const logoutBtn = document.createElement('button');
        logoutBtn.type = 'button';
        logoutBtn.textContent = 'Déconnexion';
        logoutBtn.onclick = () => { location.href = `${PHP_BASE}/logout`; };

        searchDiv.appendChild(span);
        searchDiv.appendChild(logoutBtn);
    } else {
        const redirect = encodeURIComponent(location.href);
        searchDiv.querySelectorAll('button').forEach(btn => {
            const t = btn.textContent.trim();
            if (t === 'Se connecter') {
                btn.onclick = () => { location.href = `${PHP_BASE}/login?redirect=${redirect}`; };
            } else if (t === "S'inscrire") {
                btn.onclick = () => { location.href = `${PHP_BASE}/register?redirect=${redirect}`; };
            }
        });
        const openLogin  = document.getElementById('open-login');
        const openSignup = document.getElementById('open-signup');
        if (openLogin)  { openLogin.href  = `${PHP_BASE}/login?redirect=${redirect}`; }
        if (openSignup) { openSignup.href = `${PHP_BASE}/register?redirect=${redirect}`; }
    }
}

// ─── Commentaires (pages notation) ───────────────────────────────────────────
async function critvLoadReviews(mediaType, mediaId) {
    const list = document.getElementById('reviews-list');
    if (!list || !mediaId) { return; }

    try {
        const res  = await fetch(`${CRIT_API}/reviews.php?type=${mediaType}&id=${mediaId}`);
        const data = await res.json();

        if (!data.success || data.reviews.length === 0) {
            list.innerHTML = '<p style="color:#999;">Aucun avis pour le moment. Soyez le premier !</p>';
            return;
        }

        list.innerHTML = data.reviews.map(r => buildReviewCard(r)).join('');
    } catch (err) {
        console.error('Erreur chargement avis:', err);
    }
}

function buildReviewCard(r) {
    const stars        = '★'.repeat(r.score) + '☆'.repeat(5 - r.score);
    const date         = new Date(r.created_at).toLocaleDateString('fr-FR');
    const likeStyle    = r.user_vote === 'like'    ? 'background:#e8f0fe;border-color:#2f6df6;color:#2f6df6;' : '';
    const dislikeStyle = r.user_vote === 'dislike' ? 'background:#fce8e8;border-color:#e53935;color:#e53935;' : '';

    return `
    <div class="review-card" data-review-id="${r.id}">
        <div class="review-header">
            <span class="stars-display">${stars}</span>
            <span class="review-date">Le ${date}</span>
        </div>
        <p style="font-weight:bold;color:#2f6df6;margin:0 0 6px;">👤 ${r.username || 'Anonyme'}</p>
        <p style="margin:0 0 10px;">${r.comment}</p>
        <div style="display:flex;gap:10px;">
            <button type="button" data-vote="like" onclick="critvVote(${r.id},'like',this)"
                style="padding:5px 14px;border-radius:20px;cursor:pointer;font-size:13px;border:1px solid #ddd;${likeStyle}">
                👍 <span class="like-count">${r.likes}</span>
            </button>
            <button type="button" data-vote="dislike" onclick="critvVote(${r.id},'dislike',this)"
                style="padding:5px 14px;border-radius:20px;cursor:pointer;font-size:13px;border:1px solid #ddd;${dislikeStyle}">
                👎 <span class="dislike-count">${r.dislikes}</span>
            </button>
        </div>
    </div>`;
}

async function critvPublishReview(mediaType, mediaId) {
    if (!CRIT_SESSION.logged_in) {
        location.href = `${PHP_BASE}/login?redirect=${encodeURIComponent(location.href)}`;
        return;
    }
    const scoreEl   = document.querySelector('input[name="star"]:checked');
    const commentEl = document.getElementById('comment-text');
    if (!scoreEl)                { return alert("N'oubliez pas de mettre des étoiles !"); }
    if (!commentEl.value.trim()) { return alert('Laissez un petit commentaire.'); }

    try {
        const res  = await fetch(`${CRIT_API}/reviews.php`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                type:    mediaType,
                id:      Number.parseInt(mediaId, 10),
                score:   Number.parseInt(scoreEl.value, 10),
                comment: commentEl.value,
            }),
        });
        const data = await res.json();
        if (data.success) {
            commentEl.value = '';
            document.querySelectorAll('input[name="star"]').forEach(r => { r.checked = false; });
            document.getElementById('rating-label').innerText = 'Sélectionnez une note';
            alert('Merci ! Votre avis a été publié.');
            critvLoadReviews(mediaType, mediaId);
        } else {
            alert('Erreur : ' + (data.error || 'impossible de publier.'));
        }
    } catch {
        alert('Erreur de connexion au serveur.');
    }
}

// ─── Votes ────────────────────────────────────────────────────────────────────
async function critvVote(reviewId, type, btn) {
    if (!CRIT_SESSION.logged_in) {
        location.href = `${PHP_BASE}/login?redirect=${encodeURIComponent(location.href)}`;
        return;
    }
    try {
        const res  = await fetch(`${CRIT_API}/votes.php`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ review_id: reviewId, vote: type }),
        });
        const data = await res.json();
        if (!data.success) { return; }

        const card       = btn.closest('[data-review-id]');
        const likeBtn    = card.querySelector('[data-vote="like"]');
        const dislikeBtn = card.querySelector('[data-vote="dislike"]');

        likeBtn.querySelector('.like-count').textContent       = data.likes;
        dislikeBtn.querySelector('.dislike-count').textContent = data.dislikes;

        [likeBtn, dislikeBtn].forEach(b => {
            b.style.background  = '#f5f5f5';
            b.style.borderColor = '#ddd';
            b.style.color       = '#555';
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

// ─── Surcharge sur pages notation HTML ───────────────────────────────────────
if (PAGE_TYPE === 'anime' || PAGE_TYPE === 'film' || PAGE_TYPE === 'serie') {
    const _mediaId = new URLSearchParams(location.search).get('id');

    globalThis.showStoredReviews = function () { critvLoadReviews(PAGE_TYPE, _mediaId); };
    globalThis.publishReview     = function () { critvPublishReview(PAGE_TYPE, _mediaId); };

    const _obs = new MutationObserver(() => {
        const rs = document.querySelector('.rating-section');
        if (!rs || rs.dataset.critvChecked) { return; }
        rs.dataset.critvChecked = '1';
        if (!CRIT_SESSION.logged_in) {
            const redirect = encodeURIComponent(location.href);
            rs.innerHTML = `
                <h2>Donnez votre avis</h2>
                <p style="color:#555;margin:20px 0;">Connectez-vous pour laisser un avis.</p>
                <a href="${PHP_BASE}/login?redirect=${redirect}"
                   style="background:#2f6df6;color:white;padding:12px 24px;border-radius:8px;
                          text-decoration:none;font-weight:bold;display:inline-block;">
                    Se connecter
                </a><br>
                <a href="${PHP_BASE}/register?redirect=${redirect}"
                   style="color:#2f6df6;font-size:14px;margin-top:12px;display:inline-block;">
                    Créer un compte
                </a>`;
        }
    });
    _obs.observe(document.body, { childList: true, subtree: true });
}

// ─── Page Critiques ───────────────────────────────────────────────────────────
async function getFilmInfo(id) {
    const d = await (await fetch(`${TMDB}/movie/${id}?api_key=${TMDB_KEY}&language=fr-FR`)).json();
    return {
        title:  d.title || '?',
        poster: d.poster_path ? IMG + d.poster_path : null,
        url:    `http://localhost/Critiverse/archives/pages/notation-film.html?id=${id}`,
    };
}

async function getSerieInfo(id) {
    const d = await (await fetch(`${TMDB}/tv/${id}?api_key=${TMDB_KEY}&language=fr-FR`)).json();
    return {
        title:  d.name || '?',
        poster: d.poster_path ? IMG + d.poster_path : null,
        url:    `http://localhost/Critiverse/archives/pages/notation-serie.html?id=${id}`,
    };
}

async function getAnimeInfo(id) {
    const d = await (await fetch(`https://api.jikan.moe/v4/anime/${id}`)).json();
    return {
        title:  d.data?.title || '?',
        poster: d.data?.images?.jpg?.image_url || null,
        url:    `http://localhost/Critiverse/archives/pages/notation.html?id=${id}`,
    };
}

function buildCritiqueCard(r, media, emoji) {
    const stars        = '★'.repeat(r.score) + '☆'.repeat(5 - r.score);
    const date         = new Date(r.created_at).toLocaleDateString('fr-FR');
    const likeStyle    = r.user_vote === 'like'    ? 'background:#e8f0fe;border-color:#2f6df6;color:#2f6df6;' : '';
    const dislikeStyle = r.user_vote === 'dislike' ? 'background:#fce8e8;border-color:#e53935;color:#e53935;' : '';
    const poster       = media.poster
        ? `<a href="${media.url}"><img src="${media.poster}" style="width:80px;height:120px;object-fit:cover;border-radius:8px;flex-shrink:0;" alt="${media.title}" loading="lazy"></a>`
        : `<div style="width:80px;height:120px;border-radius:8px;background:#e0e0e0;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">${emoji}</div>`;

    return `
    <div data-review-id="${r.id}" style="display:flex;gap:14px;background:white;padding:16px;border-radius:10px;margin-bottom:12px;box-shadow:0 2px 8px rgba(0,0,0,.06);">
        ${poster}
        <div style="flex:1;">
            <a href="${media.url}" style="font-weight:bold;font-size:15px;color:#111;text-decoration:none;">${media.title}</a>
            <div style="color:#ffca08;font-size:16px;margin:4px 0;">${stars} <span style="color:#555;font-size:12px;">${r.score}/5</span></div>
            <div style="font-size:12px;color:#888;margin-bottom:6px;">👤 <strong>${r.username || 'Anonyme'}</strong> — Le ${date}</div>
            <div style="font-size:13px;color:#333;margin-bottom:10px;">${r.comment}</div>
            <div style="display:flex;gap:8px;">
                <button type="button" data-vote="like" onclick="critvVote(${r.id},'like',this)"
                    style="padding:4px 12px;border-radius:20px;cursor:pointer;font-size:12px;border:1px solid #ddd;${likeStyle}">
                    👍 <span class="like-count">${r.likes}</span>
                </button>
                <button type="button" data-vote="dislike" onclick="critvVote(${r.id},'dislike',this)"
                    style="padding:4px 12px;border-radius:20px;cursor:pointer;font-size:12px;border:1px solid #ddd;${dislikeStyle}">
                    👎 <span class="dislike-count">${r.dislikes}</span>
                </button>
            </div>
        </div>
    </div>`;
}

async function loadCritiqueSection(type, containerId, getInfo, emoji) {
    const container = document.getElementById(containerId);
    if (!container) { return; }
    try {
        const data = await (await fetch(`${CRIT_API}/top-reviews.php?type=${type}&limit=10`)).json();
        if (!data.success || data.reviews.length === 0) {
            container.innerHTML = '<p style="color:#999;font-style:italic;padding:10px 0;">Aucun avis pour le moment.</p>';
            return;
        }
        const cards = [];
        for (const r of data.reviews) {
            try { cards.push(buildCritiqueCard(r, await getInfo(r.media_id), emoji)); } catch { /* ignore */ }
            if (type === 'anime') { await new Promise(res => setTimeout(res, 350)); }
        }
        container.innerHTML = cards.join('') || '<p style="color:#999;font-style:italic;">Aucun avis pour le moment.</p>';
    } catch {
        container.innerHTML = '<p style="color:#999;">Erreur de chargement.</p>';
    }
}

function loadCritiquesPage() {
    loadCritiqueSection('film',  'critiques-films',  getFilmInfo,  '🎬');
    loadCritiqueSection('serie', 'critiques-series', getSerieInfo, '📺');
    loadCritiqueSection('anime', 'critiques-animes', getAnimeInfo, '⚔️');
}
