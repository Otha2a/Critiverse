<?php
// Gère le formulaire de contact

class ContactController extends Controller
{
    public function index(): void
    {
        $data = [
            'title' => 'Contact',
            'heading' => 'Contactez-nous',
        ];

        $this->render('contact/form', $data);
    }

    public function send(): void
    {
        // Envoyer message (mail ou BDD)
    }
}