<?php
// index.php

// Chargement de .env
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue; // Ignore les commentaires
        list($name, $value) = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value);
    }
}

// 1. Démarrage de la session une seule fois pour toute l'application
session_start();

// 2. Chargement de la configuration de la base de données ($pdo)
require_once 'config/database.php'; 

// 3. Chargement des Modèles, Services et Contrôleurs
require_once 'app/models/userModels.php';
require_once 'services/MailService.php';
require_once 'app/controller/AuthController.php';
require_once 'app/models/serviceModels.php';
require_once 'app/controller/AdminController.php';
require_once 'app/models/appointmentModels.php';
require_once 'app/models/employeeModels.php';
require_once 'app/controller/BookingController.php';

// 4. Instanciation des objets
$userModel = new UserModel($pdo);
$mailService = new MailService();
$authController = new AuthController($userModel, $mailService);

$serviceModels = new ServiceModels($pdo);
$appointmentModel = new AppointmentModel($pdo);
$employeeModel = new EmployeeModel($pdo);

$adminController = new AdminController($userModel, $serviceModels, $appointmentModel, $employeeModel);
$bookingController = new BookingController($serviceModels, $employeeModel, $appointmentModel);

// 5. Le Routeur (Action par défaut : register)
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
        // SÉCURITÉ CLIENT : Vérification de connexion
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit();
        }
        include_once 'app/view/dashboard.php'; 
        break;

    case 'admin_dashboard':
        $adminController->dashboard();
        break;

    case 'update_user':
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('HTTP/1.1 403 Forbidden');
            exit("Accès interdit.");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['id_users'] ?? '';
            $newRole = $_POST['role'] ?? '';
            $isActive = isset($_POST['is_active']) ? 1 : 0;

            if (!empty($userId) && in_array($newRole, ['client', 'employe', 'admin'])) {
                $userModel->updateUserRole($userId, $newRole);
                $userModel->updateUserStatus($userId, $isActive);
            }
        }
        
        header('Location: index.php?action=admin_dashboard');
        exit();
        break;

    case 'staff_dashboard':
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'employe') {
            header('HTTP/1.1 403 Forbidden');
            echo "Accès interdit. Réservé aux employés.";
            exit();
        }

        // Récupération des RDV de l'employé connecté
        $employeeId = $_SESSION['user']['id_users'] ?? $_SESSION['user']['id'] ?? null;
        $appointments = [];
        if ($employeeId && method_exists($appointmentModel, 'getAppointmentsByEmployeeId')) {
            $appointments = $appointmentModel->getAppointmentsByEmployeeId($employeeId);
        }

        include_once 'app/view/admin/staff.php';
        break;

    case 'admin_services':
        $adminController->manageServices();
        break;

    case 'admin_appointments':
        $adminController->manageAppointments();
        break;

    case 'admin_staff':
        $adminController->manageStaff();
        break;

    case 'update_staff_services':
        $adminController->updateStaffServices();
        break;

    // 🌿 PARCOURS DE RÉSERVATION CLIENT
    case 'booking':
        $bookingController->showBookingForm();
        break;

    case 'get_employees_by_service':
        $bookingController->getEmployeesByService();
        break;

    case 'save_booking':
        $bookingController->saveBooking();
        break;

    default:
        http_response_code(404);
        echo "Page non trouvée";
        break;
}