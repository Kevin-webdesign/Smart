<?php
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
$first_name = $_POST['first_name'];
$second_name = $_POST['second_name'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$role = $_POST['role'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

// Insert into BaseUser table
try {
    $stmt = $pdo->prepare("INSERT INTO baseuser (first_name, second_name, email, telephone, password, user_type) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$first_name, $second_name, $email, $telephone, $password, $role]);
    $user_id = $pdo->lastInsertId(); // Get the last inserted user ID

    // Insert into role-specific tables
    if ($role === 'Admin') {
        $is_hod = isset($_POST['is_hod']) ? 1 : 0;
        $stmt = $pdo->prepare("INSERT INTO AdminProfile (user_id, is_head_of_faculty) VALUES (?, ?)");
        $stmt->execute([$user_id, $is_hod]);
    } elseif ($role === 'Student') {
        $stmt = $pdo->query("SELECT student_id FROM StudentProfile ORDER BY student_id DESC LIMIT 1");
        $last_student_id = $stmt->fetchColumn(); // Get the last student_id
        $new_student_id = $last_student_id ? $last_student_id + 1 : 1; // Increment the student_id or set it to 1 if there are no entries

        // Set the session and fingerprint as before
        $session = $_POST['session'];
        $fingerprint = $_POST['fingerprint'];

        // Insert into the StudentProfile table
        $stmt = $pdo->prepare("INSERT INTO StudentProfile (user_id, session, student_id, fingerprint) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $session, $new_student_id, $fingerprint]);

        // After inserting the student profile, update the status_finger table
        $stmt = $pdo->prepare("UPDATE status_finger SET f_status = 0 WHERE id = 1");
        $stmt->execute();
    } elseif ($role == 'Lecture') {
        $department = $_POST['department'];
        $stmt = $pdo->prepare("INSERT INTO LecturerProfile (user_id, department) VALUES (?, ?)");
        $stmt->execute([$user_id, $department]);
    }

    echo json_encode(['success' => true, 'message' => 'Registration successful!']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}