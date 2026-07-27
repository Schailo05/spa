<?php
// app/models/UserModel.php

class UserModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Vérifie si un email existe déjà dans la base
     */
    public function emailExists($email) {
        $stmt = $this->pdo->prepare("SELECT id_users FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch() ? true : false;
    }

    /**
     * Sauvegarde ou met à jour le code OTP (valable 15 minutes)
     */
    public function saveVerificationCode($email, $code) {
        // En utilisant VALUES(code), on évite de répéter le marqueur :code
    $sql = "INSERT INTO email_verifications (email, code, expires_at) 
            VALUES (:email, :code, DATE_ADD(NOW(), INTERVAL 15 MINUTE))
            ON DUPLICATE KEY UPDATE code = VALUES(code), expires_at = DATE_ADD(NOW(), INTERVAL 15 MINUTE)";

    $stmt = $this->pdo->prepare($sql);
    
    // Maintenant, il y a exactement 2 marqueurs uniques (:email et :code)
    // et 2 clés dans le tableau. PDO est content !
    return $stmt->execute([
        'email' => $email,
        'code'  => $code
        ]);
    }

    /**
     * Crée l'utilisateur final en générant un UUID v4
     */
    public function createUser($data) {
        // Génération d'un UUID v4 robuste en PHP pur
        $uuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );

        try {
            // 1. On démarre une transaction pour sécuriser la double insertion
            $this->pdo->beginTransaction();

            // 2. Insertion dans la table principale 'users'
            // (Le rôle prendra 'client' par défaut et is_active prendra 1 grâce à ta structure SQL)
            $sqlUser = "INSERT INTO users (id_users, email, password) 
                        VALUES (:id, :email, :password)";
            
            $stmtUser = $this->pdo->prepare($sqlUser);
            $stmtUser->execute([
                'id'       => $uuid,
                'email'    => $data['email'],
                'password' => $data['password']
            ]);

            // 3. Insertion dans la table dépendante 'users_profiles' avec le MÊME UUID
            $sqlProfile = "INSERT INTO users_profiles (id_users, first_name, last_name, phone) 
                           VALUES (:id_users, :first_name, :last_name, :phone)";
            
            $stmtProfile = $this->pdo->prepare($sqlProfile);
            $stmtProfile->execute([
                'id_users'   => $uuid, // Liaison via la clé étrangère
                'first_name' => $data['first_name'],
                'last_name'  => $data['last_name'],
                'phone'      => $data['phone']
            ]);

            // 4. Si les deux requêtes ont fonctionné, on valide définitivement en base
            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            // En cas d'erreur sur l'une des deux tables, on annule tout pour éviter les données orphelines
            $this->pdo->rollBack();
            error_log("Erreur lors de la création de l'utilisateur et du profil : " . $e->getMessage());
            return false;
        }
    }

    /**
     * Vérifie si le code OTP est correct et valide (moins de 15 minutes)
     */
    public function verifyOTP($email, $code) {
        $sql = "SELECT * FROM email_verifications 
                WHERE email = :email 
                AND code = :code 
                AND expires_at > NOW()";
                
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'email' => $email,
            'code'  => $code
        ]);
        
        // Si une ligne correspond, le code est valide
        return $stmt->fetch() ? true : false;
    }

    /**
     * Supprime le code OTP une fois qu'il a été utilisé avec succès
     */
    public function deleteOTP($email) {
        $stmt = $this->pdo->prepare("DELETE FROM email_verifications WHERE email = ?");
        return $stmt->execute([$email]);
    }
    /**
 * Récupère un utilisateur et son profil complet par son email (pour le Login)
 */
public function getUserByEmail($email) {
    $sql = "SELECT u.id_users, u.email, u.password, u.role, u.is_active, 
                   p.first_name, p.last_name, p.phone
            FROM users u
            INNER JOIN users_profiles p ON u.id_users = p.id_users
            WHERE u.email = :email";
            
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    
    return $stmt->fetch(PDO::FETCH_ASSOC); 
}
public function getAllUsers() {
    try {
        // On récupère les utilisateurs avec leurs profils (jointure)
        // Ajuste les noms des tables/colonnes si nécessaire selon ta BDD
        $sql = "SELECT u.id_users, u.email, u.role, u.is_active, 
                       p.first_name, p.last_name, p.phone 
                FROM users u
                LEFT JOIN users_profiles p ON u.id_users = p.id_users";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la récupération des utilisateurs : " . $e->getMessage());
    }
}
public function updateUserRole($userId, $newRole) {
    try {
        $sql = "UPDATE users SET role = :role WHERE id_users = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'role' => $newRole,
            'id' => $userId
        ]);
    } catch (PDOException $e) {
        die("Erreur lors de la modification du rôle : " . $e->getMessage());
    }
}

public function updateUserStatus($userId, $isActive) {
    try {
        $sql = "UPDATE users SET is_active = :status WHERE id_users = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'status' => $isActive,
            'id' => $userId
        ]);
    } catch (PDOException $e) {
        die("Erreur lors de la modification du statut : " . $e->getMessage());
    }
}
}