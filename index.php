<?php
// index.php

//chargement de .env
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue; // Ignore les commentaires
        list($name, $value) = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value);
    }
}

// 1. On démarre la session UNE SEULE FOIS ici pour toute l'application
session_start();

// 2. On charge le fichier de configuration qui crée la variable $pdo
// (Ajuste le chemin vers ton fichier de BDD s'il est différent)
require_once 'config/database.php'; 

// 3. On charge les Modèles, Services et Contrôleurs
require_once 'app/models/userModels.php';
require_once 'services/MailService.php';
require_once 'app/controller/AuthController.php';

// 4. Instanciation (Maintenant $pdo existe et est bien reconnu !)
$userModel = new UserModel($pdo);
$mailService = new MailService();
$authController = new AuthController($userModel, $mailService);

// 5. Le Routeur
$action = $_GET['action'] ?? 'register';

switch ($action) {
    case 'register':
        $authController->register();
        break;

    case 'verify_code':
        $authController->verifyCode(); 
        break;

        case 'login':
        $authController->login();
        break;

        case 'logout':
        $authController->logout();
        break;

        case 'dashboard':
        // Sécurité : On vérifie si l'utilisateur est bien connecté
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit();
        }
        // Si oui, on charge la vue du tableau de bord
        include_once 'app/view/dashboard.php'; 
        break;

    default:
        http_response_code(404);
        echo "Page non trouvée";
        break;
}