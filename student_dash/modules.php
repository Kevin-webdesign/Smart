<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User ID not found in session. Please log in again.");
}

$user_id = $_SESSION['user_id'];
include("../config/connection.php");

// Fetch all available courses
$sql = "SELECT name, code, description, sessions_offered, lecturer FROM course";
$result = $conn->query($sql);

// Handle module registration
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $module_code = $_POST['module_code'];
    $module_name = $_POST['module_name'];
    $module_description = $_POST['module_description'];
    $sessions_offered = $_POST['sessions_offered'];
    $lecturer = $_POST['lecturer'];

    // Check if already registered
    $check_sql = "SELECT * FROM moduleregistration WHERE code = ? AND user_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("si", $module_code, $user_id);
    $check_stmt->execute();
    
    if ($check_stmt->get_result()->num_rows > 0) {
        echo "<script>alert('You are already registered for this module!');</script>";
    } else {
        // Register the module
        $insert_sql = "INSERT INTO moduleregistration (name, code, description, sessions_offered, lecturer, user_id) 
                      VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("sssssi", $module_name, $module_code, $module_description, 
                         $sessions_offered, $lecturer, $user_id);
        
        if ($stmt->execute()) {
            echo "<script>alert('Module registered successfully!');</script>";
            echo "<script>window.location.href=window.location.href;</script>";
            exit();
        } else {
            echo "<script>alert('Error: " . addslashes($stmt->error) . "');</script>";
        }
        $stmt->close();
    }
    $check_stmt->close();
}

// Fetch user's registered modules
$regsql = "SELECT m.name, m.code, m.description, m.sessions_offered, m.lecturer 
           FROM moduleregistration m
           WHERE m.user_id = ?";
$regstmt = $conn->prepare($regsql);
$regstmt->bind_param("i", $user_id);
$regstmt->execute();
$regresult = $regstmt->get_result();

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
  <!-- Registered Modules -->
  <div class="card mt-4">
              <div class="card-header">
                <h4 class="card-title">My Registered Modules</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" id="registered-modules">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Sessions</th>
                        <th>Lecturer</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if ($regresult->num_rows > 0): ?>
                        <?php while ($reg_row = $regresult->fetch_assoc()): ?>
                          <tr>
                            <td><?= htmlspecialchars($reg_row['name']) ?></td>
                            <td><?= htmlspecialchars($reg_row['code']) ?></td>
                            <td><?= htmlspecialchars($reg_row['description']) ?></td>
                            <td><?= htmlspecialchars($reg_row['sessions_offered']) ?></td>
                            <td><?= htmlspecialchars($reg_row['lecturer']) ?></td>
                          </tr>
                        <?php endwhile; ?>
                      <?php else: ?>
                        <tr><td colspan="5" class="text-center">No registered modules yet</td></tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
    
<?php include("../layouts/student/footer.php");?>
</div>
</div>
<?php include("../layouts/scripts.php");?>
</body>

</html>