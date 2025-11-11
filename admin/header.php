<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'connection.php';

// Admin name
$name = "Admin";
if (isset($_SESSION['admin_id'])) {
    $id = $_SESSION['admin_id'];
    $res = mysqli_query($con, "SELECT name FROM admin_login WHERE id = $id");
    if ($res && mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        $name = $row['name'];
    }
}

// Unread notifications
$noti_query = mysqli_query($con, "SELECT COUNT(*) as total FROM notifications WHERE status = 'unread'");
$noti_data = mysqli_fetch_assoc($noti_query);
$unread_count = $noti_data['total'];

// Latest 5 notifications
$latest_notifications = mysqli_query($con, "SELECT * FROM notifications ORDER BY created_at DESC LIMIT 5");
?>

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<!-- Header -->
<div class="topbar bg-primary shadow-sm">
    <div class="d-flex justify-content-end align-items-center p-2 pe-4 gap-4">

       
        

        <!-- Admin -->
        <div class="dropdown">
            <a href="#" class="dropdown-toggle text-white d-flex align-items-center" data-bs-toggle="dropdown">
                <i class="fa-solid fa-user-circle me-2" style="font-size: 20px;"></i>
                <span class="d-none d-md-inline"><?= ucfirst($name); ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="profile.php"><i class="fa fa-user me-2"></i> Profile</a></li>
                <li><a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out-alt me-2"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</div>
