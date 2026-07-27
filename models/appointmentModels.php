<?php
// app/models/appointmentModels.php


class AppointmentModel
{

    private $pdo;


    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }



public function createAppointment(
    $clientId,
    $employeeId,
    $date,
    $time
)
{


    $id = sprintf(
        '%04x%04x-%04x-%04x-%04x-%012x',
        mt_rand(0,65535),
        mt_rand(0,65535),
        mt_rand(0,65535),
        mt_rand(16384,20479),
        mt_rand(32768,49151),
        mt_rand(0,4294967295)
    );



    $sql="

    INSERT INTO rendez_vous
    (
        id,
        id_users,
        employe_id,
        date_rendez_vous,
        heure_rendez_vous,
        statut
    )

    VALUES
    (
        :id,
        :client,
        :employee,
        :date,
        :time,
        'en_attente'
    )

    ";



    $stmt=$this->pdo->prepare($sql);


    $stmt->execute([

        ':id'=>$id,

        ':client'=>$clientId,

        ':employee'=>$employeeId,

        ':date'=>$date,

        ':time'=>$time

    ]);



    return $id;

}





public function addService($rendezVousId,$serviceId)
{


    $id = uniqid();



    $sql="

    INSERT INTO rendez_vous_services
    (
        id,
        rendez_vous_id,
        service_id
    )

    VALUES
    (
        :id,
        :rdv,
        :service
    )

    ";


    $stmt=$this->pdo->prepare($sql);



    return $stmt->execute([

        ':id'=>$id,

        ':rdv'=>$rendezVousId,

        ':service'=>$serviceId

    ]);

}

    /**
     * Vérifier si un employé a déjà un rendez-vous
     */
    public function employeeBusy(
        $employeeId,
        $date,
        $time
    )
    {


        $sql="

        SELECT COUNT(*)

        FROM rendez_vous


        WHERE employe_id = :employee

        AND date_rendez_vous = :date

        AND heure_rendez_vous = :time


        ";


        $stmt=$this->pdo->prepare($sql);


        $stmt->execute([


            ':employee'=>$employeeId,

            ':date'=>$date,

            ':time'=>$time


        ]);


        return $stmt->fetchColumn() > 0;


    }



}