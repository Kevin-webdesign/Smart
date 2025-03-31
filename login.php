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
        <h2 class="text-center my-5 text-white">Login</h2>
      
        <form id="loginForm" method="POST">
            <div class="form-group">
                <label for="id_email">Email</label>
                <input type="email" name="email" id="id_email" required>
            </div>
            <div class="form-group">
                <label for="id_password">Password</label>
                <input type="password" name="password" id="id_password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
            
        <div class="text-center mt-4">
            <p>Don't have an account? <a href="register_user.php">Register</a></p>
        </div>
    </div>
    <?php include("layouts/generic/scripts.php"); ?>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    $(document).ready(function() {
        $("#loginForm").on("submit", function(e) {
            e.preventDefault(); // Prevent the default form submission

            // Create form data object
            let formData = {
                email: $('#id_email').val(),
                password: $('#id_password').val()
            };
            console.log("formData ", formData);

            // Send AJAX request
            $.ajax({
                url: "login_handler.php",
                type: "POST",
                data: formData,
                success: function(response) {
                    if (response.redirect) {
                        // Show welcome message and then redirect
                        Swal.fire({
                            icon: 'success',
                            title: 'Welcome',
                            text: 'Login successful!',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = response.redirect;
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message,
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred. Please try again.'
                    });
                }
            });
        });
    });
    </script>
</body>
</html>
