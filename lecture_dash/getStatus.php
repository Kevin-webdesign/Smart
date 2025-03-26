<?php
// getStatus.php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Connect to your database
$host = 'localhost';
$dbname = 'smart';
$username = 'root';
$password = '';


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to get the status_finger
    $stmt = $pdo->query("SELECT f_mode FROM status_finger WHERE id = 1"); // Assuming id = 1
    $status = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($status) {
        echo json_encode(['status' => $status['f_mode']]);
    } else {
        echo json_encode(['status' => 0]); // Default to 0 if not found
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
