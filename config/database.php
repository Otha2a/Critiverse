<?php
// Configuration bdd
define('DB_HOST', '127.0.0.1');     // serveur MySQL local
define('DB_NAME', 'critiverse');    // nom bdd
define('DB_USER', 'root');          // utilisateur MySQL
define('DB_PASS', '');              // mdp vide car XAMPP
define('DB_CHARSET', 'utf8mb4');    // encodage de base

// Fonction permettant la connexion à une bdd
function getDatabaseConnection(): PDO
{
    $dsn = 
    'mysql:host=' . DB_HOST . 
    ';dbname=' . DB_NAME . 
    ';charset=' . DB_CHARSET;

    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    } catch (PDOException $exception) {
        if (defined('DEBUG_MODE') && DEBUG_MODE) {
            throw $exception;
        }
        die('Erreur de connexion à la base de données.');
    }

    return $pdo;
}
