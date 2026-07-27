<?php

class Categorie
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Retourne toutes les catégories
     */
    public function getAll()
    {
        $sql = "SELECT *
                FROM categorie
                ORDER BY nom";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retourne une catégorie par son UUID
     */
    public function getById(string $id)
    {
        $sql = "SELECT *
                FROM categorie
                WHERE id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
