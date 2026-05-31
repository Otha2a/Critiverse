<?php

class MessagesController extends Controller
{
    private function checkAccess(): bool
    {
        $plan = $_SESSION['plan'] ?? 'gratuit';
        if (!isset($_SESSION['user_id']) || $plan === 'gratuit') {
            $this->redirect('/Critiverse/public/abonnement');
            return false;
        }
        return true;
    }

    public function inbox(): void
    {
        if (!$this->checkAccess()) return;

        $model         = new Message();
        $conversations = $model->getConversations((int)$_SESSION['user_id']);
        $users         = $model->getPremiumUsers((int)$_SESSION['user_id'], $_GET['search'] ?? '');

        $this->render('messages/inbox', [
            'title'         => 'Messages privés - Critiverse',
            'conversations' => $conversations,
            'users'         => $users,
            'search'        => $_GET['search'] ?? '',
        ]);
    }

    public function conversation(): void
    {
        if (!$this->checkAccess()) return;

        $otherId = (int)($_GET['user'] ?? 0);
        if ($otherId === 0) {
            $this->redirect('/Critiverse/public/messages');
            return;
        }

        $userModel = new User();
        $other     = $userModel->findById($otherId);

        if (!$other || !in_array($other['plan'] ?? 'gratuit', ['premium', 'pro'])) {
            $this->redirect('/Critiverse/public/messages');
            return;
        }

        $model    = new Message();
        $messages = $model->getConversation((int)$_SESSION['user_id'], $otherId);
        $model->markAsRead((int)$_SESSION['user_id'], $otherId);

        $this->render('messages/conversation', [
            'title'    => 'Conversation avec ' . htmlspecialchars($other['username']) . ' - Critiverse',
            'other'    => $other,
            'messages' => $messages,
        ]);
    }

    public function send(): void
    {
        if (!$this->checkAccess()) return;

        $receiverId = (int)($_POST['receiver_id'] ?? 0);
        $content    = trim($_POST['content'] ?? '');

        if ($receiverId === 0 || $content === '') {
            $this->redirect('/Critiverse/public/messages');
            return;
        }

        $userModel = new User();
        $receiver  = $userModel->findById($receiverId);

        if (!$receiver || !in_array($receiver['plan'] ?? 'gratuit', ['premium', 'pro'])) {
            $this->redirect('/Critiverse/public/messages');
            return;
        }

        $model = new Message();
        $model->send((int)$_SESSION['user_id'], $receiverId, $content);

        $this->redirect('/Critiverse/public/messages/conversation?user=' . $receiverId);
    }
}
