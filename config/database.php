<?php
// config/database.php

$host = $_ENV['DB_HOST'] ?? null;
$db   = $_ENV['DB_NAME'] ?? null;
$user = $_ENV['DB_USER'] ?? null;
$pass = $_ENV['DB_PASS'] ?? null;

// Petite sécurité : si une variable est manquante, on lève une alerte claire
if (!$host || !$db || !$user) {
    die("Erreur : Les variables d'environnement de la base de données ne sont pas chargées.");
}

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    // Configuration de PDO avec des options de sécurité strictes
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    $pdo = new PDO($dsn, $user, $pass, $options);
    
} catch (\PDOException $e) {
    // En développement, on affiche le vrai message pour comprendre le problème
    die("Erreur critique de connexion à la base de données : " . $e->getMessage());
}