<?php
include("../config/connection.php");

// Fetch registered students along with module info
$regsql = "SELECT 
    m.`id` AS module_id,
    m.`name` AS module_name,
    m.`code` AS module_code,
    m.`description` AS module_description,
    m.`sessions_offered` AS session_offered,
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

// Check if query was successful
if ($regresult === false) {
    die("Error executing query: " . $conn->error);
}

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
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Registered Students</h2>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Email</th>
                        <th>Session</th>
                        <th>Module</th>
                        <th>Lecturer</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if ($regresult->num_rows > 0) {
                    while ($row = $regresult->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['email']) . "</td>
                                <td>" . htmlspecialchars($row['session_offered']) . "</td>
                                <td>". htmlspecialchars($row['module_name']) . "</td>
                                <td>". htmlspecialchars($row['lecturer']) . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>No students registered yet.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include("../layouts/lecture/footer.php");?>
</div>
</div>
<?php include("../layouts/scripts.php");?>
</body>
</html>