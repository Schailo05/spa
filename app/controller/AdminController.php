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
                set_flash('success', 'Soin ajouté avec succès.');
                header('Location: index.php?action=admin_services');
                exit();
            }
        }

        // Si on demande une suppression (GET)
        if (isset($_GET['delete_id'])) {
            $this->serviceModel->deleteService((int)$_GET['delete_id']);
            set_flash('success', 'Soin supprimé.');
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
            set_flash('success', 'Statut du rendez-vous mis à jour.');
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

    set_flash('success', 'Attributions mises à jour.');
    header('Location: index.php?action=admin_staff');
    exit();
}

// --- NOUVELLE MÉTHODE : Créer/Ajouter un employé ---
    public function addStaff() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        header('Location: index.php?action=login');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email     = trim($_POST['email'] ?? '');
        $password  = $_POST['password'] ?? '';
        $firstName = trim($_POST['first_name'] ?? '');
        $lastName  = trim($_POST['last_name'] ?? '');
        $phone     = trim($_POST['phone'] ?? '');

        if (!empty($email) && !empty($password)) {
            // Hachage sécurisé du mot de passe
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Préparation du tableau de données compatible avec ton UserModel
            $data = [
                'email'      => $email,
                'password'   => $hashedPassword,
                'first_name' => $firstName,
                'last_name'  => $lastName,
                'phone'      => $phone,
                'role'       => 'employe' // On force le rôle à 'employe'
            ];

            // Création de l'utilisateur + profil
            $newUserId = $this->userModel->createUser($data);

            if ($newUserId) {
                set_flash('success', 'Nouvel employé créé avec succès.');
                header('Location: index.php?action=admin_staff');
                exit();
            }
        }
    }

    set_flash('error', 'Échec de la création de l’employé. Veuillez vérifier les informations saisies.');
    header('Location: index.php?action=admin_staff');
    exit();
}

public function updateUser() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        header('Location: index.php?action=login');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userId   = $_POST['id_users'] ?? null;
        $role     = $_POST['role'] ?? 'client';
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        if ($userId) {
            $this->userModel->updateUserStatusAndRole($userId, $role, $isActive);
        }
    }

    set_flash('success', 'Utilisateur mis à jour.');
    header('Location: index.php?action=admin_dashboard');
    exit();
}
public function appointments() {
    // Vérification de la session admin
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        header('Location: index.php?action=login');
        exit();
    }

    // Traitement du changement de statut via URL
    if (isset($_GET['change_status']) && isset($_GET['id'])) {
        $status = $_GET['change_status'];
        $appointmentId = (int)$_GET['id'];

        if (in_array($status, ['confirme', 'annule', 'en attente'])) {
            $this->appointmentModel->updateStatus($appointmentId, $status);
        }

        header('Location: index.php?action=admin_appointments');
        exit();
    }

    $appointments = $this->appointmentModel->getAllAppointments();
    $employees = [];
    if ($this->employeeModel) {
        $employees = $this->employeeModel->getAllEmployees();
    }

    require_once __DIR__ . '/../view/admin/appointments.php';
}


public function showSkillsMatrix() {
    // 1. Récupérer tous les employés
    $employees = $this->userModel->getEmployees();
    
    // 2. Récupérer tous les services/soins
    $services = $this->serviceModel->getAllServices();

    // 3. Récupérer les compétences déjà attribuées (table employee_services)
    $assignedSkills = $this->appointmentModel->getAllEmployeeServices(); 

    // 4. Charger la vue
    require_once __DIR__ . '/../view/admin/skills_assignment.php';
}
}