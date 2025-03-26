<?php
const DB_HOST = "localhost";
const DB_USERNAME = "root";
const DB_PASSWORD = "";
const DB_DATABASE = "smart";

error_reporting(E_ERROR | E_PARSE);

$conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if (mysqli_connect_errno()) {
    die("Connection Fail: " . mysqli_connect_error());
}

if (isset($_GET['scanned'])) {
    // Step 2: Get the 'enrolled' value from the GET request
    $enrolled = $_GET['scanned'];

    // Step 3: Validate the 'enrolled' value
    if (empty($enrolled)) {
        die("Error: 'enrolled' parameter is empty.");
    }

    // Step 4: Fetch existing value from 'attended' column
    $sql_select = "SELECT attended FROM status_finger WHERE id = 1";
    $result = $conn->query($sql_select);

    if ($result && $row = $result->fetch_assoc()) {
        $existing_attended = $row['attended'];

        // Step 5: Append new value with comma separation
        if (!empty($existing_attended)) {
            $new_attended = $existing_attended . ',' . $enrolled;
        } else {
            $new_attended = $enrolled;
        }

        // Step 6: Update the database with the new value
        $sql_update = "UPDATE status_finger SET attended = ? WHERE id = 1";

        if ($stmt = $conn->prepare($sql_update)) {
            $stmt->bind_param("s", $new_attended);

            if ($stmt->execute()) {
                echo "Record updated successfully. New attended list: $new_attended";
            } else {
                echo "Error updating record: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error preparing query: " . $conn->error;
        }
    } else {
        echo "Error fetching existing data: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Error: 'enrolled' parameter is missing in the request.";
}
?>
