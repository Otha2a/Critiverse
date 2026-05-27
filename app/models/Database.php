<?php
// Gère la connexion à la base de données (PDO)

class Database {
    private $pdo;

    public function __construct() {
        $config = require __DIR__ . '/../../config/database.php';
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8";
        $this->pdo = new PDO($dsn, $config['user'], $config['password']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function insertContact($name, $email, $message) {
        $stmt = $this->pdo->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $email, $message]);
    }
}