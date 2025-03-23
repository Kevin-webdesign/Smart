<?php
include("../config/connection.php");

// Fetch registered modules
$regsql = "SELECT name, code, description, lecturer FROM moduleregistration";
$regresult = $conn->query($regsql);

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
      <?php include("../layouts/student/sidebar.php");?>
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
<h2>Registered Modules</h2>
<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Code</th>
            <th>Description</th>
            <th>Lecture</th>
        </tr>
    </thead>
    <tbody>
      <?php
      if ($regresult->num_rows > 0) {
                // Output data of each row
                while ($row = $regresult->fetch_assoc()) {
                  echo "<tr>
                          <td>" . htmlspecialchars($row['name']) . "</td>
                          <td>" . htmlspecialchars($row['code']) . "</td>
                          <td>" . htmlspecialchars($row['description']) . "</td>
                          <td>" . htmlspecialchars($row['lecturer']) . "</td>
                        </tr>";
                }
              } else {
                echo "<tr><td colspan='4'>No modules registered yet.</td></tr>";
              }
              ?>
    </tbody>
</table>
<?php include("../layouts/student/footer.php");?>
</div>
</div>
<?php include("../layouts/scripts.php");?>
</body>

</html>