<?php

require_once __DIR__ . '/../models/serviceModel.php';

class ServiceController
{
    private Service $serviceModel;

    public function __construct(PDO $pdo)
    {
        $this->serviceModel = new Service($pdo);
    }

    /**
     * Catalogue des services
     */
   /**
 * Catalogue des services
 */
public function index()
{

    if(isset($_GET['categorie']) && !empty($_GET['categorie']))
    {

        $services = $this->serviceModel
                         ->getByCategory($_GET['categorie']);

    }
    else
    {

        $services = $this->serviceModel
                         ->getAllWithCategories();

    }

    

    require_once __DIR__ . '/../views/service/index.php';

}
    
public function details(string $id)
{
    $service = $this->serviceModel->getById($id);

    $avis = $this->serviceModel->getReviewsByService($id);

    if (!$service) {
        header("Location: index.php?action=services");
        exit;
    }

    // Récupérer d'autres soins de la même catégorie
    $servicesSimilaires = $this->serviceModel->getSimilarServices(
        $service['categorie_id'],
        $id
    );

    require_once __DIR__.'/../views/service/details.php';
}

}