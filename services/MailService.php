<?php
// app/services/MailService.php

class MailService {
    private $apiKey;

    public function __construct() {
        // Récupération de la clé API depuis le fichier .env chargé par index.php
        $this->apiKey = $_ENV['RESEND_API_KEY'] ?? null;
    }

    public function sendOTP($toEmail, $code) {
        if (!$this->apiKey) {
            error_log("Erreur : Clé API Resend manquante dans le fichier .env");
            return false;
        }

        $url = 'https://api.resend.com/emails';

        // Corps du message envoyé à l'API Resend
        $data = [
            'from'    => 'Acme <onboarding@resend.dev>', // Expéditeur imposé par Resend en mode test
            'to'      => [$toEmail],                     // Ton email de test
            'subject' => 'Votre code de vérification OTP',
            'html'    => "
                <div style='font-family: sans-serif; padding: 20px; color: #333;'>
                    <h2>Validation de votre compte</h2>
                    <p>Merci de vous être inscrit. Voici votre code de vérification valable pendant 15 minutes :</p>
                    <div style='background: #f1f5f9; padding: 15px; font-size: 24px; font-weight: bold; letter-spacing: 5px; text-align: center; border-radius: 8px; margin: 20px 0;'>
                        {$code}
                    </div>
                    <p>Si vous n'êtes pas à l'origine de cette demande, vous pouvez ignorer cet email.</p>
                </div>
            "
        ];

        // Configuration du client cURL natif de PHP
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->apiKey,
            'Content-Type: application/json'
        ]);

        // Exécution de la requête
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Si Resend répond avec un code de succès (200 ou 201), on retourne true
        if ($httpCode === 200 || $httpCode === 201) {
            return true;
        }

        // En cas d'erreur, on écrit la réponse de Resend dans les logs d'erreurs d'Apache/Nginx
        error_log("Échec de l'envoi Resend (Code HTTP $httpCode) : " . $response);
        return false;
    }
}