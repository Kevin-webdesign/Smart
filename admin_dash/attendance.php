<!DOCTYPE html>
<html lang="en">
  <!-- HEADER / LINKS /  BASIC SCRIPTS -->
  <?php include("../layouts/header.php"); ?>
  <!-- END HEADER / LINKS /  BASIC SCRIPTS -->
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <?php include("../layouts/admin/sidebar.php");?>
      <!-- End Sidebar -->

      <div class="main-panel">
        <!-- NAV BAR AND LOGO DIV -->
        <?php include("../layouts/navbar.php");?>
        <!-- END NAV BAR AND LOGO DIV -->

        <div class="container">
          <div class="page-inner">
            
            <div class="page-header">
              <h3 class="fw-bold mb-3">Attendance Records</h3>
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
                  <a href="#">Attendance</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">Records</a>
                </li>
              </ul>
            </div>

            <div class="body">
              <div class="card">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Student ID</th>
                          <th>Class Session ID</th>
                          <th>Entry Time</th>
                          <th>Entry Fingerprint Verified</th>
                          <th>Exit Time</th>
                          <th>Exit Fingerprint Verified</th>
                          <th>Had Extended Absence</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        // Include database connection
                        include("../config/connection.php");

                        // Fetch data from the attendance table
                        $sql = "SELECT * FROM attendance";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                          // Output data of each row
                          while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>".$row["id"]."</td>
                                    <td>".$row["student_id"]."</td>
                                    <td>".$row["class_session_id"]."</td>
                                    <td>".$row["entry_time"]."</td>
                                    <td>".($row["entry_fingerprint_verified"] ? 'Yes' : 'No')."</td>
                                    <td>".$row["exit_time"]."</td>
                                    <td>".($row["exit_fingerprint_verified"] ? 'Yes' : 'No')."</td>
                                    <td>".($row["had_extended_absence"] ? 'Yes' : 'No')."</td>
                                  </tr>";
                          }
                        } else {
                          echo "<tr><td colspan='10'>No records found</td></tr>";
                        }
                        $conn->close();
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

        <?php include("../layouts/admin/footer.php");?>
      </div>
    </div>
    <?php include("../layouts/scripts.php");?>
  </body>
</html>