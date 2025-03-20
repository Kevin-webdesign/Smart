
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
<div class="container">
    <h2>All Registered Students</h2>

    {% for course, students in course_students.items %}
    <div class="course-section">
        <h3>{{ course.name }}</h3>  <!-- Course title as table header -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Second Name</th>
                    <th>Email</th>
                    <th>Session</th>
                </tr>
            </thead>
            <tbody>
              
                <tr>
                    <td colspan="4" class="text-center">No students registered for this course.</td>
                </tr>
                
            </tbody>
        </table>
    </div>
    <hr>  <!-- Add a horizontal line between courses -->
   
</div>
<?php include("../layouts/lecture/footer.php");?>
</div>
</div>
<?php include("../layouts/scripts.php");?>
</body>

</html>