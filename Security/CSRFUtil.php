<?php
namespace AmsApp\Security;
class CSRFUtil {
    const CSRF_TOKEN = 'csrf_token';

    /**
     * Generate a CSRF token and store it in the session.
     *
     * @return string The generated CSRF token.
     */
    public static function generateToken(): string {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (empty($_SESSION[self::CSRF_TOKEN])) {
            $_SESSION[self::CSRF_TOKEN] = bin2hex(random_bytes(32));
        }
        return $_SESSION[self::CSRF_TOKEN];
    }

    /**
     * Validate the provided CSRF token against the session token.
     *
     * @param string $token The CSRF token to validate.
     * @return bool True if valid, false otherwise.
     */
    public static function validateToken(string $token): bool {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        return hash_equals($_SESSION[self::CSRF_TOKEN] ?? '', $token);
    }

    /**
     * Include a hidden CSRF token input in forms.
     *
     * @return string HTML input element with the CSRF token.
     */
    public static function getHiddenInput(string $id): string {
        $token = self::generateToken();
        return '<input type="hidden" id="'.$id.'" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }
}
