<?php
include("../config/connection.php");

$alertScript = ""; // Initialize SweetAlert2 script variable

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $building = $_POST['building'];
    $floor = $_POST['floor'];
    $room_number = $_POST['room_number'];
    $capacity = $_POST['capacity'];

    // Prepare and bind statement
    $stmt = $conn->prepare("INSERT INTO classroom (name, building, floor, room_number, capacity) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $name, $building, $floor, $room_number, $capacity);

    // Execute the statement
    if ($stmt->execute()) {
        // Prepare SweetAlert2 script for successful creation and redirection
        $alertScript = "<script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Classroom added successfully!',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                window.location.href='classroom_list.php';
            });
        </script>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
  <!-- HEADER / LINKS / BASIC SCRIPTS -->
  <?php include("../layouts/header.php"); ?>
  <!-- END HEADER / LINKS / BASIC SCRIPTS -->
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <?php include("../layouts/admin/sidebar.php"); ?>
      <!-- End Sidebar -->

      <div class="main-panel">
        <!-- NAV BAR AND LOGO DIV -->
        <?php include("../layouts/navbar.php"); ?>
        <!-- END NAV BAR AND LOGO DIV -->

        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h3 class="fw-bold mb-3">Create Classroom</h3>
              <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                  <a href="#">
                    <i class="icon-home"></i>
                  </a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">Classrooms</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">Create</a>
                </li>
              </ul>
            </div>
          </div>
          
          <!-- Content -->
          <h2>Create Classroom</h2>
          <form method="POST" action="">
              <input type="text" name="name" class="form-control" placeholder="Classroom Name" required>
              <input type="text" name="building" class="form-control" placeholder="Building" required>
              <input type="text" name="floor" class="form-control" placeholder="Floor" required>
              <input type="text" name="room_number" class="form-control" placeholder="Room Number" required>
              <input type="number" name="capacity" class="form-control" placeholder="Capacity" required>
              <button type="submit" class="btn btn-primary">Submit</button>
          </form>
          
          <?php include("../layouts/admin/footer.php"); ?>
        </div>
      </div>
      <?php include("../layouts/scripts.php"); ?>
      <!-- Display SweetAlert2 message if set -->
      <?php
      if (!empty($alertScript)) {
          echo $alertScript;
      }
      ?>
    </div>
  </body>
</html>
