<?php
// app/models/employeeModels.php


class EmployeeModel
{

    private $pdo;



    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }




    /**
     * Récupérer tous les employés
     */
    public function getAllEmployees()
    {

        $sql = "

        SELECT 

            u.id_users,
            u.email,
            p.first_name,
            p.last_name,
            p.phone


        FROM users u


        LEFT JOIN users_profiles p

        ON u.id_users = p.id_users


        WHERE u.role = 'employe'


        ORDER BY p.last_name ASC

        ";


        $stmt = $this->pdo->query($sql);


        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }






    /**
     * Récupérer les services d'un employé
     */
    public function getEmployeeServices($employeeId)
{

    $sql = "

    SELECT service_id

    FROM employee_services

    WHERE id_users = :id_users

    ";


    $stmt = $this->pdo->prepare($sql);


    $stmt->execute([

        ':id_users'=>$employeeId

    ]);


    return $stmt->fetchAll(PDO::FETCH_COLUMN);

}








    /**
     * Modifier les services d'un employé
     */
    public function updateEmployeeServices($employeeId, $serviceIds)
    {


        $this->pdo->beginTransaction();



        try {


            // Supprimer les anciennes associations

            $delete = $this->pdo->prepare("

                DELETE FROM employee_services

                WHERE id_users = :id_users

            ");



            $delete->execute([

                ':id_users'=>$employeeId

            ]);





            // Ajouter les nouvelles associations


            if(!empty($serviceIds))
            {


                $insert = $this->pdo->prepare("

                    INSERT INTO employee_services

                    (
                        id_employee_service,
                        id_users,
                        service_id
                    )


                    VALUES

                    (
                        :id,
                        :id_users,
                        :service_id
                    )

                ");




                foreach($serviceIds as $serviceId)
                {


                    $insert->execute([


                        ':id'=>uniqid(),


                        ':id_users'=>$employeeId,


                        ':service_id'=>$serviceId


                    ]);


                }


            }



            $this->pdo->commit();


            return true;



        } catch(Exception $e) {


            $this->pdo->rollBack();


            return false;

        }


    }








    /**
     * Trouver les employés capables de faire un service
     */
    public function getEmployeesByServiceId($serviceId)
    {


        $sql = "

        SELECT


            u.id_users,

            p.first_name,

            p.last_name


        FROM users u



        JOIN users_profiles p

        ON u.id_users = p.id_users




        JOIN employee_services es

        ON u.id_users = es.id_users




        WHERE es.service_id = :service_id


        AND u.role = 'employe'


        ";



        $stmt = $this->pdo->prepare($sql);



        $stmt->execute([


            ':service_id'=>$serviceId


        ]);



        return $stmt->fetchAll(PDO::FETCH_ASSOC);


    }



// Chercher un employé disponible pour un service, une date et une heure

public function findAvailableEmployee($serviceId, $date, $time)
{

    $sql = "

    SELECT u.id_users

    FROM users u

    INNER JOIN employee_services es

    ON u.id_users = es.id_users


    INNER JOIN disponibilites d

    ON u.id_users = d.id_users


    WHERE es.service_id = :service_id


    AND d.jour = DAYNAME(:date)


    AND :time BETWEEN d.heure_debut AND d.heure_fin


    AND u.role = 'employe'


    AND u.is_active = 1


    LIMIT 1

    ";


    $stmt = $this->pdo->prepare($sql);


    $stmt->execute([

        ':service_id'=>$serviceId,

        ':date'=>$date,

        ':time'=>$time

    ]);


    $employee = $stmt->fetch(PDO::FETCH_ASSOC);



    return $employee ? $employee['id_users'] : false;

}





// Chercher des alternatives

public function getSuggestedSlots($serviceId,$date,$time)
{

    $suggestions=[];



    for($i=1;$i<=7;$i++)
    {


        $newDate=date(
            'Y-m-d',
            strtotime($date." +".$i." days")
        );



        $employee=$this->findAvailableEmployee(
            $serviceId,
            $newDate,
            $time
        );



        if($employee)
        {


            $suggestions[]=[

                "date"=>$newDate,

                "time"=>$time,

                "employee_id"=>$employee

            ];


        }



        if(count($suggestions)>=3){

            break;

        }

    }



    return $suggestions;

}

public function findAvailableSlot($serviceId, $date, $time)
{

    $sql = "

    SELECT 
        u.id_users,
        d.heure_debut,
        d.heure_fin

    FROM users u


    JOIN employee_services es

    ON u.id_users = es.id_users


    JOIN disponibilites d

    ON u.id_users = d.id_users


    WHERE es.service_id = :service_id

    AND d.jour = DAYNAME(:date)

    AND :time BETWEEN d.heure_debut AND d.heure_fin

    AND u.role = 'employe'


    LIMIT 1

    ";


    $stmt = $this->pdo->prepare($sql);


    $stmt->execute([

        ':service_id'=>$serviceId,

        ':date'=>$date,

        ':time'=>$time

    ]);



    $result = $stmt->fetch(PDO::FETCH_ASSOC);



    if($result){

        return [

            "employee_id"=>$result['id_users'],

            "date"=>$date,

            "time"=>$time

        ];

    }



    return false;

}




}