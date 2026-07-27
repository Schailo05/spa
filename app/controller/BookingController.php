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
        $serviceAvailability = [];
        foreach ($services as $service) {
            $serviceId = $service['id_services'] ?? null;
            if ($serviceId !== null) {
                $serviceAvailability[$serviceId] = count($this->employeeModel->getEmployeesByServiceId($serviceId));
            }
        }

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
    public function saveBooking() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $serviceId  = isset($_POST['id_services']) ? (int) $_POST['id_services'] : 0;
            // employee IDs are stored as UUID/string in the users table — do not cast to int
            $employeeId = isset($_POST['id_employee']) ? trim($_POST['id_employee']) : '';
            $date       = trim($_POST['appointment_date'] ?? '');
            $time       = trim($_POST['appointment_time'] ?? '');
            $userId     = $_SESSION['user']['id_users'] ?? $_SESSION['user']['id'] ?? null;

            $_SESSION['booking_old'] = [
                'id_services'  => $serviceId,
                'id_employee'  => $employeeId,
                'appointment_date' => $date,
                'appointment_time' => $time,
            ];

            if (!$serviceId || empty($employeeId) || !$date || !$time || !$userId) {
                $this->redirectWithError('missing_fields');
            }

            $appointmentDateTime = DateTime::createFromFormat('Y-m-d H:i', $date . ' ' . $time);
            $now = new DateTime();

            if (!$appointmentDateTime) {
                $this->redirectWithError('invalid_datetime');
            }

            if ($appointmentDateTime <= $now) {
                $this->redirectWithError('past_datetime');
            }

            $service = $this->serviceModel->getServiceById($serviceId);
            $employee = $this->employeeModel->getEmployeeById($employeeId);

            if (!$service) {
                $this->redirectWithError('invalid_service');
            }

            if (!$employee || !in_array($employee['role'] ?? '', ['employe', 'employee'], true) || (int)($employee['is_active'] ?? 0) !== 1) {
                $this->redirectWithError('invalid_employee');
            }

            if (!$this->employeeModel->isEmployeeQualifiedForService($employeeId, $serviceId)) {
                $this->redirectWithError('employee_not_qualified');
            }

            if (empty($service['price']) || !is_numeric($service['price'])) {
                $this->redirectWithError('invalid_service');
            }

            if (!$this->appointmentModel->isEmployeeAvailable($employeeId, $appointmentDateTime->format('Y-m-d H:i:00'))) {
                $this->redirectWithError('employee_unavailable');
            }

            if ($this->appointmentModel->hasUserAppointmentAt($userId, $appointmentDateTime->format('Y-m-d H:i:00'))) {
                $this->redirectWithError('user_conflict');
            }

            $servicePrice = (float) $service['price'];

            $_SESSION['pending_booking'] = [
                'id_services'         => $serviceId,
                'service_name'        => $service['name'],
                'service_price'       => $servicePrice,
                'id_employee'         => $employeeId,
                'employee_name'       => trim(($employee['first_name'] ?? '') . ' ' . ($employee['last_name'] ?? '')),
                'appointment_date'    => $appointmentDateTime->format('Y-m-d'),
                'appointment_time'    => $appointmentDateTime->format('H:i'),
                'appointment_datetime'=> $appointmentDateTime->format('Y-m-d H:i:s'),
                'user_id'             => $userId,
            ];

            header('Location: index.php?action=payment');
            exit();
        }

        $this->redirectWithError('validation');
    }

    private function redirectWithError(string $code): void {
        $messages = [
            'missing_fields'         => 'Veuillez remplir tous les champs.',
            'invalid_datetime'       => 'Le format de la date ou de l’heure est invalide.',
            'past_datetime'          => 'La date ou l’heure choisie doit être dans le futur.',
            'invalid_service'        => 'Le soin sélectionné est invalide.',
            'invalid_employee'       => 'Le praticien sélectionné est invalide ou inactif.',
            'employee_not_qualified' => 'Ce praticien ne propose pas ce soin.',
            'employee_unavailable'   => 'Le praticien n’est pas disponible à ce créneau.',
            'user_conflict'          => 'Vous avez déjà un rendez-vous à cette heure.',
            'save_failed'            => 'Impossible d’enregistrer le rendez-vous. Réessayez plus tard.',
            'validation'             => 'Données invalides. Veuillez vérifier votre sélection.'
        ];

        $message = $messages[$code] ?? 'Une erreur est survenue. Veuillez réessayer.';
        set_flash('error', $message);
        header('Location: index.php?action=booking');
        exit();
    }
}