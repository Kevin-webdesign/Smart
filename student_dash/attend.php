<?php
// Include database connection
include("../config/connection.php");

// Check if $conn is defined
if (!isset($conn)) {
    die("Database connection failed");
}

// SQL Query
$sql = "SELECT * FROM attendance"; 
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
  <?php include("../layouts/header.php"); ?>
  <body>
    <div class="wrapper">
      <?php include("../layouts/student/sidebar.php");?>
      <div class="main-panel">
        <?php include("../layouts/navbar.php");?>

        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h3 class="fw-bold mb-3">Attendance Records</h3>
              <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                  <a href="#"><i class="icon-home"></i></a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="#">Attendance</a></li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="#">Records</a></li>
              </ul>
            </div>

            <div class="body">
              <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Student ID</th>
                      <th>Course</th>
                      <th>Entry Time</th>
                      <th>Entry Fingerprint Verified</th>
                      <th>Exit Time</th>
                      <th>Exit Fingerprint Verified</th>
                      <th>Had Extended Absence</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>".$row["student_id"]."</td>
                                <td>".$row["course"]."</td>
                                <td>".$row["entry_time"]."</td>
                                <td>".($row["entry_fingerprint_verified"] ? 'Yes' : 'No')."</td>
                                <td>".$row["exit_time"]."</td>
                                <td>".($row["exit_fingerprint_verified"] ? 'Yes' : 'No')."</td>
                                <td>".($row["had_extended_absence"] ? 'Yes' : 'No')."</td>
                              </tr>";
                      }
                    } else {
                      echo "<tr><td colspan='8'>No records found</td></tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <?php include("../layouts/student/footer.php");?>
      </div>
    </div>

    <?php 
    include("../layouts/scripts.php");
    // Close connection only if it exists
    if (isset($conn)) {
        $conn->close();
    }
    ?>
  </body>
</html>
