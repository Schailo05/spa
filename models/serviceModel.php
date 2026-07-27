<?php

class Service
{

    private PDO $db;


    public function __construct(PDO $db)
    {
        $this->db = $db;
    }





    /**
     * Tous les services actifs avec catégories
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


        WHERE s.statut = 'actif'


        ORDER BY c.nom, s.nom

        ";


        $stmt = $this->db->prepare($sql);

        $stmt->execute();


        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

/**
 * Services par catégorie
 */
public function getByCategory($categorie)
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
        c.nom AS categorie_nom


    FROM services s


    INNER JOIN categorie c

    ON s.categorie_id = c.id


    WHERE c.nom = ?


    AND s.statut = 'actif'


    ORDER BY s.nom

    ";


    $stmt = $this->db->prepare($sql);

    $stmt->execute([$categorie]);


    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


    /**
     * Un service par ID
     */
    public function getById($id)
    {

        $sql = "

        SELECT 

            s.*,

            c.nom AS categorie_nom


        FROM services s


        INNER JOIN categorie c

        ON s.categorie_id = c.id


        WHERE s.id = ?

        ";


        $stmt = $this->db->prepare($sql);

        $stmt->execute([$id]);


        return $stmt->fetch(PDO::FETCH_ASSOC);

    }






    /**
     * Ajouter service (admin)
     */
    public function create($data)
    {

        $sql = "

        INSERT INTO services
        (
            categorie_id,
            nom,
            description,
            prix,
            duree,
            image,
            statut
        )

        VALUES
        (
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            'actif'
        )

        ";


        $stmt = $this->db->prepare($sql);


        return $stmt->execute([

            $data['categorie_id'],
            $data['nom'],
            $data['description'],
            $data['prix'],
            $data['duree'],
            $data['image']

        ]);

    }


    public function getSimilarServices($categorie_id, $service_id)
{
    $sql = "
        SELECT 
            id,
            nom,
            prix,
            image
        FROM services
        WHERE categorie_id = ?
        AND id != ?
        AND statut = 'actif'
        LIMIT 3
    ";

    $stmt = $this->db->prepare($sql);

    $stmt->execute([
        $categorie_id,
        $service_id
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

 public function getReviewsByService($id)
{
    $sql = "
        SELECT 
            a.note,
            a.commentaire,
            a.created_at,
            CONCAT(up.first_name, ' ', up.last_name) AS nom

        FROM avis a

        INNER JOIN users_profiles up
        ON a.client_id = up.id_users

        WHERE a.id = ?

        ORDER BY a.created_at DESC
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$id]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}

