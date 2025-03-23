 <?php
include("../config/connection.php");
                  // Fetch courses and their corresponding lecturers
      $sql = "SELECT name, code, description, sessions_offered, lecturer
              FROM course";
      $result = $conn->query($sql);

      $conn->close();
       ?>
<!DOCTYPE html>
<html lang="en">
  <!-- HEADER / LINKS / BASIC SCRIPTS -->
  <?php include("../layouts/header.php"); ?>
  <!-- END HEADER / LINKS / BASIC SCRIPTS -->
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
          <a class="btn btn-primary" href="course_form.php">
              <i class="fas fa-home"></i>
              <p>Add Course</p>
          </a>

          <h2>Course List</h2>
          <table class="table">
              <thead>
                  <tr>
                      <th>Name</th>
                      <th>Code</th>
                      <th>Description</th>
                      <th>Sessions Offered</th>
                      <th>Lecturer</th>
                  </tr>
              </thead>
              <tbody>
              <?php
              if ($result->num_rows > 0) {
                      // Output data of each row
                      while($row = $result->fetch_assoc()) {
                          echo "<tr>
                                  <td>" . $row['name'] . "</td>
                                  <td>" . $row['code'] . "</td>
                                  <td>" . $row['description'] . "</td>
                                  <td>" . $row['sessions_offered'] . "</td>
                                  <td>" . $row['lecturer']. "</td>
                                </tr>";
                      }
                  } else {
                      echo "<tr><td colspan='5'>No courses found</td></tr>";
                  }
                  ?>
              </tbody>
          </table>
        </div>
      </div>
    </div>

    <?php include("../layouts/scripts.php");?>
  </body>
</html>
