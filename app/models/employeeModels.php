<?php
class EmployeeModel {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    // 1. Récupère tous les employés avec leur profil
    public function getAllEmployees() {
        $sql = "SELECT u.id_users, u.email, p.first_name, p.last_name 
                FROM users u
                LEFT JOIN users_profiles p ON u.id_users = p.id_users
                WHERE u.role IN ('employe', 'employee')";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEmployeeById($employeeId) {
        $sql = "SELECT u.id_users, u.email, u.role, u.is_active, p.first_name, p.last_name 
                FROM users u
                LEFT JOIN users_profiles p ON u.id_users = p.id_users
                WHERE u.id_users = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $employeeId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function isEmployeeQualifiedForService($employeeId, $serviceId) {
        $sql = "SELECT COUNT(*) FROM employee_services WHERE id_users = :id_users AND id_services = :id_services";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id_users'    => $employeeId,
            'id_services' => $serviceId
        ]);
        return $stmt->fetchColumn() > 0;
    }

    // 2. Récupère les soins cochés pour un employé (CORRIGÉ: id_users au lieu de id_employee)
    public function getEmployeeServices($employeeId) {
        $sql = "SELECT id_services FROM employee_services WHERE id_users = :emp_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['emp_id' => $employeeId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // 3. Met à jour les compétences/soins cochés (CORRIGÉ: id_users au lieu de id_employee)
    public function updateEmployeeServices($employeeId, $serviceIds) {
        // Supprimer les anciens soins
        $sqlDelete = "DELETE FROM employee_services WHERE id_users = :emp_id";
        $stmtDelete = $this->db->prepare($sqlDelete);
        $stmtDelete->execute(['emp_id' => $employeeId]);

        // Insérer les nouveaux soins cochés
        if (!empty($serviceIds)) {
            $sqlInsert = "INSERT INTO employee_services (id_users, id_services) VALUES (:emp_id, :serv_id)";
            $stmtInsert = $this->db->prepare($sqlInsert);
            foreach ($serviceIds as $serviceId) {
                $stmtInsert->execute([
                    'emp_id'  => $employeeId,
                    'serv_id' => $serviceId
                ]);
            }
        }
    }

    // 4. Récupère les employés qualifiés pour un soin (CORRIGÉ: id_users au lieu de id_employee)
    public function getEmployeesByServiceId($serviceId) {
        $sql = "SELECT u.id_users, p.first_name, p.last_name 
                FROM users u
                INNER JOIN users_profiles p ON u.id_users = p.id_users
                INNER JOIN employee_services es ON u.id_users = es.id_users
                WHERE es.id_services = :service_id 
                  AND u.role IN ('employe', 'employee')
                  AND u.is_active = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['service_id' => $serviceId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}