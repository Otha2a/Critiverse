<?php
$activePage        = 'series';
$css               = 'animes';
$searchPlaceholder = 'Rechercher une s&eacute;rie...';
$extraCss = 'main{display:block}.details-container{display:flex;flex-wrap:wrap;gap:40px;max-width:1200px;margin:auto;padding:40px}.serie-info{flex:1 1 580px;min-width:320px}.serie-top{display:flex;flex-wrap:wrap;gap:30px;align-items:flex-start}.serie-cover{flex:0 0 280px}.serie-cover img{width:100%;border-radius:12px;box-shadow:0 10px 20px rgba(0,0,0,.3)}.serie-summary{flex:1;min-width:260px}.serie-info h1{margin-top:0;color:#333}.rating-section{flex:1 1 320px;min-width:320px;background:#fff;padding:30px;border-radius:15px;box-shadow:0 4px 15px rgba(0,0,0,.1);height:fit-content;margin-left:auto}.star-rating{display:flex;flex-direction:row-reverse;justify-content:flex-end;gap:10px;margin:15px 0}.star-rating input{display:none}.star-rating label{font-size:45px;color:#ddd;cursor:pointer;transition:.2s}.star-rating label:hover,.star-rating label:hover~label,.star-rating input:checked~label{color:#ffca08}.synopsis-box{margin:20px 0;line-height:1.7;background:#f9f9f9;padding:20px;border-radius:10px;border-left:4px solid #2f6df6;font-size:15px;color:#444}textarea{width:100%;height:120px;padding:15px;border:1px solid #ddd;border-radius:8px;resize:none;font-family:inherit;margin-bottom:15px;box-sizing:border-box}#submit-rating{background:#2f6df6;color:white;border:none;padding:15px;border-radius:8px;cursor:pointer;width:100%;font-weight:bold;font-size:16px;transition:.3s}#submit-rating:hover{background:#1a52d5}.reviews-area{max-width:1200px;margin:40px auto;padding:0 40px}.review-card{background:white;padding:20px;border-radius:10px;margin-bottom:20px;box-shadow:0 2px 8px rgba(0,0,0,.05)}.review-header{display:flex;justify-content:space-between;margin-bottom:10px}.stars-display{color:#ffca08;font-weight:bold}.review-date{color:#888;font-size:.9em}.seasons-area{max-width:1200px;margin:0 auto;padding:0 40px 40px}.seasons-list{display:flex;flex-wrap:wrap;gap:16px}.season-card{width:140px;cursor:pointer;border-radius:10px;overflow:hidden;background:white;box-shadow:0 2px 8px rgba(0,0,0,.1);transition:transform .2s,box-shadow .2s;text-align:center}.season-card:hover{transform:scale(1.04)}.season-card.active{outline:3px solid #2f6df6}.season-card img{width:100%;height:200px;object-fit:cover;display:block}.season-label{padding:8px 6px;font-size:13px;font-weight:bold}.season-ep-count{padding:0 6px 8px;font-size:12px;color:#777}.episodes-container{margin-top:24px;background:white;border-radius:12px;box-shadow:0 2px 12px rgba(0,0,0,.08);overflow:hidden}.episode-row{display:flex;gap:16px;padding:14px 18px;border-bottom:1px solid #f0f0f0;align-items:flex-start;cursor:pointer;transition:background .15s}.episode-row:last-child{border-bottom:none}.episode-row:hover{background:#f7f9ff}.episode-thumb{flex:0 0 120px;height:70px;border-radius:6px;object-fit:cover}.episode-thumb-placeholder{flex:0 0 120px;height:70px;border-radius:6px;background:#e0e0e0;display:flex;align-items:center;justify-content:center;color:#aaa;font-size:12px}.episode-body{flex:1}.episode-title{font-weight:bold;font-size:14px;margin-bottom:4px}.episode-meta{font-size:12px;color:#888;margin-bottom:6px}.episode-synopsis{font-size:13px;color:#555;line-height:1.5;display:none}.episode-row.open .episode-synopsis{display:block}';
require_once __DIR__ . '/../layouts/header.php';
?>
    <nav class="navbar">
        <ul>
            <li><a href="/Critiverse/public/series?genre=10759">Action</a></li>
            <li><a href="/Critiverse/public/series?genre=35">Com&eacute;die</a></li>
            <li><a href="/Critiverse/public/series?genre=18">Drame</a></li>
            <li><a href="/Critiverse/public/series?genre=27">Horreur</a></li>
            <li><a href="/Critiverse/public/series?genre=10749">Romance</a></li>
            <li><a href="/Critiverse/public/series?genre=10765">Science-Fiction</a></li>
            <li><a href="/Critiverse/public/series?genre=9648">Myst&egrave;re</a></li>
            <li><a href="/Critiverse/public/series?genre=80">Crime</a></li>
        </ul>
    </nav>

    <main id="content">
        <div id="serie-details-target" class="details-container">
            <p>Chargement de la s&eacute;rie...</p>
        </div>

        <section class="seasons-area" id="seasons-area" style="display:none;">
            <hr>
            <h2>Saisons &amp; &Eacute;pisodes</h2>
            <div class="seasons-list" id="seasons-list"></div>
            <div class="episodes-container" id="episodes-container" style="display:none;">
                <div id="episodes-loading">Chargement des &eacute;pisodes...</div>
                <div id="episodes-list"></div>
            </div>
        </section>

        <section class="reviews-area">
            <hr>
            <h2>Avis des utilisateurs</h2>
            <div id="reviews-list">
                <p style="color:#999;">Soyez le premier &agrave; donner votre avis sur cette s&eacute;rie !</p>
            </div>
        </section>
    </main>

    <script>
        const API_KEY  = '7f41925d9303e23359cf5a62ee62de74';
        const TMDB_URL = 'https://api.themoviedb.org/3';
        const IMG_URL  = 'https://image.tmdb.org/t/p/w500';

        const isLoggedIn = <?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>;

        const params  = new URLSearchParams(window.location.search);
        const serieId = params.get('id');
        let selectedScore = 0;

        function doSearch() {
            const val = document.getElementById('searchInput').value.trim();
            if (val.length < 2) return alert("2 lettres minimum");
            window.location.href = `/Critiverse/public/series?q=${encodeURIComponent(val)}`;
        }

        document.getElementById('searchInput').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') doSearch();
        });

        async function loadSerieData() {
            if (!serieId) {
                document.getElementById('serie-details-target').innerHTML = "<h2>Erreur : Aucune série sélectionnée.</h2>";
                return;
            }
            try {
                const res   = await fetch(`${TMDB_URL}/tv/${serieId}?api_key=${API_KEY}&language=fr-FR`);
                const serie = await res.json();

                const synopsis = serie.overview || "Aucun résumé disponible.";
                const genres   = serie.genres ? serie.genres.map(g => g.name).join(', ') : 'N/A';
                const year     = serie.first_air_date ? serie.first_air_date.slice(0, 4) : 'N/A';
                const saisons  = serie.number_of_seasons ? `${serie.number_of_seasons} saison(s)` : 'N/A';
                const episodes = serie.number_of_episodes ? `${serie.number_of_episodes} épisode(s)` : 'N/A';
                const poster   = serie.poster_path ? IMG_URL + serie.poster_path : '';

                document.title = `${serie.name} - Critiverse`;

                document.getElementById('serie-details-target').innerHTML = `
                    <div class="serie-info">
                        <div class="serie-top">
                            <div class="serie-cover"><img src="${poster}" alt="${serie.name}"></div>
                            <div class="serie-summary">
                                <h1>${serie.name}</h1>
                                <p><strong>Première diffusion :</strong> ${year}</p>
                                <p><strong>Saisons :</strong> ${saisons}</p>
                                <p><strong>Épisodes :</strong> ${episodes}</p>
                                <p><strong>Genres :</strong> ${genres}</p>
                                <p><strong>Note TMDB :</strong> ⭐ ${serie.vote_average ? serie.vote_average.toFixed(1) : 'N/A'}/10</p>
                                <div class="synopsis-box"><strong>Résumé :</strong><br>${synopsis}</div>
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

                const seasons = (serie.seasons || []).filter(s => s.season_number > 0 || s.poster_path);
                if (seasons.length > 0) renderSeasons(seasons);

            } catch (err) {
                document.getElementById('serie-details-target').innerHTML = "<p>Erreur lors du chargement de la série.</p>";
            }
        }

        function renderSeasons(seasons) {
            document.getElementById('seasons-area').style.display = 'block';
            const list = document.getElementById('seasons-list');
            list.innerHTML = seasons.map(s => {
                const poster = s.poster_path
                    ? `<img src="${IMG_URL}${s.poster_path}" alt="${s.name}">`
                    : `<div style="width:100%;height:200px;background:#ddd;display:flex;align-items:center;justify-content:center;font-size:12px;color:#999;">Pas d'affiche</div>`;
                return `
                    <div class="season-card" onclick="toggleSeason(${s.season_number}, this)" data-season="${s.season_number}">
                        ${poster}
                        <div class="season-label">${s.name}</div>
                        <div class="season-ep-count">${s.episode_count} épisode(s)</div>
                    </div>`;
            }).join('');
        }

        let currentOpenSeason = null;

        async function toggleSeason(seasonNumber, card) {
            const container = document.getElementById('episodes-container');

            if (currentOpenSeason === seasonNumber) {
                container.style.display = 'none';
                card.classList.remove('active');
                currentOpenSeason = null;
                return;
            }

            document.querySelectorAll('.season-card').forEach(c => c.classList.remove('active'));
            card.classList.add('active');
            currentOpenSeason = seasonNumber;

            container.style.display = 'block';
            document.getElementById('episodes-loading').style.display = 'block';
            document.getElementById('episodes-list').innerHTML = '';
            container.scrollIntoView({ behavior: 'smooth', block: 'start' });

            try {
                const res  = await fetch(`${TMDB_URL}/tv/${serieId}/season/${seasonNumber}?api_key=${API_KEY}&language=fr-FR`);
                const data = await res.json();

                document.getElementById('episodes-loading').style.display = 'none';
                document.getElementById('episodes-list').innerHTML = (data.episodes || []).map(ep => {
                    const thumb = ep.still_path
                        ? `<img class="episode-thumb" src="https://image.tmdb.org/t/p/w300${ep.still_path}" alt="ep${ep.episode_number}">`
                        : `<div class="episode-thumb-placeholder">Pas d'image</div>`;
                    const runtime = ep.runtime ? `${ep.runtime} min · ` : '';
                    const date    = ep.air_date ? `Diffusé le ${new Date(ep.air_date).toLocaleDateString('fr-FR')}` : '';
                    const synopsis = ep.overview || 'Aucun résumé disponible.';
                    return `
                        <div class="episode-row" onclick="this.classList.toggle('open')">
                            ${thumb}
                            <div class="episode-body">
                                <div class="episode-title">Épisode ${ep.episode_number} — ${ep.name}</div>
                                <div class="episode-meta">${runtime}${date}</div>
                                <div class="episode-synopsis">${synopsis}</div>
                            </div>
                        </div>`;
                }).join('');
            } catch (err) {
                document.getElementById('episodes-loading').textContent = "Erreur lors du chargement des épisodes.";
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
                    body: JSON.stringify({ type: 'serie', id: parseInt(serieId), score: parseInt(selectedScore), comment })
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
                const res  = await fetch(`/Critiverse/public/api/reviews.php?type=serie&id=${serieId}`);
                const data = await res.json();
                if (!data.success || data.reviews.length === 0) {
                    list.innerHTML = '<p style="color:#999;">Soyez le premier à donner votre avis sur cette série !</p>';
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

        loadSerieData();

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
                likeBtn.querySelector('.like-count').textContent       = data.likes;
                dislikeBtn.querySelector('.dislike-count').textContent = data.dislikes;
                [likeBtn, dislikeBtn].forEach(b => {
                    b.style.background = '#f5f5f5';
                    b.style.border     = '1px solid #ddd';
                    b.style.color      = '#555';
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
