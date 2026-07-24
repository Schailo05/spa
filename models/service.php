<?php

class Service
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Services d'une catégorie
     */
  public function getAllWithCategories()
{
    $sql = "
        SELECT 
            s.id AS service_id,
            s.nom AS service_nom,
            s.description AS service_description,
            s.prix,
            s.duree,
            s.image AS service_image,

            c.id AS categorie_id,
            c.nom AS categorie_nom,
            c.description AS categorie_description,
            c.image AS categorie_image

        FROM services s

        INNER JOIN categorie c
        ON s.categorie_id = c.id

        ORDER BY c.nom, s.nom
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    /**
     * Un service par UUID
     */
    public function getById(string $id)
    {
        $sql = "SELECT *
                FROM services
                WHERE id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}