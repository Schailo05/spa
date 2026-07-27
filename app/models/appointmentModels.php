<?php
// app/models/appointmentModels.php

class AppointmentModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    private function normalizeStatus($status) {
        $status = strtolower(trim((string) $status));

        switch ($status) {
            case 'confirme':
            case 'confirmé':
            case 'confirmed':
            case 'confirm':
            case 'ok':
                return 'confirmé';
            case 'annule':
            case 'annulé':
            case 'cancelled':
            case 'canceled':
                return 'annulé';
            case 'pending':
            case 'en attente':
            case 'en_attente':
            case 'attente':
                return 'en attente';
            default:
                return 'en attente';
        }
    }

    private function normalizeStatusForRows(array $rows): array {
        foreach ($rows as &$row) {
            if (isset($row['status'])) {
                $row['status'] = $this->normalizeStatus($row['status']);
            }
        }

        return $rows;
    }

    /**
     * 1. Récupérer TOUS les rendez-vous pour le tableau de bord Admin
     */
    public function getAllAppointments() {
        $sql = "SELECT 
                    a.id_appointments,
                    a.id_employee,
                    a.appointment_date,
                    a.status,
                    s.name AS service_name,
                    s.duration,
                    s.price,
                    c_u.email,
                    c_p.first_name AS client_firstname,
                    c_p.last_name AS client_lastname,
                    e_p.first_name AS employee_firstname,
                    e_p.last_name AS employee_lastname
                FROM appointments a
                INNER JOIN services s ON a.id_services = s.id_services
                INNER JOIN users c_u ON a.id_users = c_u.id_users
                LEFT JOIN users_profiles c_p ON c_u.id_users = c_p.id_users
                LEFT JOIN users u_emp ON a.id_employee = u_emp.id_users
                LEFT JOIN users_profiles e_p ON u_emp.id_users = e_p.id_users
                ORDER BY a.appointment_date DESC";

        $stmt = $this->pdo->query($sql);
        return $this->normalizeStatusForRows($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    /**
     * 2. Récupérer les rendez-vous d'un employé / praticien spécifique
     */
    public function getAppointmentsByEmployee($employeeId) {
        $sql = "SELECT 
                    a.id_appointments,
                    a.appointment_date,
                    a.status,
                    s.name AS service_name,
                    s.duration,
                    s.price,
                    c_u.email AS client_email,
                    c_p.first_name AS client_firstname,
                    c_p.last_name AS client_lastname
                FROM appointments a
                INNER JOIN services s ON a.id_services = s.id_services
                INNER JOIN users c_u ON a.id_users = c_u.id_users
                LEFT JOIN users_profiles c_p ON c_u.id_users = c_p.id_users
                WHERE a.id_employee = :employee_id
                ORDER BY a.appointment_date ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':employee_id' => $employeeId]);
        return $this->normalizeStatusForRows($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    /**
     * Alias utilisé dans index.php (pour staff_dashboard)
     */
    public function getAppointmentsByEmployeeId($employeeId) {
        return $this->getAppointmentsByEmployee($employeeId);
    }

    /**
     * 3. Récupérer les rendez-vous d'un client (Espace client / dashboard)
     */
    public function getAppointmentsByUserId($userId) {
        $sql = "SELECT 
                    a.id_appointments,
                    a.appointment_date,
                    a.status,
                    s.name AS service_name,
                    s.duration,
                    s.price,
                    e_p.first_name AS employee_firstname,
                    e_p.last_name AS employee_lastname
                FROM appointments a
                INNER JOIN services s ON a.id_services = s.id_services
                LEFT JOIN users u_emp ON a.id_employee = u_emp.id_users
                LEFT JOIN users_profiles e_p ON u_emp.id_users = e_p.id_users
                WHERE a.id_users = :user_id
                ORDER BY a.appointment_date DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        return $this->normalizeStatusForRows($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    /**
     * 4. Modifier le statut d'un rendez-vous (confirme, annule, etc.)
     */
    public function updateStatus($appointmentId, $status) {
        $normalizedStatus = $this->normalizeStatus($status);
        $sql = "UPDATE appointments SET status = :status WHERE id_appointments = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':status' => $normalizedStatus,
            ':id'     => $appointmentId
        ]);
    }

    /**
     * 5. Récupérer les employés liés à un service spécifique
     */
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

    /**
     * 6. Enregistrer un nouveau rendez-vous
     */
    public function isEmployeeAvailable($employeeId, $appointmentDateTime) {
        $sql = "SELECT COUNT(*) FROM appointments 
                WHERE id_employee = :id_employee 
                  AND appointment_date = :appointment_date 
                  AND status NOT IN ('annulé', 'annule')";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id_employee'      => $employeeId,
            'appointment_date' => $appointmentDateTime
        ]);
        return $stmt->fetchColumn() == 0;
    }

    public function hasUserAppointmentAt($userId, $appointmentDateTime) {
        $sql = "SELECT COUNT(*) FROM appointments 
                WHERE id_users = :id_users 
                  AND appointment_date = :appointment_date 
                  AND status NOT IN ('annulé', 'annule')";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id_users'         => $userId,
            'appointment_date' => $appointmentDateTime
        ]);
        return $stmt->fetchColumn() > 0;
    }

    public function createAppointment($data) {
        $sql = "INSERT INTO appointments (id_users, id_services, id_employee, appointment_date, status) 
                VALUES (:id_users, :id_services, :id_employee, :appointment_date, :status)";
                
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id_users'         => $data['id_users'],
            'id_services'      => $data['id_services'],
            'id_employee'      => $data['id_employee'],
            'appointment_date' => $data['appointment_date'],
            'status'           => $data['status'] ?? 'en attente'
        ]);
    }

    public function assignEmployeeToAppointment($appointmentId, $employeeId) {
    $sql = "UPDATE appointments 
            SET id_employee = :id_employee 
            WHERE id_appointments = :id_appointments";
            
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([
        ':id_employee'     => $employeeId,
        ':id_appointments' => $appointmentId
    ]);
}

// Efface la table pour tout réécrire proprement lors de la sauvegarde
public function clearAllEmployeeServices() {
    $sql = "DELETE FROM employee_services";
    return $this->pdo->exec($sql);
}

// Associe un soin spécifique à un employé
public function addEmployeeService($employeeId, $serviceId) {
    $sql = "INSERT INTO employee_services (id_users, id_services) 
            VALUES (:id_employee, :id_service)";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([
        ':id_employee' => $employeeId,
        ':id_service'  => $serviceId
    ]);
}
}