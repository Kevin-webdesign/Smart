<?php

const DB_HOST = "localhost";
const DB_USERNAME = "root";
const DB_PASSWORD = "";
const DB_DATABASE = "smart";

error_reporting(E_ERROR | E_PARSE);

$conn=mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if(mysqli_connect_errno())
{
echo "Connection Fail".mysqli_connect_error();
}

// Fetch the finger_status from the class_member_finger table where id = 1
$query = "SELECT f_mode FROM status_finger WHERE id = 1";
$result = mysqli_query($conn, $query);

// Check if the query executed successfully
if ($result) {
    // Fetch the row from the query result
    $row = mysqli_fetch_assoc($result);

    // Check if the row has the finger_status column
    if (isset($row['f_mode'])) {
        // Output the finger_status value
        echo $row['f_mode'];
    } else {
        echo "No finger status found for ID = 1.";
    }
} else {
    // Error if the query fails
    echo "Error: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
