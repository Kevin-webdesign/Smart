<?php
// Include database connection
include("../config/connection.php");

// Check if $conn is defined
if (!isset($conn)) {
  die("Database connection failed");
}

// SQL Query
$sql = "SELECT * FROM attendance";
$result = $conn->query($sql);

?>

<?php
// record_attendance.php
include("../config/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $student_id = $_POST['student_id'];
    $course = $_POST['course'];

    $stmt = $conn->prepare("INSERT INTO attendance (student_id, course, entry_time, entry_fingerprint_verified) VALUES (?, ?, NOW(), 1)");
    $stmt->bind_param("is", $student_id, $course);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to record attendance"]);
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
  <?php include("../layouts/header.php"); ?>
  <body>
    <div class="wrapper">
      <?php include("../layouts/lecture/sidebar.php");?>
      <div class="main-panel">
        <?php include("../layouts/navbar.php");?>

        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h3 class="fw-bold mb-3">Attendance Records</h3>
              <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                  <a href="#"><i class="icon-home"></i></a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="#">Attendance</a></li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="#">Records</a></li>
              </ul>
            </div>

            <div class="body">
              <button id="capture_fingerprint" class="btn btn-primary w-50 mx-5 mb-5">Activate Fingerprint Scanner</button>
              <div id="fingerprint_status" class="alert" style="display:none;"></div>
              
              <div class="table-responsive ">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Student ID</th>
                      <th>Course</th>
                      <th>Entry Time</th>
                      <th>Entry Fingerprint Verified</th>
                      <th>Exit Time</th>
                      <th>Exit Fingerprint Verified</th>
                      <th>Had Extended Absence</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>".$row["student_id"]."</td>
                                <td>".$row["course"]."</td>
                                <td>".$row["entry_time"]."</td>
                                <td>".($row["entry_fingerprint_verified"] ? 'Yes' : 'No')."</td>
                                <td>".$row["exit_time"]."</td>
                                <td>".($row["exit_fingerprint_verified"] ? 'Yes' : 'No')."</td>
                                <td>".($row["had_extended_absence"] ? 'Yes' : 'No')."</td>
                              </tr>";
                      }
                    } else {
                      echo "<tr><td colspan='8'>No records found</td></tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <?php include("../layouts/lecture/footer.php");?>
      </div>
    </div>

    <?php include("../layouts/scripts.php"); ?>
    <script>
      $(document).ready(function() {
        $("#capture_fingerprint").click(function() {
            $("#fingerprint_status").show().text("Connecting to fingerprint scanner...");
            $.ajax({
                url: "send_to_arduino.php",
                type: "POST",
                contentType: "application/json",
                data: JSON.stringify({ operation: "SCAN" }),
                success: function(response) {
                    if (response.status === "success") {
                        $("#fingerprint_status").removeClass("alert-info alert-danger")
                            .addClass("alert-success")
                            .text("Fingerprint scanned successfully!");

                        // Verify fingerprint and record attendance
                        verifyFingerprint(response.fingerprint);
                    } else {
                        $("#fingerprint_status").removeClass("alert-info alert-success")
                            .addClass("alert-danger")
                            .text("Error: " + response.message);
                    }
                },
                error: function(xhr) {
                    $("#fingerprint_status").removeClass("alert-info alert-success")
                        .addClass("alert-danger")
                        .text("Failed to connect to fingerprint scanner");
                }
            });
        });

        function verifyFingerprint(fingerprint) {
            $.post("verify_fingerprint.php", { fingerprint: fingerprint }, function(data) {
                if (data.status === "success") {
                    recordAttendance(data.student_id, data.course);
                } else {
                    alert("Fingerprint not recognized: " + data.message);
                }
            }, "json");
        }

        function recordAttendance(studentID, course) {
            $.post("record_attendance.php", { student_id: studentID, course: course }, function(data) {
                if (data.status === "success") {
                    alert("Attendance recorded successfully!");
                    location.reload();
                } else {
                    alert("Error recording attendance: " + data.message);
                }
            }, "json");
        }
      });
    </script>
  </body>
</html>