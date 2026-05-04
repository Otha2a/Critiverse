<?php
// Gère la page À Propos

class AproposController extends Controller
{
    public function index(): void
    {
        $data = [
            'title' => 'À propos',
            'heading' => 'À propos de Critiverse',
            'content' => 'Bienvenue sur la page À Propos. Ici, vous pouvez expliquer la mission de votre site, sa vision, ou présenter votre équipe.',
        ];

        $this->render('apropos/index', $data);
    }
}
