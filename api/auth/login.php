<?php

use AmsApp\Utils\CookiesUtil;
function login($email, $password)
{
    global $db;

    // Fetch user by email
    $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($password, $user['password_hash'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid credentials']);
        return;
    }

    // Generate a secure random token
    $token = bin2hex(random_bytes(32)); // 64-character token
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $deviceInfo = $_SERVER['HTTP_USER_AGENT'];
    $userId = $user['user_id'];

    // Calculate expiration time (1 hour from now)
    $expiryTime = date('Y-m-d H:i:s', time() + 3600);

    // Save token in login_sessions table
    $stmt = $db->prepare("
        INSERT INTO login_sessions (user_id, token, device_info, ip_address, expiry_time, status_id)
        VALUES (:user_id, :token, :device_info, :ip_address, :expiry_time, 1)
    ");
    $stmt->execute([
        'user_id' => $userId,
        'token' => $token,
        'device_info' => $deviceInfo,
        'ip_address' => $ipAddress,
        'expiry_time' => $expiryTime
    ]);

    // Set secure HTTP-only cookie
    CookiesUtil::setCookie('auth_token', $token, 3600); // 1-hour expiry
    // Response
    echo json_encode([
        'message' => 'Login successful',
        'token' => $token
    ]);
}
