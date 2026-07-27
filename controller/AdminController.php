<?php
// app/controller/AdminController.php

class AdminController {
    private $userModel;
    private $serviceModel;
    private $appointmentModel;
    private $employeeModel;

    public function __construct($userModel, $serviceModel, $appointmentModel = null, $employeeModel = null) {
        $this->userModel = $userModel;
        $this->serviceModel = $serviceModel;
        $this->appointmentModel = $appointmentModel; 
        $this->employeeModel = $employeeModel;
    }

    /// --- ACCÈS DIRECT AU DASHBOARD CENTRALISÉ FUSIONNÉ ---
    public function dashboard() {
        // Sécurité admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?action=login');
            exit();
        }

        // 1. Récupération des données pour alimenter les compteurs
        $allServices = $this->serviceModel->getAllServices();
        $totalServices = count($allServices);

        $allAppointments = [];
        if (method_exists($this->appointmentModel, 'getAllAppointments')) {
            $allAppointments = $this->appointmentModel->getAllAppointments();
        }
        $totalAppointments = count($allAppointments);

        $allEmployees = $this->employeeModel->getAllEmployees();
        $totalEmployees = count($allEmployees);

        // 2. RÉCUPÉRATION DE TOUS LES UTILISATEURS (Pour ton tableau de gestion des rôles)
        $users = $this->userModel->getAllUsers();

        // On charge la vue centrale
        include_once 'app/view/admin/dashboard.php';
    }
    // --- OPTION A : Gérer l'affichage du catalogue de soins ---
    public function manageServices() {
        // Sécurité admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?action=login');
            exit();
        }

        // Si on reçoit un formulaire d'ajout (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_service'])) {
            $name        = htmlspecialchars(trim($_POST['name']));
            $description = htmlspecialchars(trim($_POST['description']));
            $duration    = (int)$_POST['duration'];
            $price       = (float)$_POST['price'];

            if (!empty($name) && $duration > 0 && $price > 0) {
                $this->serviceModel->addService($name, $description, $duration, $price);
                header('Location: index.php?action=admin_services');
                exit();
            }
        }

        // Si on demande une suppression (GET)
        if (isset($_GET['delete_id'])) {
            $this->serviceModel->deleteService((int)$_GET['delete_id']);
            header('Location: index.php?action=admin_services');
            exit();
        }

        // On récupère les soins pour la vue
        $services = $this->serviceModel->getAllServices();
        include_once 'app/view/admin/services.php';
    }

    // --- OPTION B : Gérer le planning des rendez-vous ---
    public function manageAppointments() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?action=login');
            exit();
        }

        // Si l'admin change le statut d'un rendez-vous (GET)
        if (isset($_GET['change_status']) && isset($_GET['id'])) {
            $this->appointmentModel->updateStatus($_GET['id'], $_GET['change_status']);
            header('Location: index.php?action=admin_appointments');
            exit();
        }

        $appointments = $this->appointmentModel->getAllAppointments();
        include_once 'app/view/admin/appointments.php';
    }

    // --- OPTION C : Gérer l'équipe et les spécialisations ---
   public function manageStaff() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        header('Location: index.php?action=login');
        exit();
    }

    $services = $this->serviceModel->getAllServices();
    $employees = $this->employeeModel->getAllEmployees();

    $employeeServices = [];
    foreach ($employees as $emp) {
        $employeeServices[$emp['id_users']] = $this->employeeModel->getEmployeeServices($emp['id_users']);
    }

    include_once 'app/view/admin/staff.php';
}

public function updateStaffServices() {
    // Sécurité Admin
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        header('Location: index.php?action=login');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $staffServices = $_POST['staff_services'] ?? [];

        // Récupérer tous les employés
        $employees = $this->employeeModel->getAllEmployees();

        foreach ($employees as $emp) {
            $empId = $emp['id_users'];
            // Si des cases ont été cochées pour cet employé, on les prend, sinon tableau vide
            $selectedServices = $staffServices[$empId] ?? [];
            
            // Mise à jour via le modèle
            $this->employeeModel->updateEmployeeServices($empId, $selectedServices);
        }
    }

    header('Location: index.php?action=admin_staff');
    exit();
}
}