<?php
$activePage        = 'animes';
$css               = 'animes';
$searchPlaceholder = 'Rechercher un anime...';
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
        <p id="loading-msg" style="text-align:center;padding:20px;display:none;">Chargement...</p>
    </main>

    <div id="pagination">
        <button class="page-btn" id="btn-prev" onclick="changePage(-1)" disabled>← Précédent</button>
        <span id="page-info">Page 1</span>
        <button class="page-btn" id="btn-next" onclick="changePage(1)">Suivant →</button>
    </div>

    <script>
        const gallery    = document.getElementById('gallery');
        const loadingMsg = document.getElementById('loading-msg');
        const urlParams  = new URLSearchParams(window.location.search);
        const genreId    = urlParams.get('genre');

        let currentPage = 1;
        let totalPages  = 1;
        let isLoading   = false;
        let currentSearch = '';
        let displayedIds  = new Set();

        function doSearch() {
            const val = document.getElementById('searchInput').value.trim();
            if (val.length < 3) return alert('3 lettres minimum');
            currentSearch = val;
            loadPage(1);
        }

        document.getElementById('searchInput').addEventListener('keydown', e => {
            if (e.key === 'Enter') doSearch();
        });

        async function loadPage(page) {
            if (isLoading) return;
            isLoading = true;
            loadingMsg.style.display = 'block';
            gallery.innerHTML = '';
            displayedIds.clear();

            let url;
            if (currentSearch) {
                url = `https://api.jikan.moe/v4/anime?q=${encodeURIComponent(currentSearch)}&page=${page}&sfw&type=tv`;
            } else if (genreId) {
                url = `https://api.jikan.moe/v4/anime?page=${page}&sfw&type=tv&order_by=score&sort=desc&genres=${genreId}`;
            } else {
                url = `https://api.jikan.moe/v4/anime?page=${page}&sfw&type=tv&order_by=score&sort=desc`;
            }

            try {
                const res  = await fetch(url);
                const data = await res.json();

                if (data.pagination) {
                    totalPages  = data.pagination.last_visible_page || 1;
                    currentPage = page;
                }

                (data.data || []).forEach(anime => {
                    if (displayedIds.has(anime.mal_id)) return;
                    displayedIds.add(anime.mal_id);
                    const div = document.createElement('div');
                    div.className = 'gallery';
                    div.innerHTML = `
                        <a href="/Critiverse/public/notation?id=${anime.mal_id}">
                            <img src="${anime.images.jpg.large_image_url}" alt="${anime.title}">
                        </a>
                        <p title="${anime.title}">${anime.title}</p>
                        <p>★ ${anime.score || 'N/A'}</p>`;
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
