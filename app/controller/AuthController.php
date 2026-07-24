<?php
// app/controller/AuthController.php

class AuthController {
    private $userModel;
    private $mailService;

    public function __construct($userModel, $mailService) {
        $this->userModel = $userModel;
        $this->mailService = $mailService;
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email     = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            $password  = trim($_POST['password']);
            $firstName = htmlspecialchars(trim($_POST['first_name']));
            $lastName  = htmlspecialchars(trim($_POST['last_name']));
            $phone     = htmlspecialchars(trim($_POST['phone']));

            // Validations de sécurité
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                die("Format d'email invalide.");
            } 
            if (strlen($password) < 8) {
                die("Le mot de passe doit contenir au moins 8 caractères");
            }
            if ($this->userModel->emailExists($email)) {
                die('Cet email est déjà utilisé. Veuillez en choisir un autre.');
            }
            
            // Génération du code OTP à 6 chiffres
            $code = (string) random_int(100000, 999999);

            // Sauvegarde en base de données
            $this->userModel->saveVerificationCode($email, $code);

            // Stockage temporaire des infos en session avant validation OTP
            $_SESSION['temp_user'] = [
                'email'      => $email,
                'password'   => password_hash($password, PASSWORD_DEFAULT), 
                'first_name' => $firstName,
                'last_name'  => $lastName,
                'phone'      => $phone
            ];
           
            // Envoi de l'email via ton service MailService (Resend)
            $emailSent = $this->mailService->sendOTP($email, $code);

            if ($emailSent) {
                header('Location: index.php?action=verify_code');
                exit();
            } else {
                die("Erreur technique : Impossible d'envoyer l'email de validation.");
            }

        } else {
            // Affichage du formulaire d'inscription (GET)
            include_once 'app/view/auth/register.php';
        }
    }

    public function verifyCode() {
        // Sécurité : Si aucun utilisateur temporaire n'est en session, on le renvoie à l'inscription
        if (!isset($_SESSION['temp_user'])) {
            header('Location: index.php?action=register');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $otpCode = trim($_POST['otp_code']);
            $email = $_SESSION['temp_user']['email'];

            // 1. On vérifie le code en BDD via le modèle
            $isValid = $this->userModel->verifyOTP($email, $otpCode);

            if ($isValid) {
                // 2. Le code est bon ! On crée l'utilisateur final avec son UUID
                $userCreated = $this->userModel->createUser($_SESSION['temp_user']);

                if ($userCreated) {
                    // 3. Nettoyage : On supprime le code OTP utilisé et les variables temporaires
                    $this->userModel->deleteOTP($email);
                    
                    unset($_SESSION['temp_user']);

                    // 4. Redirection vers la page de connexion
                    header('Location: index.php?action=login');
                    exit();
                } else {
                    $error = "Erreur lors de la création de votre compte.";
                }
            } else {
                $error = "Code incorrect ou expiré. Veuillez réessayer.";
            }
        }

        // Affichage du formulaire OTP (En GET ou si erreur en POST)
        include_once 'app/view/auth/verify_code.php';
    }

   public function login() {
        // Si déjà connecté, redirection immédiate selon le rôle stocké en session
        if (isset($_SESSION['user'])) {
            if ($_SESSION['user']['role'] === 'admin') {
                header('Location: index.php?action=admin_dashboard');
            } elseif ($_SESSION['user']['role'] === 'employe') {
                header('Location: index.php?action=staff_dashboard');
            } else {
                header('Location: index.php?action=dashboard');
            }
            exit();
        }

        $error = null;

        // Si le formulaire est soumis (Méthode POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'] ?? '';

            if (!$email || empty($password)) {
                $error = "Veuillez remplir tous les champs correctement.";
            } else {
                // Recherche de l'utilisateur avec la jointure SQL
                $user = $this->userModel->getUserByEmail($email);

                // Vérification de l'existence et du mot de passe
                if ($user && password_verify($password, $user['password'])) {
                    
                    if ((int)$user['is_active'] !== 1) {
                        $error = "Votre compte a été désactivé. Contactez l'administrateur.";
                    } else {
                        // Sécurisation de la session
                        session_regenerate_id(true);

                        // Stockage des informations utilisateur
                        $_SESSION['user'] = [
                            'id'         => $user['id_users'],
                            'email'      => $user['email'],
                            'role'       => $user['role'],
                            'first_name' => $user['first_name'],
                            'last_name'  => $user['last_name']
                        ];

                        // Redirection dynamique selon le rôle de l'utilisateur
                        if ($user['role'] === 'admin') {
                            header('Location: index.php?action=admin_dashboard');
                        } elseif ($user['role'] === 'employe') {
                            header('Location: index.php?action=staff_dashboard');
                        } else {
                            header('Location: index.php?action=dashboard');
                        }
                        exit();
                    }
                } else {
                    $error = "Identifiants ou mot de passe incorrects.";
                }
            }
        }

        // Chargement du fichier HTML
        require_once dirname(__DIR__) . '/view/login.php';
    }

    public function logout() {
        // 1. On vide le tableau de session
        $_SESSION = [];

        // 2. On détruit le cookie de session dans le navigateur
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // 3. On détruit la session sur le serveur
        session_destroy();

        // 4. Redirection vers la page de connexion
        header('Location: index.php?action=login');
        exit();
    }
}