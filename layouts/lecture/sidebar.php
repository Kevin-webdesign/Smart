<?php
// Assuming you have a function to get the current URL or route name
$currentUrl = basename($_SERVER['PHP_SELF']); // Example to get the current script name
?>

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <h1 style="color: aliceblue;">Lecture Portal</h1>
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
                <li class="nav-item <?php echo ($current_page == 'lecture_dashboard.php') ? 'active' : ''; ?>">
                    <a href="index.php">
                        <i class="fas fa-th-list"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item <?php echo ($current_page== 'all_registered_students.php') ? 'active' : ''; ?>">
                    <a href="allstudents.php">
                        <i class="fas fa-users"></i>
                        <p>All Registered Students</p>
                    </a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'modules.php') ? 'active' : ''; ?>">
                    <a href="registered_students.php">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <p>Modules</p>
                    </a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'settings.php') ? 'active' : ''; ?>">
                    <!-- <a href="settings.php">
                        <i class="fas fa-cog fa-spin"></i>
                        <p>Settings</p>
                    </a> -->
                </li>
            </ul>
        </div>
    </div>
</aside>