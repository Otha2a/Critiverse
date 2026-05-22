<?php
$activePage        = 'animes';
$css               = 'animes';
$searchPlaceholder = 'Rechercher un anime...';
$extraCss = 'main{display:block}.details-container{display:flex;flex-wrap:wrap;gap:40px;max-width:1200px;margin:auto;padding:40px}.anime-info{flex:1 1 580px;min-width:320px}.anime-top{display:flex;flex-wrap:wrap;gap:30px;align-items:flex-start}.anime-cover{flex:0 0 280px}.anime-cover img{width:100%;border-radius:12px;box-shadow:0 10px 20px rgba(0,0,0,.3)}.anime-summary{flex:1;min-width:260px}.anime-info h1{margin-top:0;color:#333}.rating-section{flex:1 1 320px;min-width:320px;background:#fff;padding:30px;border-radius:15px;box-shadow:0 4px 15px rgba(0,0,0,.1);height:fit-content;margin-left:auto}.star-rating{display:flex;flex-direction:row-reverse;justify-content:flex-end;gap:10px;margin:15px 0}.star-rating input{display:none}.star-rating label{font-size:45px;color:#ddd;cursor:pointer;transition:.2s}.star-rating label:hover,.star-rating label:hover~label,.star-rating input:checked~label{color:#ffca08}.synopsis-box{margin:20px 0;line-height:1.7;background:#f9f9f9;padding:20px;border-radius:10px;border-left:4px solid #2f6df6;font-size:15px;color:#444}textarea{width:100%;height:120px;padding:15px;border:1px solid #ddd;border-radius:8px;resize:none;font-family:inherit;margin-bottom:15px;box-sizing:border-box}#submit-rating{background:#2f6df6;color:white;border:none;padding:15px;border-radius:8px;cursor:pointer;width:100%;font-weight:bold;font-size:16px;transition:.3s}#submit-rating:hover{background:#1a52d5}.reviews-area{max-width:1200px;margin:40px auto;padding:0 40px}.review-card{background:white;padding:20px;border-radius:10px;margin-bottom:20px;box-shadow:0 2px 8px rgba(0,0,0,.05)}.review-header{display:flex;justify-content:space-between;margin-bottom:10px}.stars-display{color:#ffca08;font-weight:bold}.review-date{color:#888;font-size:.9em}.episodes-area{max-width:1200px;margin:0 auto;padding:0 40px 40px}.episodes-container{background:white;border-radius:12px;box-shadow:0 2px 12px rgba(0,0,0,.08);overflow:hidden}.episode-row{display:flex;align-items:center;gap:16px;padding:14px 18px;border-bottom:1px solid #f0f0f0;cursor:pointer;transition:background .15s}.episode-row:last-child{border-bottom:none}.episode-row:hover{background:#f7f9ff}.episode-num{flex:0 0 40px;font-weight:bold;font-size:15px;color:#2f6df6;text-align:center}.episode-body{flex:1}.episode-title{font-weight:bold;font-size:14px;margin-bottom:3px}.episode-meta{font-size:12px;color:#888;display:flex;gap:10px;flex-wrap:wrap}.badge{padding:2px 8px;border-radius:10px;font-size:11px;font-weight:bold}.badge-filler{background:#fff3cd;color:#856404}.badge-recap{background:#cff4fc;color:#055160}#load-more-btn{display:block;width:100%;padding:14px;background:#2f6df6;color:white;border:none;font-size:15px;font-weight:bold;cursor:pointer;border-radius:0 0 12px 12px;transition:background .2s}#load-more-btn:hover{background:#1a52d5}';
require_once __DIR__ . '/../layouts/header.php';
?>
    <nav class="navbar">
        <ul>
            <li><a href="/Critiverse/public/animes?genre=1">Action</a></li>
            <li><a href="/Critiverse/public/animes?genre=22">Romance</a></li>
            <li><a href="/Critiverse/public/animes?genre=10">Fantasy</a></li>
            <li><a href="/Critiverse/public/animes?genre=24">Science-Fiction</a></li>
            <li><a href="/Critiverse/public/animes?genre=62">Isekai</a></li>
            <li><a href="/Critiverse/public/animes?genre=30">Sports</a></li>
            <li><a href="/Critiverse/public/animes?genre=14">Horreur</a></li>
            <li><a href="/Critiverse/public/animes?genre=2">Aventure</a></li>
        </ul>
    </nav>

    <main id="content">
        <div id="anime-details-target" class="details-container">
            <p>Chargement de l'animé...</p>
        </div>

        <section class="episodes-area" id="episodes-area" style="display:none;">
            <hr>
            <h2>Liste des épisodes</h2>
            <div class="episodes-container">
                <div id="episodes-list"></div>
                <button id="load-more-btn" type="button" style="display:none;" onclick="loadEpisodes()">Voir plus d'épisodes</button>
            </div>
        </section>

        <section class="reviews-area">
            <hr>
            <h2>Avis des utilisateurs</h2>
            <div id="reviews-list">
                <p style="color:#999;">Soyez le premier à donner votre avis sur cet animé !</p>
            </div>
        </section>
    </main>

    <script>
        const isLoggedIn = <?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>;

        const params  = new URLSearchParams(window.location.search);
        const animeId = params.get('id');
        let selectedScore = 0;

        function doSearch() {
            const val = document.getElementById('searchInput').value;
            if (val.length < 3) return alert("3 lettres minimum");
            window.location.href = `/Critiverse/public/animes?q=${encodeURIComponent(val)}`;
        }

        document.getElementById('searchInput').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') doSearch();
        });

        function cleanSynopsis(text) {
            if (!text) return text;
            return text.replace(/\s*\[Written by MAL Rewrite\]\s*$/i, '').trim();
        }

        async function fetchFrenchSynopsis(id, fallback) {
            try {
                const res = await fetch(`https://api.jikan.moe/v4/anime/${id}/translations`);
                if (!res.ok) return fallback;
                const json = await res.json();
                if (!json.data || !Array.isArray(json.data)) return fallback;
                const fr = json.data.find(item => item.language === 'fr' || item.language === 'français');
                if (fr && fr.synopsis) return cleanSynopsis(fr.synopsis);
            } catch (err) { /* ignore */ }
            return fallback;
        }

        async function loadAnimeData() {
            if (!animeId) {
                document.getElementById('anime-details-target').innerHTML = "<h2>Erreur : Aucun animé sélectionné.</h2>";
                return;
            }
            try {
                const res   = await fetch(`https://api.jikan.moe/v4/anime/${animeId}`);
                const json  = await res.json();
                const anime = json.data;
                const rawSynopsis  = anime.synopsis || "Aucun résumé disponible.";
                const synopsisText = await fetchFrenchSynopsis(animeId, cleanSynopsis(rawSynopsis));

                document.title = `${anime.title} - Critiverse`;

                document.getElementById('anime-details-target').innerHTML = `
                    <div class="anime-info">
                        <div class="anime-top">
                            <div class="anime-cover">
                                <img src="${anime.images.jpg.large_image_url}" alt="${anime.title}">
                            </div>
                            <div class="anime-summary">
                                <h1>${anime.title}</h1>
                                <p><strong>Note MyAnimeList :</strong> ⭐ ${anime.score || 'N/A'}/10</p>
                                <div class="synopsis-box"><strong>Résumé :</strong><br>${synopsisText}</div>
                            </div>
                        </div>
                    </div>
                    ${isLoggedIn ? `
                    <div class="rating-section">
                        <h2>Donnez votre avis</h2>
                        <div class="star-rating">
                            <input type="radio" name="star" id="star5" value="5"><label for="star5">★</label>
                            <input type="radio" name="star" id="star4" value="4"><label for="star4">★</label>
                            <input type="radio" name="star" id="star3" value="3"><label for="star3">★</label>
                            <input type="radio" name="star" id="star2" value="2"><label for="star2">★</label>
                            <input type="radio" name="star" id="star1" value="1"><label for="star1">★</label>
                        </div>
                        <p id="rating-label">Sélectionnez une note</p>
                        <textarea id="comment-text" placeholder="Alors, chef-d'œuvre ou déception ?"></textarea>
                        <button id="submit-rating" type="button" onclick="publishReview()">Publier mon avis</button>
                    </div>` : `
                    <div class="rating-section" style="text-align:center;padding:40px 30px;">
                        <p style="color:#555;margin-bottom:20px;">Connectez-vous pour laisser un avis.</p>
                        <a href="/Critiverse/public/login" style="background:#2f6df6;color:white;padding:12px 24px;border-radius:8px;text-decoration:none;font-weight:bold;display:inline-block;">Se connecter</a>
                        <br><a href="/Critiverse/public/register" style="color:#2f6df6;font-size:14px;margin-top:12px;display:inline-block;">Créer un compte</a>
                    </div>`}`;

                document.querySelectorAll('input[name="star"]').forEach(radio => {
                    radio.addEventListener('change', e => {
                        selectedScore = e.target.value;
                        document.getElementById('rating-label').innerText = `Ma note : ${selectedScore}/5`;
                    });
                });

                showStoredReviews();
                loadEpisodes();
            } catch (err) {
                document.getElementById('anime-details-target').innerHTML = "<p>Erreur lors du chargement.</p>";
            }
        }

        let epPage = 1, epHasMore = false, epLoading = false;

        async function loadEpisodes() {
            if (epLoading) return;
            epLoading = true;
            const btn = document.getElementById('load-more-btn');
            btn.textContent = 'Chargement...';
            try {
                if (epPage > 1) await new Promise(r => setTimeout(r, 400));
                const res  = await fetch(`https://api.jikan.moe/v4/anime/${animeId}/episodes?page=${epPage}`);
                const data = await res.json();
                const episodes = data.data || [];
                epHasMore = data.pagination?.has_next_page || false;

                if (episodes.length > 0) {
                    document.getElementById('episodes-area').style.display = 'block';
                    const list = document.getElementById('episodes-list');
                    episodes.forEach(ep => {
                        const titre  = ep.title || ep.title_romanji || `Épisode ${ep.mal_id}`;
                        const date   = ep.aired ? new Date(ep.aired).toLocaleDateString('fr-FR') : 'Date inconnue';
                        const score  = ep.score ? `⭐ ${ep.score}` : '';
                        const filler = ep.filler ? '<span class="badge badge-filler">Filler</span>' : '';
                        const recap  = ep.recap  ? '<span class="badge badge-recap">Récap</span>'  : '';
                        const row = document.createElement('div');
                        row.className = 'episode-row';
                        row.innerHTML = `
                            <div class="episode-num">${ep.mal_id}</div>
                            <div class="episode-body">
                                <div class="episode-title">${titre}</div>
                                <div class="episode-meta">
                                    <span>${date}</span>
                                    ${score ? `<span>${score}</span>` : ''}
                                    ${filler}${recap}
                                </div>
                            </div>`;
                        list.appendChild(row);
                    });
                    epPage++;
                }
                btn.style.display = epHasMore ? 'block' : 'none';
                btn.textContent = "Voir plus d'épisodes";
            } catch (err) {
                btn.textContent = 'Erreur, réessayer';
            } finally {
                epLoading = false;
            }
        }

        async function publishReview() {
            const comment = document.getElementById('comment-text').value;
            if (selectedScore === 0) return alert("N'oubliez pas de mettre des étoiles !");
            if (comment.trim() === "") return alert("Laissez un petit commentaire.");
            try {
                const res  = await fetch('/Critiverse/public/api/reviews.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ type: 'anime', id: parseInt(animeId), score: parseInt(selectedScore), comment })
                });
                const data = await res.json();
                if (data.success) {
                    document.getElementById('comment-text').value = "";
                    selectedScore = 0;
                    document.querySelectorAll('input[name="star"]').forEach(r => r.checked = false);
                    document.getElementById('rating-label').innerText = "Sélectionnez une note";
                    alert("Merci ! Votre avis a été publié.");
                    showStoredReviews();
                } else {
                    alert("Erreur : " + (data.error || "impossible de publier."));
                }
            } catch (err) {
                alert("Erreur de connexion au serveur.");
            }
        }

        async function showStoredReviews() {
            const list = document.getElementById('reviews-list');
            try {
                const res  = await fetch(`/Critiverse/public/api/reviews.php?type=anime&id=${animeId}`);
                const data = await res.json();
                if (!data.success || data.reviews.length === 0) {
                    list.innerHTML = '<p style="color:#999;">Soyez le premier à donner votre avis sur cet animé !</p>';
                    return;
                }
                list.innerHTML = data.reviews.map(r => `
                    <div class="review-card" data-review-id="${r.id}">
                        <div class="review-header">
                            <span class="stars-display">${"★".repeat(r.score)}${"☆".repeat(5 - r.score)}</span>
                            <span class="review-date">Le ${new Date(r.created_at).toLocaleDateString('fr-FR')}</span>
                        </div>
                        <p style="font-weight:bold;color:#2f6df6;margin:0 0 6px;">👤 ${r.username || 'Anonyme'}</p>
                        <p style="margin:0 0 10px;">${r.comment}</p>
                        <div style="display:flex;gap:10px;">
                            <button type="button" data-vote="like" onclick="vote(${r.id},'like',this)"
                                style="background:${r.user_vote==='like'?'#e8f0fe':'#f5f5f5'};border:1px solid ${r.user_vote==='like'?'#2f6df6':'#ddd'};color:${r.user_vote==='like'?'#2f6df6':'#555'};padding:5px 14px;border-radius:20px;cursor:pointer;font-size:13px;">
                                👍 <span class="like-count">${r.likes}</span>
                            </button>
                            <button type="button" data-vote="dislike" onclick="vote(${r.id},'dislike',this)"
                                style="background:${r.user_vote==='dislike'?'#fce8e8':'#f5f5f5'};border:1px solid ${r.user_vote==='dislike'?'#e53935':'#ddd'};color:${r.user_vote==='dislike'?'#e53935':'#555'};padding:5px 14px;border-radius:20px;cursor:pointer;font-size:13px;">
                                👎 <span class="dislike-count">${r.dislikes}</span>
                            </button>
                        </div>
                    </div>`).join('');
            } catch (err) {
                console.error("Erreur chargement avis:", err);
            }
        }

        loadAnimeData();

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
                const card       = btn.closest('.review-card');
                const likeBtn    = card.querySelector('[data-vote="like"]');
                const dislikeBtn = card.querySelector('[data-vote="dislike"]');
                likeBtn.querySelector('.like-count').textContent    = data.likes;
                dislikeBtn.querySelector('.dislike-count').textContent = data.dislikes;
                const active   = { bg: '', border: '', color: '' };
                const inactive = { bg: '#f5f5f5', border: '#ddd', color: '#555' };
                [likeBtn, dislikeBtn].forEach(b => {
                    b.style.background = inactive.bg;
                    b.style.border     = `1px solid ${inactive.border}`;
                    b.style.color      = inactive.color;
                });
                if (data.user_vote === 'like') {
                    likeBtn.style.background = '#e8f0fe';
                    likeBtn.style.border     = '1px solid #2f6df6';
                    likeBtn.style.color      = '#2f6df6';
                } else if (data.user_vote === 'dislike') {
                    dislikeBtn.style.background = '#fce8e8';
                    dislikeBtn.style.border     = '1px solid #e53935';
                    dislikeBtn.style.color      = '#e53935';
                }
            } catch (err) { console.error('Erreur vote:', err); }
        }
    </script>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
