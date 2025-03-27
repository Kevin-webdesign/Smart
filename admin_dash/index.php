<?php
include("../config/connection.php");

// Query to fetch students with session and fingerprint data
$sql = "SELECT 
            b.first_name, 
            b.second_name, 
            b.email, 
            b.telephone, 
            sp.student_id, 
            sp.session, 
            sp.fingerprint
        FROM baseuser b
        INNER JOIN studentprofile sp ON b.id = sp.user_id
        WHERE b.user_type = 'Student'";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
  <!-- HEADER / LINKS / BASIC SCRIPTS -->
  <?php include("../layouts/header.php"); ?>
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
              <h3 class="fw-bold mb-3">Admin Dashboard</h3>
              <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                  <a href="#">
                    <i class="icon-home"></i>
                  </a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="#">Dashboard</a></li>
              </ul>
            </div>

            <!-- Dashboard Content -->
            <h1 class="text-center mb-4">Welcome to Smart Attendance</h1>
            <div class="row">
              <!-- Quick Actions -->
              <div class="col-md-4">
                <div class="card text-center">
                  <div class="card-body">
                    <i class="fas fa-user fa-3x text-primary"></i>
                    <h5 class="mt-3">Student Records</h5>
                    <a href="studentrec.php" class="btn btn-primary mt-2">View Records</a>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card text-center">
                  <div class="card-body">
                    <i class="fas fa-chalkboard-teacher fa-3x text-success"></i>
                    <h5 class="mt-3">Lecture Records</h5>
                    <a href="lecturerec.php" class="btn btn-success mt-2">View Lecturers</a>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card text-center">
                  <div class="card-body">
                    <i class="fas fa-chart-line fa-3x text-warning"></i>
                    <h5 class="mt-3">Attendance Record</h5>
                    <a href="attendance.php" class="btn btn-warning mt-2">View Attendance</a>
                  </div>
                </div>
              </div>
            </div>

            <!-- Student Records Table -->
            <div class="card mt-4">
              <div class="card-body">
              <h1>Student Records</h1>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Second Name</th>
                                    <th>Email</th>
                                    <th>Telephone</th>
                                    <th>Student ID</th>
                                    <th>Session</th>
                                    <th>Fingerprint</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                                <td>{$row['first_name']}</td>
                                                <td>{$row['second_name']}</td>
                                                <td>{$row['email']}</td>
                                                <td>{$row['telephone']}</td>
                                                <td>{$row['student_id']}</td>
                                                <td>{$row['session']}</td> 
                                                <td>" . (!empty($row['fingerprint']) ? '✔' : '✖') . "</td> 
                                            </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No student records found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
              </div>
            </div>
          </div>
          <?php include("../layouts/admin/footer.php"); ?>
        </div>
      </div>
      <?php include("../layouts/scripts.php"); ?>
    </body>
</html>
