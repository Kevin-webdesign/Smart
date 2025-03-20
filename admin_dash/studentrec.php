    <!DOCTYPE html>
    <html lang="en">
      <!-- HEADER / LINKS /  BASIC SCRIPTS -->
      <?php include("../layouts/header.php");?>
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
              
               
              <div class="container">
                <h1>Student Records</h1>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Second Name</th>
                            <th>Email</th>
                            <th>Telephone</th>
                            <th>Student ID</th>
                            <th>Session</th>
                            <th>Fingerprint</th>
                        </tr>
                    </thead>
                   
                </table>
            
            
    
            <?php include("../layouts/admin/footer.php");?>
          </div>
        </div>
        <?php include("../layouts/scripts.php");?>
      </body>
    
    </html>
    