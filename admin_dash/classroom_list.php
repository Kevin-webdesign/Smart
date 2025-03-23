<?php
include("../config/connection.php");
                  // Fetch courses and their corresponding lecturers
      $sql = "SELECT name, building, floor, room_number, capacity
              FROM classroom";
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
<a class="btn btn-primary" href="classroom_form.php">
    <i class="fas fa-users"></i>
    <p>Classrooms</p>
</a>
</li>
<h2>Classroom List</h2>
<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Building</th>
            <th>Floor</th>
            <th>Room Number</th>
            <th>Capacity</th>
        </tr>
    </thead>
    <tbody>
      <?php
          if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['name'] . "</td>
                        <td>" . $row['building'] . "</td>
                        <td>" . $row['floor'] . "</td>
                        <td>" . $row['room_number'] . "</td>
                        <td>" . $row['capacity']. "</td>
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
