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

// Initialize SweetAlert2 script variable
$alertScript = "";

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
        $alertScript = "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'You are already registered for this module!'
            });
        </script>";
    } else {
        // Register the module
        $insert_sql = "INSERT INTO moduleregistration (name, code, description, sessions_offered, lecturer, user_id) 
                      VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("sssssi", $module_name, $module_code, $module_description, 
                         $sessions_offered, $lecturer, $user_id);
        
        if ($stmt->execute()) {
            $alertScript = "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Module registered successfully!',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = window.location.href;
                });
            </script>";
        } else {
            $alertScript = "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error: " . addslashes($stmt->error) . "'
                });
            </script>";
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
  <?php include("../layouts/header.php"); ?>
  
  <body>
    <div class="wrapper">
      <?php include("../layouts/student/sidebar.php"); ?>
      
      <div class="main-panel">
        <?php include("../layouts/navbar.php"); ?>
        
        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h3 class="fw-bold mb-3">Module Registration</h3>
              <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                  <a href="#"><i class="icon-home"></i></a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="#">Modules</a></li>
              </ul>
            </div>

            <!-- Available Modules -->
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Available Modules</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" id="available-modules">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Sessions</th>
                        <th>Lecturer</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                          <?php
                          // Check if already registered
                          $is_registered = false;
                          $regresult->data_seek(0);
                          while ($reg_row = $regresult->fetch_assoc()) {
                              if ($reg_row['code'] == $row['code']) {
                                  $is_registered = true;
                                  break;
                              }
                          }
                          $regresult->data_seek(0);
                          if (!$is_registered): ?>
                            <tr>
                              <td><?= htmlspecialchars($row['name']) ?></td>
                              <td><?= htmlspecialchars($row['code']) ?></td>
                              <td><?= htmlspecialchars($row['description']) ?></td>
                              <td><?= htmlspecialchars($row['sessions_offered']) ?></td>
                              <td><?= htmlspecialchars($row['lecturer']) ?></td>
                              <td>
                                <form method="POST">
                                  <input type="hidden" name="module_code" value="<?= htmlspecialchars($row['code']) ?>">
                                  <input type="hidden" name="module_name" value="<?= htmlspecialchars($row['name']) ?>">
                                  <input type="hidden" name="module_description" value="<?= htmlspecialchars($row['description']) ?>">
                                  <input type="hidden" name="sessions_offered" value="<?= htmlspecialchars($row['sessions_offered']) ?>">
                                  <input type="hidden" name="lecturer" value="<?= htmlspecialchars($row['lecturer']) ?>">
                                  <button type="submit" name="register" class="btn btn-success btn-sm">
                                    <i class="fa fa-plus"></i> Register
                                  </button>
                                </form>
                              </td>
                            </tr>
                          <?php endif; ?>
                        <?php endwhile; ?>
                      <?php else: ?>
                        <tr><td colspan="6" class="text-center">No available modules found</td></tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

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
          
          <?php include("../layouts/student/footer.php"); ?>
        </div>
      </div>
    </div>
    
    <?php include("../layouts/scripts.php"); ?>
    
    <!-- Display SweetAlert2 message if set -->
    <?php
    if (!empty($alertScript)) {
        echo $alertScript;
    }
    ?>
  </body>
</html>
