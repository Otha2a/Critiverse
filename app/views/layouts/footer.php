    <footer class="footer">

        <!-- ── Bande supérieure ── -->
        <div class="footer-top">
            <div class="footer-brand">
                <img src="/Critiverse/archives/images/autres/logo.png" alt="Critiverse" class="footer-logo">
                <div>
                    <span class="footer-brand-name">Critiverse</span>
                    <p class="footer-tagline">La plateforme des passionnés de cinéma, séries et animés.</p>
                </div>
            </div>
            <div class="footer-cols">
                <div class="footer-col">
                    <h4>Explorer</h4>
                    <a href="/Critiverse/public/films">🎬 Films</a>
                    <a href="/Critiverse/public/series">📺 Séries</a>
                    <a href="/Critiverse/public/animes">⚔️ Animés</a>
                    <a href="/Critiverse/public/actualites">📰 Actualités</a>
                    <a href="/Critiverse/public/critiques">⭐ Critiques</a>
                </div>
                <div class="footer-col">
                    <h4>Compte</h4>
                    <a href="/Critiverse/public/login">Se connecter</a>
                    <a href="/Critiverse/public/register">S'inscrire</a>
                    <a href="/Critiverse/public/abonnement">Abonnement</a>
                </div>
                <div class="footer-col">
                    <h4>À propos</h4>
                    <a href="/Critiverse/public/apropos">Notre équipe</a>
                    <a href="/Critiverse/public/contact">Nous contacter</a>
                    <a href="/Critiverse/public/mentions">Mentions légales</a>
                </div>
            </div>
        </div>

        <!-- ── Bande inférieure ── -->
        <div class="footer-bottom">
            <span>© <?= date('Y') ?> Critiverse — Tous droits réservés</span>
            <div class="footer-socials">
                <a href="https://instagram.com/" title="Instagram"><img src="/Critiverse/archives/images/autres/instagram.png" alt="Instagram"></a>
                <a href="https://www.linkedin.com/" title="LinkedIn"><img src="/Critiverse/archives/images/autres/linkedin.png" alt="LinkedIn"></a>
                <a href="https://x.com/" title="X"><img src="/Critiverse/archives/images/autres/x.png" alt="X"></a>
            </div>
        </div>

    </footer>

    <!-- ── Carte profil utilisateur ── -->
    <div id="profile-card" style="display:none;">
        <div class="pcard-avatar" id="pcard-avatar"></div>
        <div class="pcard-info">
            <div class="pcard-name" id="pcard-name"></div>
            <div id="pcard-badge"></div>
            <div class="pcard-since" id="pcard-since"></div>
        </div>
        <div class="pcard-stats">
            <div class="pcard-stat">
                <span id="pcard-count">0</span>
                <small>critiques</small>
            </div>
        </div>
        <div class="pcard-reviews" id="pcard-reviews"></div>
    </div>
    <div id="profile-overlay" onclick="closeProfile()"></div>

    <style>
    #profile-overlay {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 998;
    }
    #profile-card {
        position: fixed;
        z-index: 999;
        background: white;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.18);
        padding: 24px;
        width: 280px;
        animation: pcardIn 0.18s ease;
    }
    @keyframes pcardIn {
        from { opacity: 0; transform: scale(0.95) translateY(-6px); }
        to   { opacity: 1; transform: scale(1)    translateY(0); }
    }
    .pcard-avatar {
        width: 56px; height: 56px; border-radius: 50%;
        color: white; font-size: 1.4rem; font-weight: 800;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 12px;
    }
    .pcard-name  { font-size: 1rem; font-weight: 800; color: #111; }
    .pcard-since { font-size: 12px; color: #999; margin-top: 4px; }
    .pcard-badge { margin: 4px 0; font-size: 12px; font-weight: 700; }
    .pcard-badge.premium { color: #92400e; }
    .pcard-badge.pro     { color: #4c1d95; }
    .pcard-stats {
        display: flex; gap: 16px; margin: 14px 0 12px;
        padding: 12px; background: #f9fafb; border-radius: 10px;
    }
    .pcard-stat { text-align: center; flex: 1; }
    .pcard-stat span { display: block; font-size: 1.2rem; font-weight: 800; color: #2f6df6; }
    .pcard-stat small { font-size: 11px; color: #888; }
    .pcard-reviews { display: flex; flex-direction: column; gap: 8px; }
    .pcard-review {
        font-size: 12px; color: #555; padding: 8px 10px;
        background: #f3f4f6; border-radius: 8px; line-height: 1.4;
    }
    .pcard-review .pcard-score { color: #f59e0b; font-weight: 700; }
    .pcard-review .pcard-type  { color: #9ca3af; font-size: 11px; }
    .pcard-empty { font-size: 13px; color: #aaa; text-align: center; padding: 8px 0; }
    .username-link {
        cursor: pointer; color: inherit; font-weight: inherit;
        text-decoration: underline dotted; text-underline-offset: 2px;
        transition: color 0.15s;
    }
    .username-link:hover { color: #2f6df6; }
    </style>

    <script>
    function openProfile(username, anchorEl) {
        var card = document.getElementById('profile-card');
        var overlay = document.getElementById('profile-overlay');

        // Position de la carte près du clic
        var rect = anchorEl.getBoundingClientRect();
        var top  = rect.bottom + window.scrollY + 8;
        var left = rect.left   + window.scrollX;

        // Éviter de sortir de l'écran
        if (left + 290 > window.innerWidth) left = window.innerWidth - 300;
        if (top  + 340 > window.scrollY + window.innerHeight) top = rect.top + window.scrollY - 348;

        card.style.top  = top  + 'px';
        card.style.left = left + 'px';
        card.style.display = 'block';
        overlay.style.display = 'block';

        // Charger les données
        document.getElementById('pcard-name').textContent   = username;
        document.getElementById('pcard-since').textContent  = '…';
        document.getElementById('pcard-count').textContent  = '…';
        document.getElementById('pcard-reviews').innerHTML  = '';
        document.getElementById('pcard-badge').textContent  = '';

        var initiale = username.charAt(0).toUpperCase();
        var colors   = ['#2f6df6','#7c3aed','#16a34a','#e53935','#f59e0b','#0891b2'];
        var color    = colors[username.charCodeAt(0) % colors.length];
        var av = document.getElementById('pcard-avatar');
        av.textContent = initiale;
        av.style.background = color;

        fetch('/Critiverse/public/api/user-profile.php?username=' + encodeURIComponent(username))
            .then(function(r) { return r.json(); })
            .then(function(d) {
                if (!d.success) return;

                // Badge plan
                var badge = document.getElementById('pcard-badge');
                if (d.plan === 'premium') {
                    badge.textContent = '⭐ Premium';
                    badge.className = 'pcard-badge premium';
                } else if (d.plan === 'pro') {
                    badge.textContent = '👑 Pro';
                    badge.className = 'pcard-badge pro';
                } else {
                    badge.textContent = '';
                }

                // Date membre
                var date = new Date(d.member_since);
                document.getElementById('pcard-since').textContent =
                    'Membre depuis ' + date.toLocaleDateString('fr-FR', {month:'long', year:'numeric'});

                // Nb critiques
                document.getElementById('pcard-count').textContent = d.review_count;

                // Dernières critiques
                var container = document.getElementById('pcard-reviews');
                if (d.reviews.length === 0) {
                    container.innerHTML = '<p class="pcard-empty">Aucune critique publiée.</p>';
                } else {
                    container.innerHTML = d.reviews.map(function(r) {
                        var stars = '★'.repeat(r.score) + '☆'.repeat(5 - r.score);
                        var type  = r.media_type === 'film' ? '🎬' : r.media_type === 'serie' ? '📺' : '⚔️';
                        return '<div class="pcard-review">'
                            + '<span class="pcard-score">' + stars + '</span> '
                            + '<span class="pcard-type">' + type + '</span> '
                            + r.comment.substring(0, 60) + (r.comment.length > 60 ? '…' : '')
                            + '</div>';
                    }).join('');
                }
            })
            .catch(function() {});
    }

    function closeProfile() {
        document.getElementById('profile-card').style.display = 'none';
        document.getElementById('profile-overlay').style.display = 'none';
    }

    // Rendre les pseudos cliquables dans les critiques (chargées dynamiquement)
    document.addEventListener('click', function(e) {
        var el = e.target;
        if (el.classList.contains('username-link')) {
            e.stopPropagation();
            openProfile(el.dataset.username, el);
        }
    });
    </script>

    <!-- Modal connexion -->
    <div id="modal-login" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:1000;justify-content:center;align-items:center;">
        <div style="background:white;padding:30px;border-radius:12px;width:340px;">
            <button type="button" style="float:right;cursor:pointer;font-size:20px;background:none;border:none;" onclick="document.getElementById('modal-login').style.display='none'">✕</button>
            <h3 style="margin-bottom:16px;">Se connecter</h3>
            <div style="display:flex;flex-direction:column;gap:10px;">
                <input type="email" placeholder="Email" style="padding:10px;border-radius:8px;border:1px solid #ddd;font-size:14px;">
                <input type="password" placeholder="Mot de passe" style="padding:10px;border-radius:8px;border:1px solid #ddd;font-size:14px;">
                <button style="background:#2f6df6;color:#fff;border:none;border-radius:8px;padding:11px;cursor:pointer;font-size:14px;">Connexion</button>
            </div>
        </div>
    </div>

    <!-- Modal inscription -->
    <div id="modal-register" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:1000;justify-content:center;align-items:center;">
        <div style="background:white;padding:30px;border-radius:12px;width:340px;">
            <button type="button" style="float:right;cursor:pointer;font-size:20px;background:none;border:none;" onclick="document.getElementById('modal-register').style.display='none'">✕</button>
            <h3 style="margin-bottom:16px;">S'inscrire</h3>
            <div style="display:flex;flex-direction:column;gap:10px;">
                <input type="text" placeholder="Pseudo" style="padding:10px;border-radius:8px;border:1px solid #ddd;font-size:14px;">
                <input type="email" placeholder="Email" style="padding:10px;border-radius:8px;border:1px solid #ddd;font-size:14px;">
                <input type="password" placeholder="Mot de passe" style="padding:10px;border-radius:8px;border:1px solid #ddd;font-size:14px;">
                <button style="background:#2f6df6;color:#fff;border:none;border-radius:8px;padding:11px;cursor:pointer;font-size:14px;">Créer mon compte</button>
            </div>
        </div>
    </div>

    <script>
    // ── Thème dark/light ──────────────────────────────────────────
    function applyTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        var btn = document.getElementById('theme-toggle');
        if (btn) btn.textContent = theme === 'light' ? '🌙' : '☀️';
    }

    function toggleTheme() {
        var current = document.documentElement.getAttribute('data-theme') || 'dark';
        var next = current === 'dark' ? 'light' : 'dark';
        localStorage.setItem('critiverse-theme', next);
        applyTheme(next);
    }

    // Appliquer immédiatement au chargement
    (function() {
        var saved = localStorage.getItem('critiverse-theme') || 'dark';
        applyTheme(saved);
    })();
    </script>

    <script>
        window.addEventListener('click', function(e) {
            ['modal-login','modal-register'].forEach(function(id) {
                var m = document.getElementById(id);
                if (m && e.target === m) m.style.display = 'none';
            });
        });
    </script>
</body>
</html>
