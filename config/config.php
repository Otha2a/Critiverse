<?php
// Variables utilisées partout dans le site

// Infos site web
define('SITE_NAME', 'Critiverse');                                              // Nom 
define('SITE_DESCRIPTION', 'Plateforme de critiques films, séries et animes');  // Description
define('SITE_URL', 'http://localhost/website');                                 // URL

// Chemin d'accès
define('ROOT_PATH', dirname(dirname(__FILE__)));                                // Dossier racine
define('APP_PATH', ROOT_PATH . '/app');                                         // Application
define('VIEWS_PATH', APP_PATH . '/views');                                      // Affichage
define('CONTROLLERS_PATH', APP_PATH . '/controllers');                          // Contrôleurs
define('MODELS_PATH', APP_PATH . '/models');                                    // Modèles
define('PUBLIC_PATH', ROOT_PATH . '/public');                                   // Publique
define('ASSETS_PATH', '/website/public/assets');                                // Images/CSS/JS
define('UPLOADS_PATH', PUBLIC_PATH . '/uploads');                               // Publications

// Débug
define('DEBUG_MODE', true);                             // True en développement, False en production
define('SHOW_ERRORS', DEBUG_MODE);                      // Variable reliée

// Session
define('SESSION_TIMEOUT', 3600);                        // Durée en secondes avant de déconnecter un user
define('SESSION_NAME', 'critiverse_session');           // Nom de session pour cookies

// TMDB API (themoviedb.org - gratuit)
// Pour obtenir une clé : https://www.themoviedb.org/settings/api
define('TMDB_API_KEY', 'VOTRE_CLE_API_TMDB');
define('TMDB_BASE_URL', 'https://api.themoviedb.org/3');
define('TMDB_IMG_BASE', 'https://image.tmdb.org/t/p/w500');