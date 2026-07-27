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

// Protection CSRF utilities
require_once __DIR__ . '/core/csrf.php';
require_once __DIR__ . '/core/flash.php';

// 2. Chargement de la configuration de la base de données ($pdo)
require_once 'config/database.php'; 

// 3. Chargement des Modèles, Services et Contrôleurs
require_once 'app/models/userModels.php';
require_once 'services/MailService.php';
require_once 'app/models/serviceModels.php';
require_once 'app/models/appointmentModels.php';
require_once 'app/models/employeeModels.php';
require_once 'services/PaymentService.php';
require_once 'app/controller/AuthController.php';
require_once 'app/controller/AdminController.php';
require_once 'app/controller/BookingController.php';
require_once 'app/controller/PaymentController.php';

// 4. Instanciation des objets
$userModel = new UserModel($pdo);
$mailService = new MailService();
$authController = new AuthController($userModel, $mailService);

$serviceModels = new ServiceModels($pdo);
$appointmentModel = new AppointmentModel($pdo);
$employeeModel = new EmployeeModel($pdo);
$paymentService = new PaymentService();

$adminController = new AdminController($userModel, $serviceModels, $appointmentModel, $employeeModel);
$bookingController = new BookingController($serviceModels, $employeeModel, $appointmentModel);
$paymentController = new PaymentController($paymentService, $appointmentModel, $serviceModels, $employeeModel);

$action = $_GET['action'] ?? 'register';

// CSRF: vérification globale pour toutes les requêtes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!verify_csrf_token($token)) {
        http_response_code(403);
        die('Jeton CSRF invalide. Recharger la page et réessayer.');
    }
}

switch ($action) {
    case 'register':
        $authController->register();
        break;

    case 'verify_code':
        $authController->verifyCode(); 
        break;

    case 'forgot_password':
        $authController->forgotPassword();
        break;

    case 'reset_password':
        $authController->resetPassword();
        break;

    case 'login':
        $authController->login();
        break;

    case 'logout':
        $authController->logout();
        break;

    case 'client_dashboard':
        header('Location: index.php?action=dashboard');
        exit();
        break;

    case 'dashboard':
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit();
        }

        $userId = $_SESSION['user']['id_users'] ?? $_SESSION['user']['id'] ?? $_SESSION['user']['id_user'] ?? null;
        $userAppointments = [];
        if ($userId && method_exists($appointmentModel, 'getAppointmentsByUserId')) {
            $userAppointments = $appointmentModel->getAppointmentsByUserId($userId);
        }

        include_once 'app/view/dashboard.php'; 
        break;

    // ------------------------------------------------------------------
    // 🧑‍⚕️ PLANNING / ESPACE PRATICIEN ET EMPLOYÉ
    // ------------------------------------------------------------------
    case 'staff_dashboard':
        if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] !== 'employe' && $_SESSION['user']['role'] !== 'admin')) {
            header('HTTP/1.1 403 Forbidden');
            echo "Accès interdit. Réservé au personnel.";
            exit();
        }

        // Récupération de l'ID de l'employé connecté
        $employeeId = $_SESSION['user']['id_users'] ?? $_SESSION['user']['id'] ?? $_SESSION['user']['id_user'] ?? null;
        $appointments = [];

        if ($employeeId) {
            // Utilise la méthode disponible dans le modèle (soit getAppointmentsByEmployeeId, soit getAppointmentsByEmployee)
            if (method_exists($appointmentModel, 'getAppointmentsByEmployeeId')) {
                $appointments = $appointmentModel->getAppointmentsByEmployeeId($employeeId);
            } elseif (method_exists($appointmentModel, 'getAppointmentsByEmployee')) {
                $appointments = $appointmentModel->getAppointmentsByEmployee($employeeId);
            }
        }

        include_once 'app/view/admin/staff.php';
        break;

    // ------------------------------------------------------------------
    // ⚙️ DASHBOARD ADMIN ET GESTION UTILISATEURS
    // ------------------------------------------------------------------
    case 'admin_dashboard':
        $adminController->dashboard();
        break;

    case 'admin_skills':
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?action=login');
            exit();
        }
        $adminController->showSkillsMatrix();
        break;

    case 'update_user':
        // Utilise la méthode centralisée du contrôleur Admin
        if (method_exists($adminController, 'updateUser')) {
            $adminController->updateUser();
        } else {
            if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
                header('HTTP/1.1 403 Forbidden');
                exit("Accès interdit.");
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $userId = $_POST['id_users'] ?? '';
                $newRole = $_POST['role'] ?? '';
                $isActive = isset($_POST['is_active']) ? 1 : 0;

                if (!empty($userId) && in_array($newRole, ['client', 'employe', 'admin'])) {
                    if (method_exists($userModel, 'updateUserRole')) $userModel->updateUserRole($userId, $newRole);
                    if (method_exists($userModel, 'updateUserStatus')) $userModel->updateUserStatus($userId, $isActive);
                }
            }
            header('Location: index.php?action=admin_dashboard');
            exit();
        }
        break;

    case 'add_staff':
        $adminController->addStaff();
        break;

    case 'admin_services':
        $adminController->manageServices();
        break;

    case 'admin_appointments':
        $adminController->appointments();
        break;

    case 'admin_staff':
        $adminController->manageStaff();
        break;

    case 'update_staff_services':
        $adminController->updateStaffServices();
        break;

    // ------------------------------------------------------------------
    // 🌿 PARCOURS DE RÉSERVATION CLIENT
    // ------------------------------------------------------------------
    case 'booking':
        $bookingController->showBookingForm();
        break;

    case 'get_employees_by_service':
        $bookingController->getEmployeesByService();
        break;

    case 'save_booking':
        $bookingController->saveBooking();
        break;

    case 'payment':
        $paymentController->showPaymentForm();
        break;

    case 'process_payment':
        $paymentController->processPayment();
        break;

    case 'payment_success':
        $paymentController->paymentSuccess();
        break;

    case 'assign_employee':
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('HTTP/1.1 403 Forbidden');
            exit("Accès interdit.");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $appointmentId = $_POST['id_appointment'] ?? null;
            $employeeId    = $_POST['id_employee'] ?? null;

            if ($appointmentId && $employeeId) {
                $appointmentModel->assignEmployeeToAppointment($appointmentId, $employeeId);
                set_flash('success', 'Praticien attribué au rendez-vous avec succès.');
            }
        }

        header('Location: index.php?action=admin_appointments');
        exit();
        break;

    // Dans index.php (ou AdminController.php)
    case 'save_skills_assignment':
    // 1. Sécurité : Vérifier que c'est bien l'admin
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        header('Location: index.php?action=login');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $skills = $_POST['skills'] ?? []; // Tableau [id_employee => [id_service1, id_service2...]]

        // On réinitialise les compétences pour mettre à jour
        $appointmentModel->clearAllEmployeeServices();

        // On enregistre les nouvelles associations
        foreach ($skills as $employeeId => $serviceIds) {
            foreach ($serviceIds as $serviceId) {
                $appointmentModel->addEmployeeService($employeeId, $serviceId);
            }
        }
    }

    // Redirection vers le dashboard admin avec message de succès
    set_flash('success', 'Les compétences du personnel ont été mises à jour.');
    header('Location: index.php?action=admin_skills');
    exit();
    break;

    default:
        http_response_code(404);
        echo "Page non trouvée";
        break;
}