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

if (isset($_GET['enrolled'])) {
    // Step 2: Get the 'enrolled' value from the GET request
    $enrolled = $_GET['enrolled'];

    // Step 3: Validate the 'enrolled' value (optional but recommended)
    if (empty($enrolled)) {
        die("Error: 'enrolled' parameter is empty.");
    }

    // Step 5: Prepare the update query
    $sql = "UPDATE status_finger SET f_status = ? WHERE id = 1";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameter (assuming 'finger_number' is a string, change 's' to 'i' for integers)
        $stmt->bind_param("s", $enrolled);
        
        // Execute the query
        if ($stmt->execute()) {
            echo "Record updated successfully.";
        } else {
            echo "Error updating record: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing query: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // Error message if 'enrolled' parameter is not present in the GET request
    echo "Error: 'enrolled' parameter is missing in the request.";
}
?>
