<?php

class AbonnementController extends Controller
{
    public function index(): void
    {
        $this->render('abonnement/index', ['title' => 'Abonnement - Critiverse']);
    }

    public function subscribe(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/Critiverse/public/abonnement');
            return;
        }

        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/Critiverse/public/login');
            return;
        }

        $plan   = $_POST['plan']   ?? '';
        $prenom = $_POST['prenom'] ?? '';
        $nom    = $_POST['nom']    ?? '';
        $email  = $_POST['email']  ?? '';

        $plansValides = ['Gratuit', 'Premium', 'Pro'];
        if (!in_array($plan, $plansValides) || empty($prenom) || empty($nom) || empty($email)) {
            $this->redirect('/Critiverse/public/abonnement?error=validation');
            return;
        }

        $planBdd = strtolower($plan);
        $user = new User();
        $user->updatePlan((int)$_SESSION['user_id'], $planBdd);

        // Mettre à jour la session immédiatement
        $_SESSION['plan'] = $planBdd;

        $this->redirect('/Critiverse/public/abonnement?success=1&plan=' . urlencode($plan));
    }
}
