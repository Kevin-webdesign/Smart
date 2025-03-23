<?php
// Assuming you have a function to get the current URL or script name
$currentUrl = basename($_SERVER['PHP_SELF']); // Example to get the current script name
?>

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <h1 style="color: aliceblue;">Student Portal</h1>
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

    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item <?php echo ($currentUrl == 'index.php') ? 'active' : ''; ?>">
                    <a href="index.php">
                        <i class="fas fa-th-list"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item <?php echo ($currentUrl == 'register.php') ? 'active' : ''; ?>">
                    <a href="register.php">
                        <i class="fas fa-user"></i>
                        <p>Modules Registration</p>
                    </a>
                </li>
                <li class="nav-item <?php echo ($currentUrl == 'attendance_record.php') ? 'active' : ''; ?>">
                    <a href="attendance.php">
                        <i class="fas fa-chart-line"></i>
                        <p>Attendance Record</p>
                    </a>
                </li>
                <li class="nav-item <?php echo ($currentUrl == 'modules.php') ? 'active' : ''; ?>">
                    <a href="modules.php">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <p>Modules</p>
                    </a>
                </li>
                <li class="nav-item <?php echo ($currentUrl == 'settings.php') ? 'active' : ''; ?>">
                    <!-- <a href="settings.php">
                        <i class="fas fa-cog fa-spin"></i>
                        <p>Settings</p>
                    </a> -->
                </li>
            </ul>
        </div>
    </div>
</aside>