<?php
$current_page = basename($_SERVER['PHP_SELF'], ".php");
?>

<aside class="sidebar ">
    <div class="sidebar-logo">
        <div class="logo-header bg-dark">
            <h1 style="color: aliceblue;">Admin Portal</h1>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
    </div>

    <div class="sidebar-wrapper ">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
                    <a href="index.php">
                        <i class="fas fa-th-list"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'student_records') ? 'active' : ''; ?>">
                    <a href="studentrec.php">
                        <i class="fas fa-user"></i>
                        <p>Student Record</p>
                    </a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'lecture_records') ? 'active' : ''; ?>">
                    <a href="lecturerec.php">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <p>Lecture Records</p>
                    </a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'attendance_record') ? 'active' : ''; ?>">
                    <a href="attendance.php">
                        <i class="fas fa-chart-line"></i>
                        <p>Attendance Record</p>
                    </a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'classsession_list') ? 'active' : ''; ?>">
                    <a href="classsession_list.php">
                        <i class="fas fa-wallet"></i>
                        <p>Sessions</p>
                    </a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'classroom_list') ? 'active' : ''; ?>">
                    <a href="classroom_list.php">
                        <i class="fas fa-users"></i>
                        <p>Classrooms</p>
                    </a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'course_list') ? 'active' : ''; ?>">
                    <a href="course_list.php">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <p>Modules</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>
