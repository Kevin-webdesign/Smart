<?php
session_start();

// Include database connection
include("../config/connection.php");

if (!isset($conn)) {
    die("Database connection failed");
}

// Ensure session variables are set
if (!isset($_SESSION['second_name'])) {
    die("Session error: Lecturer name not found. Please log in.");
}

$lecturer = $_SESSION['second_name'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get form values
  $course_id = $_POST['course_id'];
  $student_ids = $_POST['student_ids']; 
  $lecture = $_POST['lecturer'];

  $student_ids_array = explode(',', $student_ids);
  $insert_success = false;

  foreach ($student_ids_array as $student_id) {
      $student_id = trim($student_id);
      
      if (!empty($student_id) && is_numeric($student_id)) {
          $query = "INSERT INTO attendance (student_id, lecture, course) VALUES (?, ?, ?)";
          $stmt = $conn->prepare($query);
          
          if ($stmt) {
              $stmt->bind_param('iss', $student_id, $lecture, $course_id);
              if ($stmt->execute()) {
                  $insert_success = true; // At least one insert was successful
              }
              $stmt->close();
          } else {
              die("Error preparing INSERT query: " . $conn->error);
          }
      }
  }

  // Only update status_finger if at least one student was inserted
  if ($insert_success) {
      $updateQuery = "UPDATE status_finger SET attended = 0 WHERE id = 1";
      if ($conn->query($updateQuery)) {
          echo "Attendance records saved and status updated successfully.";
      } else {
          echo "Attendance records saved, but failed to update status: " . $conn->error;
      }
  } else {
      echo "No attendance records inserted.";
  }
}


// Fetch courses assigned to the lecturer
$sql = "SELECT id, name, code FROM course WHERE lecturer = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("s", $lecturer);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<?php include("../layouts/header.php"); ?>
<body>
    <div class="wrapper">
        <?php include("../layouts/lecture/sidebar.php"); ?>
        <div class="main-panel">
            <?php include("../layouts/navbar.php"); ?>
            <div class="container">
                <div class="page-inner">
                    <div class="page-header">
                        <h3 class="fw-bold mb-3">Attendance Records</h3>
                        <ul class="breadcrumbs mb-3">
                            <li class="nav-home"><a href="#"><i class="icon-home"></i></a></li>
                            <li class="separator"><i class="icon-arrow-right"></i></li>
                            <li class="nav-item"><a href="#">Attendance</a></li>
                            <li class="separator"><i class="icon-arrow-right"></i></li>
                            <li class="nav-item"><a href="#">Records</a></li>
                        </ul>
                    </div>

                    <div class="body">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Enroll new Attendance
                        </button>

                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Select Course</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST">
                                            <div class="mb-3">
                                                <label for="course_id" class="col-form-label">Course:</label>
                                                <select name="course_id" id="course_id" class="form-control" required>
                                                    <option value="">-- Select Course --</option>
                                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                                        <option value="<?= $row['name'] ?>">
                                                            <?= htmlspecialchars($row['name']) ?> (<?= htmlspecialchars($row['code']) ?>)
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="lecturer" class="col-form-label">Lecture:</label>
                                                <input type="text" class="form-control" name="lecturer" id="lecturer" value="<?= $_SESSION['second_name']; ?>" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="student_name" class="col-form-label">Student Name:</label>
                                                <input type="hidden" class="form-control" name="student_ids" id="student_ids">
                                                <textarea class="form-control" id="student_name" name="student_name" readonly></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Course</th>
                                        <th>Lecture</th>
                                        <th>Entry Time</th>
                                        <th>Had Extended Absence</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM attendance";
                                    $result = $conn->query($sql);

                                    if ($result && $result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>" . htmlspecialchars($row["student_id"]) . "</td>
                                                    <td>" . htmlspecialchars($row["course"]) . "</td>
                                                    <td>" . htmlspecialchars($row["lecture"]) . "</td>
                                                    <td>" . htmlspecialchars($row["entry_time"]) . "</td>
                                                    <td>" . ($row["had_extended_absence"] ? 'Yes' : 'No') . "</td>
                                                  </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5'>No records found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php include("../layouts/lecture/footer.php"); ?>
        </div>
    </div>

    <?php include("../layouts/scripts.php"); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    $(document).ready(function() {
        setInterval(function() {
            $.ajax({
                url: 'getdata.php',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    var studentNames = [];
                    var studentIds = [];

                    $.each(response, function(index, student) {
                        if (student.second_name && student.student_id) {
                            studentNames.push(student.second_name);
                            studentIds.push(student.student_id);
                        }
                    });

                    $('#student_name').val(studentNames.join(", "));
                    $('#student_ids').val(studentIds.join(", "));
                },
                error: function() {
                    alert("An error occurred while fetching student data.");
                }
            });
        }, 2000);
    });
    </script>
</body>
</html>
