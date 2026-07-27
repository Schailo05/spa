<?php
// app/model/ServiceModel.php

class ServiceModels {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    // Récupérer tous les soins
    public function getAllServices() {
        $stmt = $this->db->query("SELECT * FROM services ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter un nouveau soin
    public function addService($name, $description, $duration, $price) {
        $sql = "INSERT INTO services (name, description, duration, price) VALUES (:name, :description, :duration, :price)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':name'        => $name,
            ':description' => $description,
            ':duration'    => (int)$duration,
            ':price'       => (float)$price
        ]);
    }

    // Supprimer un soin
    public function deleteService($id) {
        $sql = "DELETE FROM services WHERE id_services = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function getServiceById($id) {
        $sql = "SELECT * FROM services WHERE id_services = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}