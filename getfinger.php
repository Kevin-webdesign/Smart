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

// Fetch all f_status from status_finger using mysqli
$query = "SELECT f_status FROM status_finger";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Error executing query: " . mysqli_error($conn);
    exit();
}

// Fetch all f_status and store them in an array
$finger_numbers = [];
while ($row = mysqli_fetch_assoc($result)) {
    $finger_numbers[] = $row['f_status'];
}

// Join all values into a single string, separated by a comma (or any other separator you prefer)
echo implode($finger_numbers);

// Close the connection
mysqli_close($conn);
?>

