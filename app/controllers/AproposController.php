<?php
// Gère la page À Propos

class AproposController extends Controller
{
    public function index(): void
    {
        $this->render('apropos/index', ['title' => 'À propos - Critiverse']);
    }
}
