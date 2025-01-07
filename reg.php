<?php
// header("Access-Control-Allow-Methods: POST");
// header('Content-Type: application/json; charset=utf-8');
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
echo "This is test";
// Database connection
$host = 'localhost';
$db_name = 'testdb';
$username = 'root';
$password = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

// Get POST data
$data = json_decode(file_get_contents("php://input"), true);
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

// Input validation
$requiredFields = ['name', 'email', 'password'];
foreach ($requiredFields as $field) {
    if (empty($data[$field])) {
        echo json_encode(['status' => 'error', 'message' => "$field is required.", 'data' => $data]);
        exit;
    }
}

$name = htmlspecialchars(trim($data['name']));
$email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
$password = $data['password'];
$phone_no = isset($data['phone_no']) ? htmlspecialchars(trim($data['phone_no'])) : null;
$gender_id = isset($data['gender_id']) ? (int)$data['gender_id'] : null;

// Check email validity
if (!$email) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email address.']);
    exit;
}

// Generate user_id
$user_id = uniqid("USR_");
$username = $user_id;
// Hash password
$password_hash = password_hash($password, PASSWORD_BCRYPT);

try {
    // Insert into users table
    $stmt = $pdo->prepare("
        INSERT INTO users (user_id, name, username, email, password_hash, status_id, email_verified)
        VALUES (:user_id, :name, :username, :email, :password_hash, 1, 0)
    ");
    $stmt->execute([
        ':user_id' => $user_id,
        ':name' => $name,
        ':username' => $username,
        ':email' => $email,
        ':password_hash' => $password_hash
    ]);

    // Log the registration action
    $logStmt = $pdo->prepare("
        INSERT INTO activity_logs (user_id, action, details)
        VALUES (:user_id, :action, :details)
    ");
    $logStmt->execute([
        ':user_id' => $user_id,
        ':action' => 'Registration',
        ':details' => 'User registered successfully.'
    ]);

    echo json_encode(['status' => 'success', 'message' => 'User registered successfully.']);
} catch (PDOException $e) {
    // Check for duplicate entry errors
    if ($e->getCode() == 23000) {
        echo json_encode(['status' => 'error', 'message' => 'Duplicate entry: Username, email, or phone number already exists.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Registration failed: ' . $e->getMessage()]);
    }
    exit;
}
