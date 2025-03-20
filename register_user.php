<!DOCTYPE html>
<html lang="en">
<?php include("layouts/generic/header.php"); ?>
<body>
<?php include("layouts/generic/navbar.php"); ?>
<style>
    body {
        background-image: linear-gradient(90deg, rgba(0, 0, 0, 0.466), rgba(34, 25, 25, 0.5)), url(assets/img/biometric.avif);
        background-attachment: fixed;
        background-size: cover;
        height: 100vh;
    }

    form {
        background-color: rgba(255, 255, 255, 0.137);
        backdrop-filter: blur(10px);
    }

    .form-group label {
        color: rgb(255, 255, 255);
    }
</style>
<div class="container">
    <h2 class="text-center my-5 text-white">Register</h2>

    <form id="registrationForm" method="POST">
    <!-- Form fields as provided -->
    <div class="form-group">
        <label for="id_first_name">First Name</label>
        <input type="text" name="first_name" id="id_first_name">
    </div>
    <div class="form-group">
        <label for="id_second_name">Second Name</label>
        <input type="text" name="second_name" id="id_second_name">
    </div>
    <div class="form-group">
        <label for="id_email">Email</label>
        <input type="email" name="email" id="id_email">
    </div>
    <div class="form-group">
        <label for="id_telephone">Telephone</label>
        <input type="number" name="telephone" id="id_telephone">
    </div>
    <div class="form-group">
        <label for="id_password">Password</label>
        <input type="password" name="password" id="id_password">
    </div>
    <div class="form-group">
        <label for="role">Register As</label>
        <select name="role" id="role">
            <option value="Admin">Admin</option>
            <option value="Student">Student</option>
            <option value="Lecture">Lecture</option>
        </select>
    </div>
    <!-- Student-specific fields -->
    <div class="form-group student-fields" style="display:none;">
        <label for="id_session">Session</label>
        <select name="session" id="id_session" class="form-control">
            <option value="DAY">Day</option>
            <option value="EVENING">Evening</option>
            <option value="WEEKEND">Weekend</option>
        </select>
    </div>
    <div class="form-group student-fields" style="display:none;">
        <label for="id_student_id">Student ID</label>
        <select name="student_id" id="id_student_id" class="form-control">
            <option value="">-- Select ID --</option>
            <?php for ($i = 1; $i <= 7; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php endfor; ?>
        </select>
    </div>
    <div class="form-group student-fields" style="display:none;">
        <label for="id_fingerprint">Fingerprint</label>
        <div class="input-group">
            <input type="text" name="fingerprint" maxlength="255" id="id_fingerprint" class="form-control" placeholder="Click 'Capture' to scan" readonly>
            <div class="input-group-append">
                <button class="btn btn-info" type="button" id="capture_fingerprint">Capture Fingerprint</button>
            </div>
        </div>
        <div id="fingerprint_status" class="mt-2 alert alert-info" style="display: none;"></div>
    </div>
    <!-- Admin-specific fields -->
    <div class="form-group admin-fields" style="display:none;">
        <label for="id_is_head_of_faculty">Is Head of Faculty</label>
        <input type="checkbox" name="is_hod" id="id_is_head_of_faculty">
    </div>
    <!-- LectureUser-specific fields -->
    <div class="form-group lectureuser-fields" style="display:none;">
        <label for="id_department">Department</label>
        <input type="text" name="department" id="id_department">
    </div>
    <button type="submit" class="btn btn-primary btn-block">Register</button>
    <div class="text-center mt-4">
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Toggle fields based on user type selection
        $("#role").change(function() {
            const userTyp = $("#role").val();
            console.log(userTyp);
            $(".student-fields, .admin-fields, .lectureuser-fields").hide();
            if (userTyp === "Student") {
                $(".student-fields").show();
            } else if (userTyp === "Admin") {
                $(".admin-fields").show();
            } else if (userTyp === "Lecture") {
                $(".lectureuser-fields").show();
            }
        });

        // Initial trigger to show/hide fields based on current selection
        $("#role").trigger("change");

        // Handle form submission via AJAX
        $("#registrationForm").on("submit", function(e) {
            e.preventDefault(); // Prevent the default form submission

            // Serialize form data
            // const formData = $(this).serialize();
            let formData = {
                first_name: $('#id_first_name').val(),
                second_name: $('#id_second_name').val(),
                email: $('#id_email').val(),
                telephone: $('#id_telephone').val(),
                password: $('#id_password').val(),
                role: $('#role').val(),
                session: $('#id_session').val(),
                student_id: $('#id_student_id').val(),
                fingerprint: $('#id_fingerprint').val(),
                is_hod: $('#id_is_head_of_faculty').is(':checked') ? 1 : 0,
                department: $('#id_department').val()
            };
            console.log(formData);
            // Send AJAX request
            $.ajax({
                url: "save_registration.php", // PHP file to handle the submission
                type: "POST",
                data: formData,
                success: function(response) {
                    alert(response.message); // Show success or error message
                    if (response.success) {
                        $("#registrationForm")[0].reset(); // Clear the form
                    }
                },
                error: function(xhr) {
                    alert("An error occurred. Please try again.");
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Toggle fields based on user type selection
        // Capture fingerprint button click handler
        $("#capture_fingerprint").click(function() {
            const studentID = $("#id_student_id").val();
            if (!studentID) {
                alert("Please select a Student ID first.");
                return;
            }

            // Update status
            $("#fingerprint_status").show().text("Connecting to fingerprint scanner...");

            // Send command to Arduino via backend
            $.ajax({
                url: "send_to_arduino.php", // Replace with your PHP endpoint
                type: "POST",
                contentType: "application/json",
                data: JSON.stringify({
                    student_id: studentID,
                    operation: "REGISTER"
                }),
                success: function(response) {
                    if (response.status === "success") {
                        $("#fingerprint_status").removeClass("alert-info alert-danger")
                            .addClass("alert-success")
                            .text("Scanner connected. Please place your finger on the scanner.");

                        // Start polling for fingerprint registration result
                        checkFingerprintStatus(studentID);
                    } else {
                        $("#fingerprint_status").removeClass("alert-info alert-success")
                            .addClass("alert-danger")
                            .text("Error: " + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMsg = "Failed to connect to fingerprint scanner";
                    try {
                        const response = JSON.parse(xhr.responseText);
                        errorMsg = response.message || errorMsg;
                    } catch (e) {}

                    $("#fingerprint_status").removeClass("alert-info alert-success")
                        .addClass("alert-danger")
                        .text("Error: " + errorMsg);
                }
            });
        });

        // Function to poll for fingerprint status
        function checkFingerprintStatus(studentID) {
            // Simulating success for demonstration
            setTimeout(function() {
                $("#id_fingerprint").val("FP" + studentID);
                $("#fingerprint_status").removeClass("alert-info alert-danger")
                    .addClass("alert-success")
                    .text("Fingerprint captured successfully!");
            }, 5000);
        }
    });
</script>
<?php include("layouts/generic/scripts.php"); ?>