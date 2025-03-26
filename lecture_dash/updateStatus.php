<?php
// updateStatus.php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
$host = 'localhost';
$dbname = 'smart';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the status from the request body
    $data = json_decode(file_get_contents('php://input'), true);
    $newStatus = $data['status'];

    if ($newStatus === 0 || $newStatus === 1) {
        // Update the status in the database
        $stmt = $pdo->prepare("UPDATE status_finger SET f_mode = :status WHERE id = 1");
        $stmt->bindParam(':status', $newStatus, PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode(['message' => 'Status updated successfully']);
    } else {
        echo json_encode(['error' => 'Invalid status value']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
