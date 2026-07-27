<?php

use Stripe\Checkout\Session;

class PaymentController {
    private $paymentService;
    private $appointmentModel;
    private $serviceModel;
    private $employeeModel;

    public function __construct($paymentService, $appointmentModel, $serviceModel, $employeeModel) {
        $this->paymentService = $paymentService;
        $this->appointmentModel = $appointmentModel;
        $this->serviceModel = $serviceModel;
        $this->employeeModel = $employeeModel;
    }

    public function showPaymentForm() {
        if (!isset($_SESSION['pending_booking'])) {
            set_flash('error', 'Aucune réservation trouvée pour le paiement.');
            header('Location: index.php?action=booking');
            exit();
        }

        $pending = $_SESSION['pending_booking'];
        include_once 'app/view/client/payment.php';
    }

    public function processPayment() {
        if (!isset($_SESSION['pending_booking'])) {
            set_flash('error', 'Aucune réservation trouvée pour le paiement.');
            header('Location: index.php?action=booking');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=payment');
            exit();
        }

        $pending = $_SESSION['pending_booking'];

        try {
            $baseUrl = $this->buildBaseUrl();
            $successUrl = $baseUrl . '/index.php?action=payment_success&session_id={CHECKOUT_SESSION_ID}';
            $cancelUrl = $baseUrl . '/index.php?action=payment';

            $session = $this->paymentService->createCheckoutSession([
                'amount' => (int) ($pending['service_price'] * 100),
                'description' => sprintf('Soin "%s" - Rendez-vous', $pending['service_name']),
                'success_url' => $successUrl,
                'cancel_url' => $cancelUrl,
                'metadata' => [
                    'appointment_date' => $pending['appointment_datetime'],
                    'user_id' => $pending['user_id'],
                    'service_id' => $pending['id_services'],
                    'employee_id' => $pending['id_employee'],
                ],
            ]);

            header('Location: ' . $session->url);
            exit();
        } catch (Throwable $e) {
            set_flash('error', 'Le paiement Stripe n’a pas pu être initialisé. Vérifiez la configuration Stripe.');
            header('Location: index.php?action=payment');
            exit();
        }
    }

    public function paymentSuccess() {
        $sessionId = trim($_GET['session_id'] ?? '');

        if (empty($sessionId) || !isset($_SESSION['pending_booking'])) {
            set_flash('error', 'Impossible de valider le paiement.');
            header('Location: index.php?action=booking');
            exit();
        }

        try {
            $session = $this->paymentService->retrieveSession($sessionId);
        } catch (Throwable $e) {
            set_flash('error', 'Le paiement n’a pas pu être vérifié auprès de Stripe.');
            header('Location: index.php?action=payment');
            exit();
        }

        if ($session->payment_status !== 'paid') {
            set_flash('error', 'Le paiement n\'a pas été confirmé par Stripe.');
            header('Location: index.php?action=payment');
            exit();
        }

        $pending = $_SESSION['pending_booking'];
        $appointmentDateTime = $pending['appointment_datetime'];
        $userId = $pending['user_id'];

        if ($this->appointmentModel->hasUserAppointmentAt($userId, $appointmentDateTime)) {
            unset($_SESSION['pending_booking']);
            set_flash('success', 'Le paiement est confirmé et le rendez-vous existe déjà.');
            header('Location: index.php?action=dashboard');
            exit();
        }

        $created = $this->appointmentModel->createAppointment([
            'id_users' => $userId,
            'id_services' => $pending['id_services'],
            'id_employee' => $pending['id_employee'],
            'appointment_date' => $appointmentDateTime,
            'status' => 'en attente'
        ]);

        if ($created) {
            unset($_SESSION['pending_booking']);
            set_flash('success', 'Paiement confirmé et rendez-vous réservé avec succès.');
            header('Location: index.php?action=dashboard');
            exit();
        }

        set_flash('error', 'Impossible d\'enregistrer le rendez-vous après paiement.');
        header('Location: index.php?action=booking');
        exit();
    }

    private function buildBaseUrl(): string {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $basePath = dirname($_SERVER['SCRIPT_NAME']);
        if ($basePath === '/' || $basePath === '\\') {
            $basePath = '';
        }
        return sprintf('%s://%s%s', $scheme, $host, $basePath);
    }
}
