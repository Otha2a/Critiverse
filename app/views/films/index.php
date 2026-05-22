<?php
$activePage        = 'films';
$css               = 'animes';
$searchPlaceholder = 'Rechercher un film...';
$extraCss = 'main{display:block!important}#gallery{display:flex!important;flex-wrap:wrap!important;gap:16px;padding:20px;justify-content:center}.gallery{width:180px!important;height:auto!important;text-align:center}.gallery img{width:100%!important;height:260px!important;object-fit:cover;border-radius:8px;cursor:pointer;transition:transform .2s}.gallery img:hover{transform:scale(1.05)}.gallery p{font-size:14px;margin:5px 0;font-weight:bold;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}';
require_once __DIR__ . '/../layouts/header.php';
?>
    <nav class="navbar">
        <ul>
            <li><a href="/Critiverse/public/films?genre=28">Action</a></li>
            <li><a href="/Critiverse/public/films?genre=35">Com&eacute;die</a></li>
            <li><a href="/Critiverse/public/films?genre=18">Drame</a></li>
            <li><a href="/Critiverse/public/films?genre=27">Horreur</a></li>
            <li><a href="/Critiverse/public/films?genre=10749">Romance</a></li>
            <li><a href="/Critiverse/public/films?genre=878">Science-Fiction</a></li>
            <li><a href="/Critiverse/public/films?genre=53">Thriller</a></li>
            <li><a href="/Critiverse/public/films?genre=12">Aventure</a></li>
        </ul>
    </nav>

    <main>
        <div id="gallery"></div>
        <div id="sentinel" style="height:1px;"></div>
        <p id="loading-msg" style="text-align:center;padding:20px;display:none;">Chargement...</p>
    </main>

    <script>
        const API_KEY    = '7f41925d9303e23359cf5a62ee62de74';
        const TMDB_URL   = 'https://api.themoviedb.org/3';
        const IMG_URL    = 'https://image.tmdb.org/t/p/w500';

        const gallery    = document.getElementById('gallery');
        const loadingMsg = document.getElementById('loading-msg');
        const urlParams  = new URLSearchParams(window.location.search);
        const genreId    = urlParams.get('genre');
        const searchQuery = urlParams.get('q');

        let currentPage  = 1;
        let totalPages   = 999;
        let isLoading    = false;
        let currentSearch = searchQuery || "";

        if (searchQuery) document.getElementById('searchInput').value = searchQuery;

        function doSearch() {
            const val = document.getElementById('searchInput').value.trim();
            if (val.length < 2) return alert("2 lettres minimum");
            window.location.href = `/Critiverse/public/films?q=${encodeURIComponent(val)}`;
        }

        document.getElementById('searchInput').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') doSearch();
        });

        async function loadMovies(page, query) {
            if (isLoading || page > totalPages) return;
            isLoading = true;
            loadingMsg.style.display = 'block';

            if (page === 1) gallery.innerHTML = "";

            let endpoint;
            if (query) {
                endpoint = `/search/movie?api_key=${API_KEY}&language=fr-FR&query=${encodeURIComponent(query)}&page=${page}`;
            } else if (genreId) {
                endpoint = `/discover/movie?api_key=${API_KEY}&language=fr-FR&with_genres=${genreId}&sort_by=popularity.desc&page=${page}`;
            } else {
                endpoint = `/movie/popular?api_key=${API_KEY}&language=fr-FR&page=${page}`;
            }

            try {
                const res  = await fetch(`${TMDB_URL}${endpoint}`);
                const data = await res.json();
                if (data.total_pages) totalPages = data.total_pages;

                (data.results || []).filter(m => m.poster_path).forEach(movie => {
                    const div = document.createElement('div');
                    div.className = 'gallery';
                    div.innerHTML = `
                        <a href="/Critiverse/public/notation-film?id=${movie.id}">
                            <img src="${IMG_URL}${movie.poster_path}" alt="${movie.title}">
                        </a>
                        <p>${movie.title}</p>
                        <p>★ ${movie.vote_average.toFixed(1)}</p>`;
                    gallery.appendChild(div);
                });
                currentPage++;
            } catch (err) {
                console.error("Erreur:", err);
            } finally {
                isLoading = false;
                loadingMsg.style.display = 'none';
                if (document.body.scrollHeight <= window.innerHeight + 200 && currentPage <= totalPages) {
                    loadMovies(currentPage, currentSearch);
                }
            }
        }

        window.addEventListener('scroll', () => {
            if (!isLoading && currentPage <= totalPages &&
                window.innerHeight + window.scrollY >= document.body.scrollHeight - 600) {
                loadMovies(currentPage, currentSearch);
            }
        });

        loadMovies(1, currentSearch);
    </script>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
