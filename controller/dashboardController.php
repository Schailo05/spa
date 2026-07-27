<?php

class DashboardController
{

    private $appointmentModel;


    public function __construct($appointmentModel)
    {
        $this->appointmentModel = $appointmentModel;
    }



    public function index()
    {


        if(!isset($_SESSION['user'])){

            header('Location: index.php?action=login');
            exit();

        }



        $userId = $_SESSION['user']['id'];



        $userAppointments = 
            $this->appointmentModel
            ->getUserAppointments($userId);



        require_once __DIR__ . '/../views/dashboard.php';


    }


}