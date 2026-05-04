<?php
// Gère la page d’accueil du site
// Affiche les films populaires, récents ou recommandations

class HomeController extends Controller
{
    public function index(): void
    {
        $data = [
            'title' => 'Accueil',
            'welcome' => 'Bienvenue sur votre site dynamique !',
            'description' => 'Cette page d’accueil illustre comment transformer votre site statique en pages dynamiques avec un contrôleur et une route.',
        ];

        $this->render('home/index', $data);
    }
}
