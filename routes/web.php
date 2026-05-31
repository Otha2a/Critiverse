<?php
// Définition des routes

$router->get('/', 'HomeController@index');
$router->get('/profile',        'ProfileController@index');
$router->post('/profile/update', 'ProfileController@update');
$router->get('/apropos',         'AproposController@index');
$router->get('/mentions',    'MentionsController@index');
$router->get('/abonnement',              'AbonnementController@index');
$router->post('/abonnement',             'AbonnementController@subscribe');
$router->get('/messages',                'MessagesController@inbox');
$router->get('/messages/conversation',   'MessagesController@conversation');
$router->post('/messages/send',          'MessagesController@send');
$router->get('/contact',     'ContactController@index');
$router->post('/contact', 'ContactController@send');

// Pages principales
$router->get('/actualites', 'ActualitesController@index');
$router->get('/films',      'FilmsController@index');
$router->get('/series',     'SeriesController@index');
$router->get('/animes',     'AnimesController@index');
$router->get('/critiques',  'CritiquesController@index');

// Notation
$router->get('/notation',       'NotationController@index');
$router->get('/notation-film',  'NotationFilmController@index');
$router->get('/notation-serie', 'NotationSerieController@index');

// Forum
$router->get('/forum',        'ForumController@index');
$router->get('/forum/topic',  'ForumController@show');
$router->get('/forum/new',    'ForumController@newForm');
$router->post('/forum/new',   'ForumController@create');
$router->post('/forum/reply', 'ForumController@reply');

// Authentification
$router->get('/login',    'AuthController@loginForm');
$router->post('/login',   'AuthController@loginProcess');
$router->get('/register', 'AuthController@registerForm');
$router->post('/register','AuthController@registerProcess');
$router->get('/logout',   'AuthController@logout');

// Exemple :
// $router->get('/movies', 'MovieController@index');
// $router->post('/reviews', 'ReviewController@store');
