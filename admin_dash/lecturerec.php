<?php
// Database connection
include("../config/connection.php");
// Query to fetch lecturers with department data
$sql = "SELECT 
            b.first_name, 
            b.second_name, 
            b.email, 
            b.telephone, 
            lp.department 
        FROM baseuser b
        INNER JOIN lecturerprofile lp ON b.id = lp.user_id
        WHERE b.user_type = 'Lecture'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
  <!-- HEADER / LINKS / BASIC SCRIPTS -->
  <?php include("../layouts/header.php"); ?>
  <!-- END HEADER / LINKS / BASIC SCRIPTS -->
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <?php include("../layouts/admin/sidebar.php"); ?>
      <!-- End Sidebar -->

      <div class="main-panel">
        <!-- NAV BAR AND LOGO DIV -->
        <?php include("../layouts/navbar.php"); ?>
        <!-- END NAV BAR AND LOGO DIV -->

        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h3 class="fw-bold mb-3">Lecture Records</h3>
            </div>
          </div>

          <div class="container">
            <h1>Lecture Records</h1>
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>First Name</th>
                  <th>Second Name</th>
                  <th>Email</th>
                  <th>Telephone</th>
                  <th>Department</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['first_name']}</td>
                                <td>{$row['second_name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['telephone']}</td>
                                <td>{$row['department']}</td> 
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No lecture records found</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>

        <?php include("../layouts/admin/footer.php"); ?>
      </div>
    </div>
    <?php include("../layouts/scripts.php"); ?>
  </body>
</html>

<?php
// Close the database connection
$conn->close();
?>
