<!-- <?php

// include database connection
require_once("../../config/connect.php");

class usersModel{
    private $db;
    public function __construct(){
        $this->db = new Connect();
    }

    private function generateUUID(){
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', 
        mt_rand(0,0xffff),mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x4000,
          mt_rand(0, 0xffff),  mt_rand(0, 0xffff),  mt_rand(0, 0xffff) 
        );
    }
  

public function addUsers(Users $user)  {
   
try{
    $uuid = $this->generateUUID();
    $stmt = $this->db->pdo->prepare("INSERT INTO users (id, first_name, 
    last_name, email, password)  VALUES (:id, :first_name, :last_name, :email, :password) ");

    $stmt->bindParam(':id', $uuid);
    $first_name = $user->getFirstName();
    $last_name = $user->getLastName();
    $email = $user->getEmail();
    $password = $user->getPassword();
    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    return $stmt->execute();
    

}catch(PDOException $error){
 die("Error adding user:" . $error->getMessage());
}


}

// public function getUserByEmail($email){

//     $stmt = $this->db->pdo->prepare(
//         "SELECT * FROM users WHERE email = :email"
//     );

//     $stmt->bindParam(':email', $email);

//     $stmt->execute();

//     return $stmt->fetch(PDO::FETCH_ASSOC);
// }

// public function getAllUsers()
// {
//     $stmt = $this->db->pdo->prepare(
//         "SELECT first_name, last_name, email, created_at FROM users"
//     );

//     $stmt->execute();

//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }

}



?> -->