<?php
// Start session only if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("../config/connection.php");

// Check if the user is logged in
$user_name = "Guest";
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch user details from the database
    $query = "SELECT first_name, second_name FROM baseuser WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($first_name, $second_name);
    if ($stmt->fetch()) {
        $user_name = htmlspecialchars($first_name . ' ' . $second_name);
    }
    $stmt->close();
}
?>

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
                </span><?php echo defined('BRAND_NAME_PART2') ? BRAND_NAME_PART2 : 'Attendance'; ?></b></h1>
            </nav>

            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" id="profileDropdown">
                        <!-- <img src="assets/img/profile.jpg" alt="Profile" class="avatar-img rounded-circle" onerror="this.onerror=null; this.src='../assets/img/profile.jpg'"/> -->
                        <i class="fas fa-user mt-2 text-5"></i>

                        <span class="profile-username">
                            <?php echo $user_name; ?>
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

<?php include("../layouts/scripts.php"); ?>
<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
