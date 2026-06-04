<?php
$activePage  = 'abonnement';
$css         = 'abonnement';
$title       = 'Abonnement - Critiverse';
require_once __DIR__ . '/../layouts/header.php';

$success     = isset($_GET['success']);
$planGet     = $_GET['plan'] ?? '';
$planActuel  = $_SESSION['plan'] ?? 'gratuit';
$connecte    = isset($_SESSION['user_id']);
?>

<!-- ── Hero ── -->
<section class="abo-hero">
    <h1>Choisissez votre formule</h1>
    <p>Profitez de Critiverse au maximum avec nos offres adaptées à chaque passionné.</p>
</section>

<!-- ── Plans ── -->
<section class="abo-plans">

    <!-- Gratuit -->
    <div class="abo-card <?= $planActuel === 'gratuit' ? 'abo-card-current' : '' ?>">
        <?php if ($planActuel === 'gratuit' && $connecte): ?>
            <div class="abo-badge-current">✅ Plan actuel</div>
        <?php endif; ?>
        <div class="abo-card-header">
            <span class="abo-icon">🆓</span>
            <h2>Gratuit</h2>
            <div class="abo-price"><span class="abo-amount">0€</span><span class="abo-period">/mois</span></div>
        </div>
        <ul class="abo-features">
            <li>✅ Consulter et publier des critiques</li>
            <li>✅ Noter films, séries et animés</li>
            <li>✅ Accès aux actualités</li>
            <li>❌ Pas de badge membre</li>
            <li>❌ Publicités présentes</li>
            <li>❌ Messagerie privée non disponible</li>
        </ul>
        <?php if (!$connecte): ?>
            <a href="/Critiverse/public/register"><button class="abo-btn abo-btn-outline">Commencer gratuitement</button></a>
        <?php elseif ($planActuel === 'gratuit'): ?>
            <button class="abo-btn abo-btn-disabled" disabled>Plan actuel</button>
        <?php else: ?>
            <a href="#formulaire" onclick="selectPlan('Gratuit')"><button class="abo-btn abo-btn-outline">Rétrograder</button></a>
        <?php endif; ?>
    </div>

    <!-- Premium -->
    <div class="abo-card abo-card-featured <?= $planActuel === 'premium' ? 'abo-card-current' : '' ?>">
        <?php if ($planActuel === 'premium' && $connecte): ?>
            <div class="abo-badge-current">✅ Plan actuel</div>
        <?php else: ?>
            <div class="abo-badge-popular">⭐ Populaire</div>
        <?php endif; ?>
        <div class="abo-card-header">
            <span class="abo-icon">🚀</span>
            <h2>Premium</h2>
            <div class="abo-price"><span class="abo-amount">4,99€</span><span class="abo-period">/mois</span></div>
        </div>
        <ul class="abo-features">
            <li>✅ Tout le plan Gratuit</li>
            <li>✅ Badge membre Premium ⭐</li>
            <li>✅ Sans publicités</li>
            <li>✅ Messagerie privée entre membres</li>
            <li>✅ Critiques illimitées</li>
            <li>❌ Pas de support prioritaire</li>
        </ul>
        <?php if (!$connecte): ?>
            <a href="/Critiverse/public/login"><button class="abo-btn abo-btn-primary">Se connecter pour souscrire</button></a>
        <?php elseif ($planActuel === 'premium'): ?>
            <button class="abo-btn abo-btn-disabled" disabled>Plan actuel</button>
        <?php else: ?>
            <a href="#formulaire" onclick="selectPlan('Premium')"><button class="abo-btn abo-btn-primary">Choisir Premium</button></a>
        <?php endif; ?>
    </div>

    <!-- Pro -->
    <div class="abo-card <?= $planActuel === 'pro' ? 'abo-card-current' : '' ?>">
        <?php if ($planActuel === 'pro' && $connecte): ?>
            <div class="abo-badge-current">✅ Plan actuel</div>
        <?php endif; ?>
        <div class="abo-card-header">
            <span class="abo-icon">👑</span>
            <h2>Pro</h2>
            <div class="abo-price"><span class="abo-amount">9,99€</span><span class="abo-period">/mois</span></div>
        </div>
        <ul class="abo-features">
            <li>✅ Tout le plan Premium</li>
            <li>✅ Badge membre Pro exclusif 👑</li>
            <li>✅ Messagerie privée illimitée</li>
            <li>✅ Support prioritaire par email</li>
            <li>✅ Profil mis en avant dans les critiques</li>
            <li>✅ Accès anticipé aux nouvelles fonctionnalités</li>
        </ul>
        <?php if (!$connecte): ?>
            <a href="/Critiverse/public/login"><button class="abo-btn abo-btn-outline">Se connecter pour souscrire</button></a>
        <?php elseif ($planActuel === 'pro'): ?>
            <button class="abo-btn abo-btn-disabled" disabled>Plan actuel</button>
        <?php else: ?>
            <a href="#formulaire" onclick="selectPlan('Pro')"><button class="abo-btn abo-btn-outline">Choisir Pro</button></a>
        <?php endif; ?>
    </div>

