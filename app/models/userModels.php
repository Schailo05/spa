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
        $sql = "INSERT INTO email_verifications (email, code, expires_at) 
                VALUES (:email, :code, DATE_ADD(NOW(), INTERVAL 15 MINUTE))
                ON DUPLICATE KEY UPDATE code = VALUES(code), expires_at = DATE_ADD(NOW(), INTERVAL 15 MINUTE)";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'email' => $email,
            'code'  => $code
        ]);
    }

    /**
     * Crée l'utilisateur final en générant un UUID v4
     * Accepte désormais un champ optionnel 'role' (par défaut : 'client')
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

        // Récupération du rôle ou attribution du rôle par défaut 'client'
        $role = $data['role'] ?? 'client';

        try {
            // 1. On démarre une transaction pour sécuriser la double insertion
            $this->pdo->beginTransaction();

            // 2. Insertion dans la table principale 'users' (avec le rôle spécifié)
            $sqlUser = "INSERT INTO users (id_users, email, password, role) 
                        VALUES (:id, :email, :password, :role)";
            
            $stmtUser = $this->pdo->prepare($sqlUser);
            $stmtUser->execute([
                'id'       => $uuid,
                'email'    => $data['email'],
                'password' => $data['password'],
                'role'     => $role
            ]);

            // 3. Insertion dans la table dépendante 'users_profiles' avec le MÊME UUID
            $sqlProfile = "INSERT INTO users_profiles (id_users, first_name, last_name, phone) 
                           VALUES (:id_users, :first_name, :last_name, :phone)";
            
            $stmtProfile = $this->pdo->prepare($sqlProfile);
            $stmtProfile->execute([
                'id_users'   => $uuid,
                'first_name' => $data['first_name'] ?? '',
                'last_name'  => $data['last_name'] ?? '',
                'phone'      => $data['phone'] ?? null
            ]);

            // 4. Valider la transaction
            $this->pdo->commit();
            
            // Retourne l'UUID créé au lieu d'un simple boolean pour pouvoir l'utiliser si besoin
            return $uuid;

        } catch (Exception $e) {
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
     * Enregistre un jeton de réinitialisation de mot de passe
     */
    public function savePasswordResetToken($email, $token) {
        try {
            $stmtDelete = $this->pdo->prepare("DELETE FROM password_resets WHERE email = ?");
            $stmtDelete->execute([$email]);

            $stmt = $this->pdo->prepare("INSERT INTO password_resets (email, token, expires_at) 
                                        VALUES (:email, :token, DATE_ADD(NOW(), INTERVAL 1 HOUR))");
            return $stmt->execute([
                'email' => $email,
                'token' => $token
            ]);
        } catch (PDOException $e) {
            error_log('Erreur savePasswordResetToken: ' . $e->getMessage());
            return false;
        }
    }

    public function getPasswordResetByToken($token) {
        $sql = "SELECT email FROM password_resets WHERE token = :token AND expires_at > NOW() LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['token' => $token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deletePasswordResetToken($token) {
        $stmt = $this->pdo->prepare("DELETE FROM password_resets WHERE token = ?");
        return $stmt->execute([$token]);
    }

    public function updatePasswordByEmail($email, $password) {
        $stmt = $this->pdo->prepare("UPDATE users SET password = :password WHERE email = :email");
        return $stmt->execute([
            'password' => $password,
            'email'    => $email
        ]);
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

    /**
     * Récupère tous les utilisateurs avec leurs profils
     */
    public function getAllUsers() {
        try {
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
                'id'   => $userId
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
                'id'     => $userId
            ]);
        } catch (PDOException $e) {
            die("Erreur lors de la modification du statut : " . $e->getMessage());
        }
    }
    public function updateUserStatusAndRole($userId, $role, $isActive) {
    $sql = "UPDATE users SET role = :role, is_active = :is_active WHERE id_users = :id";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([
        ':role'      => $role,
        ':is_active' => $isActive,
        ':id'        => $userId
    ]);
}
public function getEmployees() {
    $sql = "SELECT u.id_users, u.email, u.role, p.first_name, p.last_name 
            FROM users u
            LEFT JOIN users_profiles p ON u.id_users = p.id_users
            WHERE u.role IN ('employe', 'employee', 'practitioner', 'staff') 
              AND u.is_active = 1
            ORDER BY p.last_name ASC";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}