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
<?php

include("../config/connection.php");

// Check if the user is logged in
$user_name = "Guest";
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch user details from the database
    $query = "SELECT first_name, second_name FROM baseuser WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($first_name, $second_name);
    if ($stmt->fetch()) {
        $user_name = htmlspecialchars($first_name . ' ' . $second_name);
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
  <!-- HEADER / LINKS / BASIC SCRIPTS -->
  <?php include("../layouts/header.php"); ?>
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
              <h3 class="fw-bold mb-3">Student Dashboard</h3>
              <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                  <a href="#">
                    <i class="icon-home"></i>
                  </a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="#">Dashboard</a></li>
              </ul>
            </div>

            <!-- Dashboard Content -->
            <div class="row">
              <!-- Student Profile Card -->
              <div class="col-md-4">
                <div class="card">
                  <div class="card-body text-center">
                  <li class="separator"><i class="fas fa-user fa-3x text-primary"></i></li>
                    <h4 class="mt-2"><?php echo $user_name; ?></h4>
                    <p>Student ID: <?php echo $user_id?></p>
                  </div>
                </div>
              </div>

              <!-- Quick Actions -->
              <div class="col-md-8">
                <div class="row">
                  <div class="col-md-6">
                    <div class="card text-center">
                      <div class="card-body">
                        <i class="fas fa-user fa-3x text-primary"></i>
                        <h5 class="mt-3">Modules Registration</h5>
                        <a href="register.php" class="btn btn-primary mt-2">Register Now</a>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card text-center">
                      <div class="card-body">
                        <i class="fas fa-chart-line fa-3x text-success"></i>
                        <h5 class="mt-3">Attendance Record</h5>
                        <a href="attend.php" class="btn btn-success mt-2">View Attendance</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

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
            <!-- Footer -->
            <?php include("../layouts/student/footer.php"); ?>
          </div>
        </div>
      </div>
      <?php include("../layouts/scripts.php"); ?>
    </body>
</html>
