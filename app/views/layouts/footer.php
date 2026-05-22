    <hr>
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-left">
                <img src="/Critiverse/archives/images/autres/logo.png" alt="logo" class="logo">
                <div class="footer-links">
                    <a href="/Critiverse/public/apropos">À Propos</a>
                    <a href="/Critiverse/public/contact">Nous contacter</a>
                    <a href="/Critiverse/public/mentions">Mentions légales</a>
                </div>
                <div class="footer-socials">
                    <a href="https://instagram.com/"><img src="/Critiverse/archives/images/autres/instagram.png" alt="Instagram"></a>
                    <a href="https://www.linkedin.com/"><img src="/Critiverse/archives/images/autres/linkedin.png" alt="LinkedIn"></a>
                    <a href="https://x.com/"><img src="/Critiverse/archives/images/autres/x.png" alt="X"></a>
                </div>
            </div>
            <div class="footer-right">
                <div class="footer-col">
                    <h4>Films</h4>
                    <a href="/Critiverse/public/films">Top 10</a>
                    <a href="/Critiverse/public/actualites">Actualité</a>
                    <a href="/Critiverse/public/critiques">Critiques</a>
                </div>
                <div class="footer-col">
                    <h4>Séries</h4>
                    <a href="/Critiverse/public/series">Top 10</a>
                    <a href="/Critiverse/public/actualites">Actualité</a>
                    <a href="/Critiverse/public/critiques">Critiques</a>
                </div>
                <div class="footer-col">
                    <h4>Animes</h4>
                    <a href="/Critiverse/public/animes">Top 10</a>
                    <a href="/Critiverse/public/actualites">Actualité</a>
                    <a href="/Critiverse/public/critiques">Critiques</a>
                </div>
            </div>
        </div>
    </footer>

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
        window.addEventListener('click', function(e) {
            ['modal-login','modal-register'].forEach(function(id) {
                var m = document.getElementById(id);
                if (m && e.target === m) m.style.display = 'none';
            });
        });
    </script>
</body>
</html>
