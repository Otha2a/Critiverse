<?php
session_start();

require_once __DIR__ . '/../app/core/Router.php';
require_once __DIR__ . '/../app/core/Controller.php';

// Controllers
require_once __DIR__ . '/../app/models/Database.php';
require_once __DIR__ . '/../app/controllers/HomeController.php';
require_once __DIR__ . '/../app/controllers/AproposController.php';
require_once __DIR__ . '/../app/controllers/MentionsController.php';
require_once __DIR__ . '/../app/controllers/FaqController.php';
require_once __DIR__ . '/../app/controllers/AbonnementController.php';
require_once __DIR__ . '/../app/controllers/ProfileController.php';
require_once __DIR__ . '/../app/controllers/MessagesController.php';
require_once __DIR__ . '/../app/models/Message.php';
require_once __DIR__ . '/../app/controllers/ContactController.php';
require_once __DIR__ . '/../app/controllers/AnimesController.php';
require_once __DIR__ . '/../app/controllers/FilmsController.php';
require_once __DIR__ . '/../app/controllers/SeriesController.php';
require_once __DIR__ . '/../app/controllers/NotationController.php';
require_once __DIR__ . '/../app/controllers/NotationFilmController.php';
require_once __DIR__ . '/../app/controllers/NotationSerieController.php';
require_once __DIR__ . '/../app/controllers/CritiquesController.php';
require_once __DIR__ . '/../app/controllers/ActualitesController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/ForumController.php';
require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/controllers/UserController.php';
require_once __DIR__ . '/../app/controllers/WatchlistController.php';

// URL demandée
$uri = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$basePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$basePath = $basePath === '/' ? '' : rtrim($basePath, '/');
if ($basePath !== '' && strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}

if ($uri === '' || $uri === '/index.php') {
    $uri = '/';
}

$router = new Router($_SERVER['REQUEST_METHOD'], $uri);

require_once __DIR__ . '/../routes/web.php';

$router->dispatch();
