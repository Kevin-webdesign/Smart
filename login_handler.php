<?php
session_start();
header('Content-Type: application/json');

// Database connection
$dsn = 'mysql:host=localhost;dbname=smart';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

// Get form data
$email = $_POST['email'];
$password = $_POST['password'];

// Fetch user from the database
try {
    $stmt = $pdo->prepare("SELECT id, first_name, password, user_type FROM baseuser WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Login successful
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_type'] = $user['user_type'];
        $_SESSION['first_name'] = $user['first_name'];

        // Determine redirect URL based on user type
        switch ($user['user_type']) {
            case 'Admin':
                $redirect = 'admin_dash/index.php';
                break;
            case 'Lecture':
                $redirect = 'lecture_dash/index.php';
                break;
            case 'Student':
                $redirect = 'student_dash/index.php';
                break;
            default:
                echo json_encode(['success' => false, 'message' => 'Invalid user type.']);
                exit;
        }

        echo json_encode(['success' => true, 'redirect' => $redirect]);
    } else {
        // Invalid credentials
        echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}