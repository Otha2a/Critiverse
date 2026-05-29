<?php

class ForumController extends Controller
{
    private const BASE  = '/Critiverse/public/';
    private const FORUM = '/Critiverse/public/forum';

    private function db(): PDO
    {
        $pdo = getDatabaseConnection();

        $pdo->exec("CREATE TABLE IF NOT EXISTS forum_topics (
            id          INT AUTO_INCREMENT PRIMARY KEY,
            title       VARCHAR(200) NOT NULL,
            content     TEXT NOT NULL,
            user_id     INT NOT NULL,
            username    VARCHAR(50) NOT NULL,
            created_at  DATETIME DEFAULT CURRENT_TIMESTAMP,
            reply_count INT DEFAULT 0,
            INDEX idx_created (created_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $pdo->exec("CREATE TABLE IF NOT EXISTS forum_replies (
            id         INT AUTO_INCREMENT PRIMARY KEY,
            topic_id   INT NOT NULL,
            content    TEXT NOT NULL,
            user_id    INT NOT NULL,
            username   VARCHAR(50) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_topic (topic_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        return $pdo;
    }

    // ── GET /forum ──────────────────────────────────────────────────────────────
    public function index(): void
    {
        $pdo = $this->db();
        $page  = max(1, (int)($_GET['page'] ?? 1));
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $total = (int)$pdo->query("SELECT COUNT(*) FROM forum_topics")->fetchColumn();
        $pages = max(1, (int)ceil($total / $limit));

        $stmt  = $pdo->prepare(
            "SELECT * FROM forum_topics ORDER BY created_at DESC LIMIT ? OFFSET ?"
        );
        $stmt->execute([$limit, $offset]);
        $topics = $stmt->fetchAll();

        $this->render('forum/index', [
            'title'  => 'Forum - Critiverse',
            'topics' => $topics,
            'page'   => $page,
            'pages'  => $pages,
        ]);
    }

    // ── GET /forum/topic ────────────────────────────────────────────────────────
    public function show(): void
    {
        $id  = (int)($_GET['id'] ?? 0);
        $pdo = $this->db();

        $topic = $pdo->prepare("SELECT * FROM forum_topics WHERE id = ?");
        $topic->execute([$id]);
        $topic = $topic->fetch();

        if (!$topic) {
            $this->render('forum/index', [
                'title'  => 'Forum - Critiverse',
                'topics' => [],
                'page'   => 1,
                'pages'  => 1,
            ]);
            return;
        }

        $replies = $pdo->prepare("SELECT * FROM forum_replies WHERE topic_id = ? ORDER BY created_at ASC");
        $replies->execute([$id]);

        $this->render('forum/topic', [
            'title'   => htmlspecialchars($topic['title']) . ' - Forum',
            'topic'   => $topic,
            'replies' => $replies->fetchAll(),
        ]);
    }

    // ── GET /forum/new ──────────────────────────────────────────────────────────
    public function newForm(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect(self::FORUM);
            return;
        }
        $error = $_SESSION['forum_error'] ?? null;
        unset($_SESSION['forum_error']);
        $this->render('forum/new', ['title' => 'Nouveau sujet - Forum', 'error' => $error]);
    }

    // ── POST /forum/new ─────────────────────────────────────────────────────────
    public function create(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect(self::FORUM);
            return;
        }

        $title   = trim($_POST['title']   ?? '');
        $content = trim($_POST['content'] ?? '');

        if (mb_strlen($title) < 3 || mb_strlen($content) < 10) {
            $_SESSION['forum_error'] = 'Le titre (3 car. min) et le contenu (10 car. min) sont requis.';
            $this->redirect(self::FORUM . '/new');
            return;
        }

        $pdo = $this->db();
        $pdo->prepare("INSERT INTO forum_topics (title, content, user_id, username) VALUES (?,?,?,?)")
            ->execute([$title, $content, $_SESSION['user_id'], $_SESSION['username']]);

        $this->redirect(self::FORUM);
    }

    // ── POST /forum/reply ───────────────────────────────────────────────────────
    public function reply(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect(self::FORUM);
            return;
        }

        $topicId = (int)($_POST['topic_id'] ?? 0);
        $content = trim($_POST['content'] ?? '');

        if ($topicId <= 0 || mb_strlen($content) < 2) {
            $this->redirect(self::FORUM . '/topic?id=' . $topicId);
            return;
        }

        $pdo = $this->db();
        $pdo->prepare("INSERT INTO forum_replies (topic_id, content, user_id, username) VALUES (?,?,?,?)")
            ->execute([$topicId, $content, $_SESSION['user_id'], $_SESSION['username']]);

        $pdo->prepare("UPDATE forum_topics SET reply_count = reply_count + 1 WHERE id = ?")
            ->execute([$topicId]);

        $this->redirect(self::FORUM . '/topic?id=' . $topicId . '#bottom');
    }
}
