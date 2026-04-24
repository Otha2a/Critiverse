<?php
// Front Controller

require_once __DIR__ . '/../app/core/Router.php';
require_once __DIR__ . '/../app/core/Controller.php';
require_once __DIR__ . '/../app/controllers/HomeController.php';

// URL demandée par l’utilisateur
$uri = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Supprimer le segment de base si le projet n’est pas à la racine du serveur
$basePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$basePath = $basePath === '/' ? '' : rtrim($basePath, '/');
if ($basePath !== '' && strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}

if ($uri === '' || $uri === '/index.php') {
    $uri = '/';
}

$router = new Router($_SERVER['REQUEST_METHOD'], $uri);

// Définir les routes de l’application
require_once __DIR__ . '/../routes/web.php';

$router->dispatch();