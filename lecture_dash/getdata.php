<?php
// Database connection settings
$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "smart"; // Your database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize an array to hold the results
$output = array();

// Query to get the attended fingerprints from the status_finger table
$sql = "SELECT attended FROM status_finger LIMIT 1"; // Assuming you only need the first row or adjust the query accordingly
$result = $conn->query($sql);

// Check if there's a result
if ($result->num_rows > 0) {
    // Fetch the row
    $row = $result->fetch_assoc();
    $attended_fingerprints = $row['attended']; // This will be a string like "23,54,32,76"
    
    // Convert the comma-separated string into an array
    $fingerprint_array = explode(",", $attended_fingerprints);
    
    // Iterate through the array and fetch matching student profiles
    foreach ($fingerprint_array as $fingerprint) {
        $fingerprint = trim($fingerprint); // Clean up any extra spaces
        
        // Query to find students with the same fingerprint in the studentprofile table
        $sql_students = "SELECT user_id FROM studentprofile WHERE fingerprint = '$fingerprint'";
        $student_result = $conn->query($sql_students);
        
        // Check if there's a match in studentprofile table
        if ($student_result->num_rows > 0) {
            while ($student_row = $student_result->fetch_assoc()) {
                $student_id = $student_row['user_id'];
                
                // Query to match the student ID with the baseuser table and retrieve the second_name
                $sql_baseuser = "SELECT id, second_name FROM baseuser WHERE id = '$student_id'";
                $baseuser_result = $conn->query($sql_baseuser);
                
                // Check if there's a match in baseuser table
                if ($baseuser_result->num_rows > 0) {
                    while ($baseuser_row = $baseuser_result->fetch_assoc()) {
                        // Add the matched baseuser to the output array
                        $output[] = array(
                            "second_name" => $baseuser_row['second_name'],
                            "student_id" => $student_id
                        );
                    }
                } else {
                    $output[] = array(
                        "message" => "No match found in baseuser table for student ID: $student_id",
                        "student_id" => $student_id
                    );
                }
            }
        } else {
            $output[] = array(
                "message" => "No match found for fingerprint: $fingerprint in studentprofile table.",
                "fingerprint" => $fingerprint
            );
        }
    }
} else {
    $output[] = array("message" => "No attended fingerprints found in the status_finger table.");
}

// Output the result in JSON format
echo json_encode($output, JSON_PRETTY_PRINT);

// Close the database connection
$conn->close();
?>
