<?php
include("../config/connection.php");

// Fetch courses from course table
$sql = "SELECT name FROM course";
$result = $conn->query($sql);

// Fetch classrooms from classroom table
$room = "SELECT name FROM classroom";
$roomres = $conn->query($room);

// Initialize alert script variable
$alertScript = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course = $conn->real_escape_string($_POST['course']);
    $classroom = $conn->real_escape_string($_POST['classroom']);
    $date = $conn->real_escape_string($_POST['date']);
    $start_time = $conn->real_escape_string($_POST['start_time']);
    $end_time = $conn->real_escape_string($_POST['end_time']);
    $session_type = $conn->real_escape_string($_POST['session_type']);

    $insertQuery = "INSERT INTO classsession (course, classroom, date, start_time, end_time, session_type) VALUES ('$course', '$classroom', '$date', '$start_time', '$end_time', '$session_type')";
    
    if ($conn->query($insertQuery) === TRUE) {
        $alertScript = "<script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Course added successfully!',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                window.location.href = 'classsession_list.php';
            });
        </script>";
    } else {
        echo "Error: " . $insertQuery . "<br>" . $conn->error;
    }
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
              <h3 class="fw-bold mb-3">Create Class Session</h3>
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
                  <a href="#">Sessions</a>
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
          <h2>Create Class Session</h2>
          <form method="POST" action="">
            <select name="course" class="form-control" required>
              <?php while ($row = $result->fetch_assoc()) { ?>
                <option value="<?php echo $row['name']; ?>">
                  <?php echo $row['name']; ?>
                </option>
              <?php } ?>
            </select>
            <select name="classroom" class="form-control">
              <?php while ($row = $roomres->fetch_assoc()) { ?>
                <option value="<?php echo $row['name']; ?>">
                  <?php echo $row['name']; ?>
                </option>
              <?php } ?>
            </select>
            <input type="date" name="date" class="form-control" required>
            <input type="time" name="start_time" class="form-control" required>
            <input type="time" name="end_time" class="form-control" required>
            <select name="session_type" class="form-control">
              <option value="DAY">DAY</option>
              <option value="EVENING">EVENING</option>
              <option value="WEEKEND">WEEKEND</option>
            </select>
            <button type="submit" class="btn btn-primary mt-2">Submit</button>
          </form>
          
          <?php include("../layouts/admin/footer.php"); ?>
        </div>
      </div>
      <?php include("../layouts/scripts.php"); ?>
      
      <!-- Display SweetAlert2 message if session was created successfully -->
      <?php
      if (!empty($alertScript)) {
          echo $alertScript;
      }
      ?>
    </div>
  </body>
</html>
