<?php
// app/models/appointmentModels.php

class AppointmentModel {
    private $pdo; // Aligné sur ton code

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // 1. Récupérer TOUS les rendez-vous (Méthode d'origine conservée intacte !)
    public function getAllAppointments() {
        $sql = "SELECT a.id_appointments, a.appointment_date, a.status,
                       s.name AS service_name, s.price, s.duration,
                       p.first_name, p.last_name, u.email
                FROM appointments a
                JOIN services s ON a.id_services = s.id_services
                JOIN users u ON a.id_users = u.id_users
                LEFT JOIN users_profiles p ON u.id_users = p.id_users
                ORDER BY a.appointment_date ASC";
        
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. Changer le statut d'un rendez-vous (Méthode d'origine conservée intacte !)
    public function updateStatus($id, $status) {
        $allowedStatus = ['en_attente', 'confirme', 'annule'];
        
        if (!in_array($status, $allowedStatus)) {
            $status = 'en_attente';
        }

        $sql = "UPDATE appointments SET status = :status WHERE id_appointments = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':status' => $status,
            ':id'     => (int)$id
        ]);
    }

    // --- 🌟 NOUVELLES MÉTHODES ALIGNÉES SUR TA STRUCTURE DE PROJET 🌟 ---

    // Récupérer les employés liés à un service spécifique (via leurs profils)
    public function getEmployeesByService($serviceId) {
        $sql = "SELECT u.id_users, p.first_name, p.last_name 
                FROM users u
                JOIN employee_services es ON u.id_users = es.id_users
                LEFT JOIN users_profiles p ON u.id_users = p.id_users
                WHERE es.id_services = :id_services AND u.is_active = 1";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_services' => (int)$serviceId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Enregistrer un nouveau rendez-vous (en combinant Date + Heure pour matcher ton champ appointment_date)
    public function createAppointment($userId, $employeeId, $serviceId, $appointmentDate, $status = 'confirmé') {
    $sql = "INSERT INTO appointments (id_users, id_employee, id_services, appointment_date, status) 
            VALUES (:id_users, :id_employee, :id_services, :appointment_date, :status)";
            
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([
        ':id_users'         => $userId,
        ':id_employee'      => $employeeId,
        ':id_services'      => $serviceId,
        ':appointment_date' => $appointmentDate,
        ':status'           => $status
    ]);
}
}