<?php
include("../config/connection.php");

// Fetch registered students along with module info
$regsql = "SELECT 
    m.`id` AS module_id,
    m.`name` AS module_name,
    m.`code` AS module_code,
    m.`description` AS module_description,
    m.`Sessions Offered` AS session_offered,
    m.`Lecturer` AS lecturer,
    b.`id` AS user_id,
    b.`first_name`,
    b.`second_name`,
    b.`email`,
    b.`user_type`,
    b.`created_at`,
    b.`updated_at`
FROM 
    `moduleregistration` m
INNER JOIN 
    `baseuser` b
ON 
    m.`user_id` = b.`id`";

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
      <?php include("../layouts/lecture/sidebar.php");?>
      <!-- End Sidebar -->

      <div class="main-panel">
        <!-- NAV BAR AND LOGO DIV -->
        <?php include("../layouts/navbar.php");?>
        <!-- END NAV BAR AND LOGO DIV -->

        <div class="container">
          <div class="page-inner">
            
          <div class="page-header">
              <h3 class="fw-bold mb-3">Registered Students</h3>
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
                  <a href="#">Modules</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">Registered Students</a>
                </li>
              </ul>
            </div>
          </div>
          
           <!-- content -->
<h2>Registered Students</h2>
<table class="table">
    <thead>
        <tr><th>User Id</th>
            <th>First Name</th>
            <th>Second Name</th>
            <th>Email</th>
            <th>Session</th>
        </tr>
    </thead>
    <tbody>
    <?php
      if ($regresult->num_rows > 0) {
          while ($row = $regresult->fetch_assoc()) {
              echo "<tr>
                      <td>" . htmlspecialchars($row['user_id']) . "</td>
                      <td>" . htmlspecialchars($row['first_name']) . "</td>
                      <td>" . htmlspecialchars($row['second_name']) . "</td>
                      <td>" . htmlspecialchars($row['email']) . "</td>
                      <td>" . htmlspecialchars($row['session_offered']) . "</td>
                    </tr>";
          }
      } else {
          echo "<tr><td colspan='4'>No students registered yet.</td></tr>";
      }
    ?>
    </tbody>
</table>
<?php include("../layouts/lecture/footer.php");?>
</div>
</div>
<?php include("../layouts/scripts.php");?>
</body>

</html>
