<!-- landing_page.html -->

<!DOCTYPE html>
<html lang="en">
<?php include("layouts/generic/header.php");?>

<body >
    <style>
        body{
            background-image: linear-gradient(90deg ,rgba(0, 0, 0, 0.466),rgba(34, 25, 25, 0.5)),url(assets/img/biometric.avif);
            background-attachment: fixed;
            background-size:cover ;
        }
        h1{
            font-size: 60px;
            font-weight: bold;
        }
    </style>
    
<!-- Navbar -->
<?php include("layouts/generic/navbar.php");?>

    <div class="container text-center">
        <h1 class="my-5 text-white">Welcome to the Smart Attendance System</h1>
        <p class="text-white">Choose your action below:</p>
    
        <div class="d-flex justify-content-center my-4">
            <a href="register_user.php" class="btn btn-primary mx-2">Register</a>
            <a href="login.php" class="btn btn-secondary mx-2">Login</a>
        </div>
    
        <footer class="mt-5">
            <p>&copy; 2025 Smart attendance</p>
        </footer>
    </div>
    <?php include("layouts/generic/scripts.php");?>
</body>
</html>