</section>

<!-- ── Formulaire ── -->
<section class="abo-form-section" id="formulaire">
    <div class="abo-form-box">

        <?php if ($success): ?>
            <div class="abo-alert abo-alert-success">
                ✅ Abonnement souscrit avec succès ! Bienvenue sur Critiverse <?= htmlspecialchars($plan) ?>.
            </div>
        <?php endif; ?>

        <h2>S'abonner</h2>
        <p class="abo-form-sub">Remplissez le formulaire pour activer votre abonnement.</p>

        <form method="POST" action="/Critiverse/public/abonnement" class="abo-form">

            <div class="abo-form-group">
                <label>Formule choisie</label>
                <div class="abo-plan-select">
                    <label class="abo-radio">
                        <input type="radio" name="plan" value="Gratuit" required> Gratuit — 0€/mois
                    </label>
                    <label class="abo-radio abo-radio-featured">
                        <input type="radio" name="plan" value="Premium"> Premium — 4,99€/mois ⭐
                    </label>
                    <label class="abo-radio">
                        <input type="radio" name="plan" value="Pro"> Pro — 9,99€/mois 👑
                    </label>
                </div>
            </div>

            <div class="abo-form-row">
                <div class="abo-form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" placeholder="Jean" required>
                </div>
                <div class="abo-form-group">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" placeholder="Dupont" required>
                </div>
            </div>

            <div class="abo-form-group">
                <label for="email">Adresse email</label>
                <input type="email" id="email" name="email" placeholder="jean@email.com" required>
            </div>

            <div class="abo-form-group" id="payment-fields">
                <label for="carte">Numéro de carte</label>
                <input type="text" id="carte" name="carte" placeholder="1234 5678 9012 3456" maxlength="19">
                <div class="abo-form-row" style="margin-top:12px;">
                    <div class="abo-form-group">
                        <label for="expiry">Date d'expiration</label>
                        <input type="text" id="expiry" name="expiry" placeholder="MM/AA" maxlength="5">
                    </div>
                    <div class="abo-form-group">
                        <label for="cvv">CVV</label>
                        <input type="text" id="cvv" name="cvv" placeholder="123" maxlength="3">
                    </div>
                </div>
            </div>

            <button type="submit" class="abo-btn abo-btn-primary abo-btn-full">Confirmer l'abonnement →</button>
            <p class="abo-secure">🔒 Paiement sécurisé — Vos données sont protégées</p>
        </form>
    </div>
</section>

<script>
function selectPlan(plan) {
    var radios = document.querySelectorAll('input[name="plan"]');
    radios.forEach(function(r) {
        if (r.value === plan) r.checked = true;
    });
    updatePaymentFields();
}

function updatePaymentFields() {
    var selected = document.querySelector('input[name="plan"]:checked');
    var fields   = document.getElementById('payment-fields');
    if (!fields) return;
    fields.style.display = (selected && selected.value !== 'Gratuit') ? 'block' : 'none';
}

document.querySelectorAll('input[name="plan"]').forEach(function(r) {
    r.addEventListener('change', updatePaymentFields);
});

// Formater le numéro de carte
var carteInput = document.getElementById('carte');
if (carteInput) {
    carteInput.addEventListener('input', function() {
        var v = this.value.replace(/\D/g, '').slice(0, 16);
        this.value = v.replace(/(.{4})/g, '$1 ').trim();
    });
}

// Formater la date d'expiration
var expiryInput = document.getElementById('expiry');
if (expiryInput) {
    expiryInput.addEventListener('input', function() {
        var v = this.value.replace(/\D/g, '').slice(0, 4);
        if (v.length >= 2) v = v.slice(0,2) + '/' + v.slice(2);
        this.value = v;
    });
}

updatePaymentFields();
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
