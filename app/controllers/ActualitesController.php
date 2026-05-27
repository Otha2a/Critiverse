<?php

class ActualitesController extends Controller
{
    public function index(): void
    {
        $films = [
            ['title' => 'Dune : Deuxième Partie', 'year' => '2024', 'note' => 8.5, 'genre' => 'Sci-Fi',    'wiki' => 'Dune: Part Two'],
            ['title' => 'Deadpool & Wolverine',   'year' => '2024', 'note' => 7.9, 'genre' => 'Action',    'wiki' => 'Deadpool & Wolverine'],
            ['title' => 'Inside Out 2',            'year' => '2024', 'note' => 7.8, 'genre' => 'Animation', 'wiki' => 'Inside Out 2'],
            ['title' => 'Alien: Romulus',          'year' => '2024', 'note' => 7.4, 'genre' => 'Horreur',   'wiki' => 'Alien: Romulus'],
            ['title' => 'Wicked',                  'year' => '2024', 'note' => 7.6, 'genre' => 'Musical',   'wiki' => 'Wicked (2024 film)'],
            ['title' => 'Gladiator II',            'year' => '2024', 'note' => 7.2, 'genre' => 'Action',    'wiki' => 'Gladiator II'],
            ['title' => 'The Substance',           'year' => '2024', 'note' => 7.5, 'genre' => 'Horreur',   'wiki' => 'The Substance'],
            ['title' => 'Conclave',                'year' => '2024', 'note' => 7.7, 'genre' => 'Thriller',  'wiki' => 'Conclave (film)'],
            ['title' => 'Anora',                   'year' => '2024', 'note' => 7.9, 'genre' => 'Drame',     'wiki' => 'Anora'],
            ['title' => 'Nosferatu',               'year' => '2024', 'note' => 7.3, 'genre' => 'Horreur',   'wiki' => 'Nosferatu (2024 film)'],
        ];

        $this->render('actualites/index', [
            'title' => 'Actualités - Critiverse',
            'films' => $films,
        ]);
    }
}
