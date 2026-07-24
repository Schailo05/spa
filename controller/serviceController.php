<?php

require_once "../app/Models/Service.php";

class ServiceController
{
    private Service $serviceModel;

    public function __construct(PDO $db)
    {
        $this->serviceModel = new Service($db);
    }


    public function index()
    {
        // Récupération des services avec leurs catégories
        $services = $this->serviceModel->getAllWithCategories();

var_dump($services);
exit;
        // Regroupement des services par catégorie
        $categories = [];

        foreach ($services as $service) {

            $categorieId = $service['categorie_id'];

            if (!isset($categories[$categorieId])) {

                $categories[$categorieId] = [
                    'id' => $service['categorie_id'],
                    'nom' => $service['categorie_nom'],
                    'description' => $service['categorie_description'],
                    'image' => $service['categorie_image'],
                    'services' => []
                ];
            }


            $categories[$categorieId]['services'][] = [
                'id' => $service['service_id'],
                'nom' => $service['service_nom'],
                'description' => $service['service_description'],
                'prix' => $service['prix'],
                'duree' => $service['duree'],
                'image' => $service['service_image']
            ];
        }


        require "../app/Views/services/index.php";
    }
}