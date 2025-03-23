<?php
include("../config/connection.php");
                  // Fetch courses and their corresponding lecturers
      $sql = "SELECT course, classroom, date, start_time, end_time, session_type
              FROM classsession";
      $result = $conn->query($sql);

      $conn->close();
       ?>
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
              <h3 class="fw-bold mb-3"></h3>
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
                  <a href="#"></a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#"></a>
                </li>
              </ul>
            </div>
          </div>
          
           <!-- content -->

<a class="btn btn-primary" href="classsession_form.php">
    <i class="fas fa-user"></i>
    <p>create class session</p>
</a>
<h2>Class Session List</h2>
<table class="table">
    <thead>
        <tr>
            <th>Course</th>
            <th>Classroom</th>
            <th>Date</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Session Type</th>
        </tr>
    </thead>
    <tbody>
    <?php
          if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['course'] . "</td>
                        <td>" . $row['classroom'] . "</td>
                        <td>" . $row['date'] . "</td>
                        <td>" . $row['start_time'] . "</td>
                        <td>" . $row['end_time']. "</td>
                        <td>" . $row['session_type']. "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No courses found</td></tr>";
        }
      ?>
    </tbody>
</table>
<?php include("../layouts/admin/footer.php");?>
      </div>
    </div>
    <?php include("../layouts/scripts.php");?>
  </body>

</html>
