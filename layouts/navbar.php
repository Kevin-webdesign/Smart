<div class="main-header">
    <div class="main-header-logo">
        <div class="logo-header" style="background-color: dark;">
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar" aria-label="Toggle Sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler" aria-label="Toggle Navigation">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more" aria-label="More Options">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
    </div>

    <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom w-100">
        <div class="container-fluid">
            <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                <h1><b><span style="color: red;">
                    <?php echo defined('BRAND_NAME_PART1') ? BRAND_NAME_PART1 : 'Smart'; ?>
                </span><?php echo defined('BRAND_NAME_PART2') ? BRAND_NAME_PART2 : 'attendance'; ?></b></h1>
            </nav>

            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" id="profileDropdown">
                        <img src="assets/img/profile.jpg" alt="Profile" class="avatar-img rounded-circle" onerror="this.onerror=null; this.src='assets/img/default-profile.jpg'"/>
                        <span class="profile-username">
                            <?php if (isset($_SESSION['user'])) { ?>
                                <p>Welcome, <strong><?php echo $_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['second_name']; ?></strong></p>
                            <?php } else { ?>
                                <p>Welcome, Guest</p>
                            <?php } ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn" aria-labelledby="profileDropdown">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <a class="dropdown-item" href="../logout.php">
                                    <i class="gg-log-out"></i> Logout
                                </a>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div>

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
