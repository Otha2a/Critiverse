<?php
$activePage = 'messages';
$css        = 'messages';
$title      = $title ?? 'Conversation - Critiverse';
require_once __DIR__ . '/../layouts/header.php';

$myId = (int)$_SESSION['user_id'];

function badgePlan(string $plan): string {
    return match($plan) {
        'premium' => '<span class="msg-badge premium">⭐ Premium</span>',
        'pro'     => '<span class="msg-badge pro">👑 Pro</span>',
        default   => ''
    };
}
?>

<div class="msg-layout">

    <!-- ── Sidebar ── -->
    <aside class="msg-sidebar">
        <h2>💬 Messages</h2>
        <form method="GET" action="/Critiverse/public/messages" class="msg-search-form">
            <input type="text" name="search" placeholder="Chercher un membre abonné...">
            <button type="submit">🔎</button>
        </form>
        <p class="msg-section-label">
            <a href="/Critiverse/public/messages" style="color:#2f6df6;text-decoration:none;">← Toutes les conversations</a>
        </p>
    </aside>

    <!-- ── Conversation ── -->
    <main class="msg-main">

        <!-- En-tête conversation -->
        <div class="msg-conv-header">
            <span class="msg-avatar msg-avatar-lg" style="background:<?= ($other['plan']==='pro')?'#7c3aed':'#2f6df6' ?>">
                <?= mb_strtoupper(mb_substr($other['username'],0,1)) ?>
            </span>
            <div>
                <strong><?= htmlspecialchars($other['username']) ?></strong>
                <?= badgePlan($other['plan']) ?>
            </div>
        </div>

        <!-- Messages -->
        <div class="msg-thread" id="msg-thread">
            <?php if (empty($messages)): ?>
                <p class="msg-empty" style="text-align:center;padding:40px 0;">Commencez la conversation !</p>
            <?php endif; ?>

            <?php foreach ($messages as $msg): ?>
                <?php $isMine = (int)$msg['sender_id'] === $myId; ?>
                <div class="msg-bubble-wrap <?= $isMine ? 'mine' : 'theirs' ?>">
                    <div class="msg-bubble <?= $isMine ? 'bubble-mine' : 'bubble-theirs' ?>">
                        <?= nl2br(htmlspecialchars($msg['content'])) ?>
                        <span class="msg-time">
                            <?= date('d/m H:i', strtotime($msg['created_at'])) ?>
                            <?php if ($isMine): ?>
                                <?= $msg['read_at'] ? ' ✓✓' : ' ✓' ?>
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Formulaire d'envoi -->
        <form method="POST" action="/Critiverse/public/messages/send" class="msg-send-form">
            <input type="hidden" name="receiver_id" value="<?= $other['id'] ?>">
            <textarea name="content" placeholder="Écrivez votre message..." rows="2" required></textarea>
            <button type="submit">Envoyer ➤</button>
        </form>

    </main>
</div>

<script>
// Scroll automatique en bas du thread
var thread = document.getElementById('msg-thread');
if (thread) thread.scrollTop = thread.scrollHeight;

// Envoi avec Ctrl+Entrée
document.querySelector('.msg-send-form textarea').addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && e.ctrlKey) {
        e.preventDefault();
        this.closest('form').submit();
    }
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
