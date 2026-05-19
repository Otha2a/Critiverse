<?php
$activePage        = 'films';
$css               = 'animes';
$searchPlaceholder = 'Rechercher un film...';
$extraCss = 'main{display:block}.details-container{display:flex;flex-wrap:wrap;gap:40px;max-width:1200px;margin:auto;padding:40px}.film-info{flex:1 1 580px;min-width:320px}.film-top{display:flex;flex-wrap:wrap;gap:30px;align-items:flex-start}.film-cover{flex:0 0 280px}.film-cover img{width:100%;border-radius:12px;box-shadow:0 10px 20px rgba(0,0,0,.3)}.film-summary{flex:1;min-width:260px}.film-info h1{margin-top:0;color:#333}.rating-section{flex:1 1 320px;min-width:320px;background:#fff;padding:30px;border-radius:15px;box-shadow:0 4px 15px rgba(0,0,0,.1);height:fit-content;margin-left:auto}.star-rating{display:flex;flex-direction:row-reverse;justify-content:flex-end;gap:10px;margin:15px 0}.star-rating input{display:none}.star-rating label{font-size:45px;color:#ddd;cursor:pointer;transition:.2s}.star-rating label:hover,.star-rating label:hover~label,.star-rating input:checked~label{color:#ffca08}.synopsis-box{margin:20px 0;line-height:1.7;background:#f9f9f9;padding:20px;border-radius:10px;border-left:4px solid #2f6df6;font-size:15px;color:#444}textarea{width:100%;height:120px;padding:15px;border:1px solid #ddd;border-radius:8px;resize:none;font-family:inherit;margin-bottom:15px;box-sizing:border-box}#submit-rating{background:#2f6df6;color:white;border:none;padding:15px;border-radius:8px;cursor:pointer;width:100%;font-weight:bold;font-size:16px;transition:.3s}#submit-rating:hover{background:#1a52d5}.reviews-area{max-width:1200px;margin:40px auto;padding:0 40px}.review-card{background:white;padding:20px;border-radius:10px;margin-bottom:20px;box-shadow:0 2px 8px rgba(0,0,0,.05)}.review-header{display:flex;justify-content:space-between;margin-bottom:10px}.stars-display{color:#ffca08;font-weight:bold}.review-date{color:#888;font-size:.9em}';
require_once __DIR__ . '/../layouts/header.php';
?>
    <nav class="navbar">
        <ul>
            <li><a href="/Critiverse/public/films?genre=28">Action</a></li>
            <li><a href="/Critiverse/public/films?genre=35">Comédie</a></li>
            <li><a href="/Critiverse/public/films?genre=18">Drame</a></li>
            <li><a href="/Critiverse/public/films?genre=27">Horreur</a></li>
            <li><a href="/Critiverse/public/films?genre=10749">Romance</a></li>
            <li><a href="/Critiverse/public/films?genre=878">Science-Fiction</a></li>
            <li><a href="/Critiverse/public/films?genre=53">Thriller</a></li>
            <li><a href="/Critiverse/public/films?genre=12">Aventure</a></li>
        </ul>
    </nav>

    <main id="content">
        <div id="film-details-target" class="details-container">
            <p>Chargement du film...</p>
        </div>
        <section class="reviews-area">
            <hr>
            <h2>Avis des utilisateurs</h2>
            <div id="reviews-list">
                <p style="color:#999;">Soyez le premier à donner votre avis sur ce film !</p>
            </div>
        </section>
    </main>

    <script>
        const API_KEY = '7f41925d9303e23359cf5a62ee62de74';
        const TMDB_URL = 'https://api.themoviedb.org/3';
        const IMG_URL  = 'https://image.tmdb.org/t/p/w500';

        const isLoggedIn = <?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>;

        const params  = new URLSearchParams(window.location.search);
        const movieId = params.get('id');
        let selectedScore = 0;

        function doSearch() {
            const val = document.getElementById('searchInput').value.trim();
            if (val.length < 2) return alert("2 lettres minimum");
            window.location.href = `/Critiverse/public/films?q=${encodeURIComponent(val)}`;
        }

        document.getElementById('searchInput').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') doSearch();
        });

        async function loadFilmData() {
            if (!movieId) {
                document.getElementById('film-details-target').innerHTML = "<h2>Erreur : Aucun film sélectionné.</h2>";
                return;
            }
            try {
                const res  = await fetch(`${TMDB_URL}/movie/${movieId}?api_key=${API_KEY}&language=fr-FR`);
                const film = await res.json();

                const synopsis = film.overview || "Aucun résumé disponible.";
                const genres   = film.genres ? film.genres.map(g => g.name).join(', ') : 'N/A';
                const year     = film.release_date ? film.release_date.slice(0, 4) : 'N/A';
                const duration = film.runtime ? `${film.runtime} min` : 'N/A';
                const poster   = film.poster_path ? IMG_URL + film.poster_path : '';

                document.title = `${film.title} - Critiverse`;

                document.getElementById('film-details-target').innerHTML = `
                    <div class="film-info">
                        <div class="film-top">
                            <div class="film-cover"><img src="${poster}" alt="${film.title}"></div>
                            <div class="film-summary">
                                <h1>${film.title}</h1>
                                <p><strong>Année :</strong> ${year}</p>
                                <p><strong>Durée :</strong> ${duration}</p>
                                <p><strong>Genres :</strong> ${genres}</p>
                                <p><strong>Note TMDB :</strong> ⭐ ${film.vote_average ? film.vote_average.toFixed(1) : 'N/A'}/10</p>
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
            } catch (err) {
                document.getElementById('film-details-target').innerHTML = "<p>Erreur lors du chargement du film.</p>";
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
                    body: JSON.stringify({ type: 'film', id: parseInt(movieId), score: parseInt(selectedScore), comment })
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
                const res  = await fetch(`/Critiverse/public/api/reviews.php?type=film&id=${movieId}`);
                const data = await res.json();
                if (!data.success || data.reviews.length === 0) {
                    list.innerHTML = '<p style="color:#999;">Soyez le premier à donner votre avis sur ce film !</p>';
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

        loadFilmData();

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
