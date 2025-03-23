<?php
include("../config/connection.php");

// Fetch lecturers from baseuser table
$sql = "SELECT id, first_name, second_name FROM baseuser WHERE user_type = 'Lecture'";
$result = $conn->query($sql);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $code = $conn->real_escape_string($_POST['code']);
    $description = $conn->real_escape_string($_POST['description']);
    $sessions_offered = $conn->real_escape_string($_POST['sessions_offered']);
    $lectureuser = $conn->real_escape_string($_POST['lectureuser']);
    
    $insertQuery = "INSERT INTO course (name, code, description, sessions_offered, lecturer) VALUES ('$name', '$code', '$description', '$sessions_offered', '$lectureuser')";
    
    if ($conn->query($insertQuery) === TRUE) {
        echo "<script>alert('Course added successfully!'); window.location.href='course_list.php';</script>";
    } else {
        echo "Error: " . $insertQuery . "<br>" . $conn->error;
    }
}
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
    
<body>
    <h2>Create Course</h2>
    <form method="POST" action="">
        <input type="text" name="name" class="form-control" placeholder="Course Name" required>
        <input type="text" name="code" class="form-control" placeholder="Course Code" required>
        <textarea name="description" class="form-control" placeholder="Course Description" rows="3"></textarea>
        <select name="sessions_offered" class="form-control">
            <option value="DAY">Day</option>
            <option value="EVENING">Evening</option>
            <option value="WEEKEND">Weekend</option>
        </select>
        <select name="lectureuser" class="form-control" required>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <option value="<?php echo $row['first_name'] . " " . $row['second_name']; ?>">
                    <?php echo $row['first_name'] . " " . $row['second_name']; ?>
                </option>
            <?php } ?>
        </select>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
<?php include("../layouts/admin/footer.php");?>
      </div>
    </div>
    <?php include("../layouts/scripts.php");?>
  </body>

</html>
<?php
$conn->close();
?>