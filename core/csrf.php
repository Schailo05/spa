<?php
// core/csrf.php

if (!function_exists('generate_csrf_token')) {
    function generate_csrf_token(): string {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['csrf_tokens']) || !is_array($_SESSION['csrf_tokens'])) {
            $_SESSION['csrf_tokens'] = [];
        }

        // Purge tokens older than 1 hour
        $expiry = 3600;
        $now = time();
        foreach ($_SESSION['csrf_tokens'] as $t => $ts) {
            if ($ts + $expiry < $now) {
                unset($_SESSION['csrf_tokens'][$t]);
            }
        }

        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_tokens'][$token] = $now;

        return $token;
    }
}

if (!function_exists('verify_csrf_token')) {
    function verify_csrf_token(?string $token): bool {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (empty($token)) return false;
        if (!isset($_SESSION['csrf_tokens']) || !is_array($_SESSION['csrf_tokens'])) return false;

        if (!array_key_exists($token, $_SESSION['csrf_tokens'])) return false;

        // Consume token (single-use)
        unset($_SESSION['csrf_tokens'][$token]);
        return true;
    }
}

if (!function_exists('csrf_input_field')) {
    function csrf_input_field(): string {
        $token = generate_csrf_token();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }
}

?>