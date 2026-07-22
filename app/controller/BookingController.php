<?php
// app/controller/BookingController.php

class BookingController {
    private $serviceModel;
    private $employeeModel;
    private $appointmentModel;

    public function __construct($serviceModel, $employeeModel, $appointmentModel) {
        $this->serviceModel = $serviceModel;
        $this->employeeModel = $employeeModel;
        $this->appointmentModel = $appointmentModel;
    }

    // Afficher le formulaire de réservation
    public function showBookingForm() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit();
        }

        $services = $this->serviceModel->getAllServices();
        include_once 'app/view/client/booking.php';
    }

    // API AJAX : Renvoie la liste des employés maîtrisant le soin sélectionné
    public function getEmployeesByService() {
        header('Content-Type: application/json');

        $serviceId = $_GET['service_id'] ?? null;
        if (!$serviceId) {
            echo json_encode([]);
            exit();
        }

        // On récupère les employés qualifiés
        $employees = $this->employeeModel->getEmployeesByServiceId($serviceId);
        echo json_encode($employees);
        exit();
    }

    // Traitement de la réservation
   // app/controller/BookingController.php

public function saveBooking() {
    if (!isset($_SESSION['user']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: index.php?action=booking');
        exit();
    }

    // 🟢 FIX 1 : On vérifie la clé d'ID utilisateur de la session
    $userId = $_SESSION['user']['id_users'] ?? $_SESSION['user']['id'] ?? null;
    
    $serviceId  = $_POST['id_services'] ?? null;
    $employeeId = $_POST['id_employee'] ?? null;
    $date       = $_POST['appointment_date'] ?? null;
    $time       = $_POST['appointment_time'] ?? null;

    if ($userId && $serviceId && $employeeId && $date && $time) {
        $appointmentDateTime = $date . ' ' . $time . ':00';
        
        // 🟢 FIX 2 : On passe 5 arguments (avec le statut par défaut)
        $status = 'confirmé'; // ou 'en_attente' selon tes besoins
        
        $this->appointmentModel->createAppointment(
            $userId, 
            $employeeId, 
            $serviceId, 
            $appointmentDateTime,
            $status // 5ème argument ajouté ici
        );

        header('Location: index.php?action=dashboard&success=1');
        exit();
    }

    header('Location: index.php?action=booking&error=1');
    exit();
}
}