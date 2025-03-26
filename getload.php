<?php
const DB_HOST = "localhost";
const DB_USERNAME = "root";
const DB_PASSWORD = "";
const DB_DATABASE = "smart";

error_reporting(E_ERROR | E_PARSE);

// Improved connection handling with exception
$conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if 'load' parameter exists
if (isset($_GET['load'])) {
    // Step 2: Get the 'load' value from the GET request and sanitize it
    $load = mysqli_real_escape_string($conn, $_GET['load']);

    // Step 3: Validate the 'load' value
    if (empty($load)) {
        die("Error: 'load' parameter is empty.");
    }

    // Step 4: Prepare the update query (without subquery)
    $sql = "UPDATE attendance SET had_extended_absence = ? ORDER BY id DESC LIMIT 1";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameter (assuming 'load' is a string, change 's' to 'i' for integers)
        $stmt->bind_param("s", $load);
        
        // Execute the query
        if ($stmt->execute()) {
            // Step 5: Fetch the course name from the last record in the attendance table
            $result = mysqli_query($conn, "SELECT course FROM attendance ORDER BY id DESC LIMIT 1");
            $row = mysqli_fetch_assoc($result);
            $course_name = $row['course'];

            // Step 6: Get current time (current date and time)
            $current_time = date('d-m-Y/H:i:s');

            // Step 7: Include the EmailJS script
            echo "
            <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js'></script>
            <script type='text/javascript'>
                emailjs.init('pslPe7HbdFtEyc2EK');  // Initialize EmailJS with your user ID                       
                // Send the email using EmailJS
                emailjs.send('service_e5urxqk', 'template_421ixxa', {
                    Course_name: '$course_name',
                    time: '$current_time',
                    email: 'donaldirene250@gmail.com'
                })
                .then(function(response) {
                    console.log('Success:', response);
                }, function(error) {
                    console.log('Error:', error);
                    alert('Failed to send email.');
                });
            </script>";
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
    // Error message if 'load' parameter is not present in the GET request
    echo "Error: 'load' parameter is missing in the request.";
}
?>
