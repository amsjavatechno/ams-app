<?php

namespace AmsApp\Auth;
class AuthMiddleware
{
    public static function handle()
    {
        session_start();
        if (!isset($_SESSION['user_logged_in'])) {
            header('Location: /login');
            exit();
        }
    }

    function authenticate()
    {
        global $db;

        // Check if token is provided in cookies
        if (!isset($_COOKIE['auth_token'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        $token = $_COOKIE['auth_token'];

        // Validate token in the database
        $stmt = $db->prepare("
        SELECT * FROM login_sessions
        WHERE token = :token AND status_id = 1
    ");
        $stmt->execute(['token' => $token]);
        $session = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$session) {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid token']);
            exit;
        }

        // Update last activity time
        $stmt = $db->prepare("
        UPDATE login_sessions
        SET last_activity_time = CURRENT_TIMESTAMP
        WHERE id = :id
    ");
        $stmt->execute(['id' => $session['id']]);

        // Return user info for further processing
        return $session['user_id'];
    }

// Example of a protected API endpoint
    function getSecureData()
    {
        $userId = authenticate(); // Ensure user is authenticated
        echo json_encode(['message' => 'Secure data accessed', 'user_id' => $userId]);
    }



}


// Middleware to validate toke

// Example Usage
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    getSecureData();
}
