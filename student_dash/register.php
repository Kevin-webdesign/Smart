 <?php
include("../config/connection.php");

// Fetch courses and their corresponding lecturers
$sql = "SELECT name, code, description, sessions_offered, lecturer FROM course";
$result = $conn->query($sql);

// Handle module registration
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $module_code = $_POST['module_code'];
    $module_name = $_POST['module_name'];
    $module_description = $_POST['module_description'];
    $sessions_offered = $_POST['sessions_offered'];
    $lecturer = $_POST['lecturer'];

    // Insert into moduleregistration table
    $insert_sql = "INSERT INTO moduleregistration (name, code, description, `Sessions Offered`, Lecturer) 
                   VALUES (?, ?, ?, ?, ?)";
    
    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("sssss", $module_name, $module_code, $module_description, $sessions_offered, $lecturer);
    
    if ($stmt->execute()) {
        echo "<script>alert('Module registered successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . addslashes($stmt->error) . "');</script>";
    }
    $stmt->close();
}

// Fetch registered modules
$regsql = "SELECT name, code, description, lecturer FROM moduleregistration";
$regresult = $conn->query($regsql);

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
      <?php include("../layouts/student/sidebar.php"); ?>
      <!-- End Sidebar -->

      <div class="main-panel">
        <!-- NAV BAR AND LOGO DIV -->
        <?php include("../layouts/navbar.php"); ?>
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

          <!-- Content -->
          <h2>Available Modules</h2>
          <table class="table">
            <thead>
              <tr>
                <th>Name</th>
                <th>Code</th>
                <th>Description</th>
                <th>Sessions Offered</th>
                <th>Lecturer</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                  echo "<tr>
                          <td>" . htmlspecialchars($row['name']) . "</td>
                          <td>" . htmlspecialchars($row['code']) . "</td>
                          <td>" . htmlspecialchars($row['description']) . "</td>
                          <td>" . htmlspecialchars($row['sessions_offered']) . "</td>
                          <td>" . htmlspecialchars($row['lecturer']) . "</td>
                          <td>
                            <form method='POST' style='display:inline;'>
                              <input type='hidden' name='module_code' value='" . htmlspecialchars($row['code']) . "'>
                              <input type='hidden' name='module_name' value='" . htmlspecialchars($row['name']) . "'>
                              <input type='hidden' name='module_description' value='" . htmlspecialchars($row['description']) . "'>
                              <input type='hidden' name='sessions_offered' value='" . htmlspecialchars($row['sessions_offered']) . "'>
                              <input type='hidden' name='lecturer' value='" . htmlspecialchars($row['lecturer']) . "'>
                              <button type='submit' name='register' class='btn btn-success btn-sm'>Register</button>
                            </form>
                            <button class='btn btn-danger btn-sm'>Reject</button>
                          </td>
                        </tr>";
                }
              } else {
                echo "<tr><td colspan='6'>No courses found</td></tr>";
              }
              ?>
            </tbody>
          </table>

          <h2>Registered Modules</h2>
          <table class="table">
            <thead>
              <tr>
                <th>Name</th>
                <th>Code</th>
                <th>Description</th>
                <th>Lecturer</th>
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

          <?php include("../layouts/student/footer.php"); ?>
        </div>
      </div>
    </div>
    <?php include("../layouts/scripts.php"); ?>
  </body>
</html>