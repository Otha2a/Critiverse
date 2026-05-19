<?php
$activePage        = 'animes';
$css               = 'animes';
$searchPlaceholder = 'Rechercher un anime...';
$extraCss = 'main{display:block!important}#gallery{display:flex!important;flex-wrap:wrap!important;gap:16px;padding:20px;justify-content:center}.gallery{width:180px!important;height:auto!important;text-align:center}.gallery img{width:100%!important;height:260px!important;object-fit:cover;border-radius:8px;cursor:pointer;transition:transform .2s}.gallery img:hover{transform:scale(1.05)}.gallery p{font-size:14px;margin:5px 0;font-weight:bold;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}';
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

    <main>
        <div id="gallery"></div>
        <p id="loading-msg" style="text-align:center;padding:20px;">Chargement...</p>
    </main>

    <script>
        const gallery = document.getElementById('gallery');
        let currentPage = 1;
        let isLoading   = false;
        let currentSearch = "";
        let displayedIds  = new Set();

        const urlParams = new URLSearchParams(window.location.search);
        const genreId   = urlParams.get('genre');

        function doSearch() {
            const val = document.getElementById('searchInput').value;
            if (val.length < 3) return alert("3 lettres minimum");
            currentSearch = val;
            currentPage   = 1;
            loadAnimes(1, val);
        }

        document.getElementById('searchInput').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') doSearch();
        });

        async function loadAnimes(page = 1, query = "") {
            if (isLoading) return;
            isLoading = true;

            if (page === 1) { gallery.innerHTML = ""; displayedIds.clear(); }

            let url = `https://api.jikan.moe/v4/anime?page=${page}&sfw&type=tv&order_by=score&sort=desc`;
            if (genreId && !query) {
                url += `&genres=${genreId}`;
            } else if (query) {
                url = `https://api.jikan.moe/v4/anime?q=${query}&page=${page}&sfw&type=tv`;
            }

            try {
                const res  = await fetch(url);
                const data = await res.json();
                if (data.data && data.data.length > 0) {
                    data.data.forEach(anime => {
                        if (!displayedIds.has(anime.mal_id)) {
                            displayedIds.add(anime.mal_id);
                            const div = document.createElement('div');
                            div.className = 'gallery';
                            div.innerHTML = `
                                <a href="/Critiverse/public/notation?id=${anime.mal_id}">
                                    <img src="${anime.images.jpg.large_image_url}" alt="${anime.title}">
                                </a>
                                <p>${anime.title}</p>
                                <p>★ ${anime.score || 'N/A'}</p>`;
                            gallery.appendChild(div);
                        }
                    });
                    currentPage++;
                }
            } catch (err) {
                console.error("Erreur:", err);
            } finally {
                isLoading = false;
                document.getElementById('loading-msg').style.display = 'none';
            }
        }

        window.onscroll = () => {
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 800) {
                loadAnimes(currentPage, currentSearch);
            }
        };

        loadAnimes();
    </script>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
