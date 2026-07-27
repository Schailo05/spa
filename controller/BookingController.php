<?php

class BookingController
{

    private $serviceModel;
    private $employeeModel;
    private $appointmentModel;


    public function __construct(
        $serviceModel,
        $employeeModel,
        $appointmentModel
    ){

        $this->serviceModel = $serviceModel;
        $this->employeeModel = $employeeModel;
        $this->appointmentModel = $appointmentModel;

    }



    public function showBookingForm()
    {

        if(!isset($_SESSION['user'])){

            header("Location:index.php?action=login");
            exit();

        }


        $cart = $_SESSION['cart'] ?? [];


        if(empty($cart)){

            header("Location:index.php?action=cart");
            exit();

        }


      require_once __DIR__ . '/../views/client/booking.php';


    }






public function saveBooking()
{


if(!isset($_SESSION['user'])){

header("Location:index.php?action=login");
exit();

}



$cart=$_SESSION['cart'] ?? [];



if(empty($cart)){

header("Location:index.php?action=cart");
exit();

}



$date=$_POST['appointment_date'] ?? null;

$time=$_POST['appointment_time'] ?? null;



$clientId=$_SESSION['user']['id_users'];



$serviceId=$cart[0]['id'];





$employeeId=
$this->employeeModel
->findAvailableEmployee(
    $serviceId,
    $date,
    $time
);





// Aucun employé

if(!$employeeId)
{


$suggestions=
$this->employeeModel
->getSuggestedSlots(
    $serviceId,
    $date,
    $time
);



require_once __DIR__.'/../views/client/suggestions.php';


exit();

}





// Création rendez-vous


$rdvId=
$this->appointmentModel
->createAppointment(

$clientId,

$employeeId,

$date,

$time

);






// Ajout services panier


foreach($cart as $service)
{


$this->appointmentModel
->addService(

$rdvId,

$service['id']

);


}





unset($_SESSION['cart']);



header(
"Location:index.php?action=dashboard&success=1"
);


exit();


}

public function confirmSuggestion()
{


$date=$_POST['date'];

$time=$_POST['time'];

$employee=$_POST['employee_id'];



$cart=$_SESSION['cart'];



$client=$_SESSION['user']['id_users'];



$rdvId=
$this->appointmentModel
->createAppointment(

$client,

$employee,

$date,

$time

);



foreach($cart as $service)
{

$this->appointmentModel
->addService(
$rdvId,
$service['id']
);

}



unset($_SESSION['cart']);



header(
"Location:index.php?action=dashboard&success=1"
);


exit();

}





    private function convertDay($date)
    {

        $days = [

            "Monday"=>"Lundi",
            "Tuesday"=>"Mardi",
            "Wednesday"=>"Mercredi",
            "Thursday"=>"Jeudi",
            "Friday"=>"Vendredi",
            "Saturday"=>"Samedi",
            "Sunday"=>"Dimanche"

        ];


        return $days[
            date("l",strtotime($date))
        ];

    }

    

}