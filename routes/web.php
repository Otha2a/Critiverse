<?php
// Définition des routes

$router->get('/', 'HomeController@index');
$router->get('/apropos', 'AproposController@index');

// Exemple :
// $router->get('/movies', 'MovieController@index');
// $router->post('/reviews', 'ReviewController@store');