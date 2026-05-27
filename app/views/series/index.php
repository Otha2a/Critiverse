<?php
$activePage        = 'series';
$css               = 'animes';
$searchPlaceholder = 'Rechercher une s&eacute;rie...';
$extraCss = '
main{display:block!important}
#gallery{display:flex!important;flex-wrap:wrap!important;gap:16px;padding:20px;justify-content:center}
.gallery{width:180px!important;height:auto!important;text-align:center}
.gallery img{width:100%!important;height:260px!important;object-fit:cover;border-radius:8px;cursor:pointer;transition:transform .2s}
.gallery img:hover{transform:scale(1.05)}
.gallery p{font-size:14px;margin:5px 0;font-weight:bold;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
#pagination{display:flex;justify-content:center;align-items:center;gap:14px;padding:24px 20px}
.page-btn{background:#2f6df6;color:#fff;border:none;border-radius:8px;padding:9px 20px;font-size:.9rem;font-weight:600;cursor:pointer;transition:background .2s}
.page-btn:hover:not(:disabled){background:#2559c7}
.page-btn:disabled{background:#ccc;cursor:default}
#page-info{font-size:.9rem;font-weight:600;min-width:130px;text-align:center}
';
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

    <main>
        <div id="gallery"></div>
        <p id="loading-msg" style="text-align:center;padding:20px;display:none;">Chargement...</p>
    </main>

    <div id="pagination">
        <button class="page-btn" id="btn-prev" onclick="changePage(-1)" disabled>← Précédent</button>
        <span id="page-info">Page 1</span>
        <button class="page-btn" id="btn-next" onclick="changePage(1)">Suivant →</button>
    </div>

    <script>
        const API_KEY  = '7f41925d9303e23359cf5a62ee62de74';
        const TMDB_URL = 'https://api.themoviedb.org/3';
        const IMG_URL  = 'https://image.tmdb.org/t/p/w500';

        const gallery    = document.getElementById('gallery');
        const loadingMsg = document.getElementById('loading-msg');
        const urlParams  = new URLSearchParams(window.location.search);
        const genreId    = urlParams.get('genre');
        const searchQuery = urlParams.get('q');

        let currentPage = 1;
        let totalPages  = 1;
        let isLoading   = false;

        if (searchQuery) document.getElementById('searchInput').value = searchQuery;

        function doSearch() {
            const val = document.getElementById('searchInput').value.trim();
            if (val.length < 2) return alert('2 lettres minimum');
            window.location.href = `/Critiverse/public/series?q=${encodeURIComponent(val)}`;
        }

        document.getElementById('searchInput').addEventListener('keydown', e => {
            if (e.key === 'Enter') doSearch();
        });

        async function loadPage(page) {
            if (isLoading) return;
            isLoading = true;
            loadingMsg.style.display = 'block';
            gallery.innerHTML = '';

            let endpoint;
            if (searchQuery) {
                endpoint = `/search/tv?api_key=${API_KEY}&language=fr-FR&query=${encodeURIComponent(searchQuery)}&page=${page}`;
            } else if (genreId) {
                endpoint = `/discover/tv?api_key=${API_KEY}&language=fr-FR&with_genres=${genreId}&sort_by=popularity.desc&page=${page}`;
            } else {
                endpoint = `/tv/popular?api_key=${API_KEY}&language=fr-FR&page=${page}`;
            }

            try {
                const res  = await fetch(`${TMDB_URL}${endpoint}`);
                const data = await res.json();
                totalPages  = Math.min(data.total_pages || 1, 500);
                currentPage = page;

                (data.results || []).filter(s => s.poster_path).forEach(serie => {
                    const div = document.createElement('div');
                    div.className = 'gallery';
                    div.innerHTML = `
                        <a href="/Critiverse/public/notation-serie?id=${serie.id}">
                            <img src="${IMG_URL}${serie.poster_path}" alt="${serie.name}">
                        </a>
                        <p title="${serie.name}">${serie.name}</p>
                        <p>★ ${serie.vote_average.toFixed(1)}</p>`;
                    gallery.appendChild(div);
                });

                majPagination();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            } catch (err) {
                console.error(err);
            } finally {
                isLoading = false;
                loadingMsg.style.display = 'none';
            }
        }

        function majPagination() {
            document.getElementById('page-info').textContent =
                `Page ${currentPage} sur ${totalPages}`;
            document.getElementById('btn-prev').disabled = currentPage <= 1;
            document.getElementById('btn-next').disabled = currentPage >= totalPages;
        }

        function changePage(delta) {
            const next = currentPage + delta;
            if (next >= 1 && next <= totalPages) loadPage(next);
        }

        loadPage(1);
    </script>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
