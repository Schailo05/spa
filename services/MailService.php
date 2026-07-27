<?php
// app/services/MailService.php

class MailService {
    private $apiKey;

    public function __construct() {
        // Fallback sur getenv() au cas où $_ENV ne charge pas
        $this->apiKey = $_ENV['RESEND_API_KEY'] ?? getenv('RESEND_API_KEY') ?? null;
    }

    public function sendOTP($toEmail, $code) {
        if (!$this->apiKey) {
            error_log("Erreur : Clé API Resend manquante dans le fichier .env");
            // Décommenter la ligne ci-dessous en dev pour voir l'erreur directe à l'écran :
            // die("Erreur : Clé API Resend manquante (RESEND_API_KEY est vide)");
            return false;
        }

        $url = 'https://api.resend.com/emails';

        $data = [
            'from'    => 'Acme <onboarding@resend.dev>', // Expéditeur de test officiel
            'to'      => [$toEmail],                     // Doit être TON email d'inscription Resend
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

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        
        // 🔒 CORRECTION 1 : Désactiver la vérification SSL en local (évite le crash cURL SSL)
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . trim($this->apiKey),
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        // Si la requête cURL a échoué techniquement
        if ($response === false) {
            error_log("Erreur cURL : " . $curlError);
            // die("Erreur cURL locale : " . $curlError); // Pour déboguer à l'écran
            return false;
        }

        // Si Resend renvoie 200 ou 201
        if ($httpCode === 200 || $httpCode === 201) {
            return true;
        }

        // 🔍 CORRECTION 2 : Logger la vraie raison du refus par Resend
        error_log("Échec Resend (HTTP $httpCode) : " . $response);
        
        // Pour voir la réponse brute directement dans le navigateur (décommenter si besoin de tester) :
        // die("Erreur Resend HTTP $httpCode : " . $response);

        return false;
    }

    public function sendPasswordReset($toEmail, $resetUrl) {
        if (!$this->apiKey) {
            error_log("Erreur : Clé API Resend manquante dans le fichier .env");
            return false;
        }

        $url = 'https://api.resend.com/emails';

        $data = [
            'from'    => 'Acme <onboarding@resend.dev>',
            'to'      => [$toEmail],
            'subject' => 'Réinitialisez votre mot de passe',
            'html'    => "
                <div style='font-family: sans-serif; padding: 20px; color: #333;'>
                    <h2>Réinitialisation du mot de passe</h2>
                    <p>Vous avez demandé à réinitialiser votre mot de passe. Cliquez sur le lien suivant pour choisir un nouveau mot de passe :</p>
                    <div style='margin: 20px 0; text-align: center;'>
                        <a href='{$resetUrl}' style='display:inline-block;padding:12px 24px;background:#2563eb;color:#fff;text-decoration:none;border-radius:8px;'>Réinitialiser mon mot de passe</a>
                    </div>
                    <p>Si vous n'avez pas demandé ce changement, ignorez ce message.</p>
                </div>
            "
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . trim($this->apiKey),
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            error_log("Erreur cURL : " . $curlError);
            return false;
        }

        if ($httpCode === 200 || $httpCode === 201) {
            return true;
        }

        error_log("Échec Resend (HTTP $httpCode) : " . $response);
        return false;
    }
}