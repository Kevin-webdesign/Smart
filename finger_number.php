<?php
const DB_HOST = "localhost";
const DB_USERNAME = "root";
const DB_PASSWORD = "";
const DB_DATABASE = "smart";

error_reporting(E_ERROR | E_PARSE);

// Establish MySQL connection using mysqli
$conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if(mysqli_connect_errno()) {
    echo "Connection Failed: " . mysqli_connect_error();
    exit();
}

// Fetch all existing finger numbers
$query = "SELECT fingerprint FROM studentprofile";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Error executing query: " . mysqli_error($conn);
    exit();
}

// Fetch all fingerprint numbers and store them in an array
$finger_numbers = [];
while ($row = mysqli_fetch_assoc($result)) {
    $finger_numbers[] = $row['fingerprint'];
}

if ($finger_numbers) {
    // Use a boolean array (faster lookup)
    $finger_map = array_fill(1, 255, false);

    foreach ($finger_numbers as $finger_number) {
        $finger_number = (int) $finger_number;
        if ($finger_number >= 1 && $finger_number <= 255) {
            $finger_map[$finger_number] = true;
        }
    }

    // Find the first missing finger number
    for ($i = 1; $i <= 255; $i++) {
        if (!$finger_map[$i]) {
            echo $i;
            exit;
        }
    }
}

// If all numbers from 1 to 255 are taken
echo "1";

// Close the connection
mysqli_close($conn);
?>
