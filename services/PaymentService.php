<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Stripe\StripeClient;

class PaymentService {
    private $stripe;

    public function __construct() {
        $stripeSecret = $_ENV['STRIPE_SECRET_KEY'] ?? getenv('STRIPE_SECRET_KEY');
        if (empty($stripeSecret)) {
            throw new RuntimeException('La clé STRIPE_SECRET_KEY n\'est pas configurée.');
        }

        $this->stripe = new StripeClient($stripeSecret);
    }

    public function createCheckoutSession(array $sessionData) {
        $successUrl = $sessionData['success_url'];
        $cancelUrl = $sessionData['cancel_url'];

        return $this->stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $sessionData['description'],
                    ],
                    'unit_amount' => (int) $sessionData['amount'],
                ],
                'quantity' => 1,
            ]],
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
            'metadata' => [
                'appointment_info' => json_encode($sessionData['metadata'] ?? []),
            ],
        ]);
    }

    public function retrieveSession(string $sessionId) {
        return $this->stripe->checkout->sessions->retrieve($sessionId, []);
    }
}
