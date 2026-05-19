<?php

// Pages principales
$router->get('/', 'HomeController@index');
$router->get('/animes',        'AnimesController@index');
$router->get('/films',         'FilmsController@index');
$router->get('/series',        'SeriesController@index');
$router->get('/notation',      'NotationController@index');
$router->get('/notation-film', 'NotationFilmController@index');
$router->get('/notation-serie','NotationSerieController@index');
$router->get('/critiques',     'CritiquesController@index');
$router->get('/actualites',    'ActualitesController@index');
$router->get('/apropos',       'AproposController@index');
$router->get('/contact',       'ContactController@index');

// Authentification
$router->get('/login',    'AuthController@loginForm');
$router->post('/login',   'AuthController@loginProcess');
$router->get('/register', 'AuthController@registerForm');
$router->post('/register','AuthController@registerProcess');
$router->get('/logout',   'AuthController@logout');
