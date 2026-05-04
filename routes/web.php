<?php
// Définition des routes

$router->get('/', 'HomeController@index');
$router->get('/apropos', 'AproposController@index');
$router->get('/contact', 'ContactController@index');

// Exemple :
// $router->get('/movies', 'MovieController@index');
// $router->post('/reviews', 'ReviewController@store');
