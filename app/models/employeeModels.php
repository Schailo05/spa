<?php
// app/models/employeeModels.php

class EmployeeModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    
// Récupérer uniquement les utilisateurs qui ont le rôle 'employe'
public function getAllEmployees() {
    $sql = "SELECT u.id_users, u.email, p.first_name, p.last_name 
            FROM users u
            LEFT JOIN users_profiles p ON u.id_users = p.id_users 
            WHERE u.role IN ('employe', 'employee', 'staff')
            ORDER BY p.last_name ASC";

    $stmt = $this->db->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
    // Récupérer les IDs des services qu'un employé sait faire
    public function getEmployeeServices($employeeId) {
        $sql = "SELECT id_services FROM employee_services WHERE id_users = :id_users";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_users' => $employeeId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN); // Retourne un tableau simple d'IDs [1, 3, 5]
    }

    // Mettre à jour les spécialités d'un employé (supprime l'ancien, insère le nouveau)
    public function updateEmployeeServices($employeeId, $serviceIds) {
        $this->db->beginTransaction();
        try {
            // 1. On nettoie ses anciennes spécialités
            $sqlDelete = "DELETE FROM employee_services WHERE id_users = :id_users";
            $stmtDelete = $this->db->prepare($sqlDelete);
            $stmtDelete->execute([':id_users' => $employeeId]);

            // 2. On insère les nouvelles spécialités sélectionnées
            if (!empty($serviceIds)) {
                $sqlInsert = "INSERT INTO employee_services (id_users, id_services) VALUES (:id_users, :id_services)";
                $stmtInsert = $this->db->prepare($sqlInsert);
                foreach ($serviceIds as $serviceId) {
                    $stmtInsert->execute([
                        ':id_users' => $employeeId,
                        ':id_services' => (int)$serviceId
                    ]);
                }
            }
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function getEmployeesByServiceId($serviceId) {
    $sql = "SELECT u.id_users, p.first_name, p.last_name 
            FROM users u
            JOIN users_profiles p ON u.id_users = p.id_users
            JOIN employee_services es ON u.id_users = es.id_users
            WHERE es.id_services = :service_id AND u.role = 'employe'";
            
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['service_id' => $serviceId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}