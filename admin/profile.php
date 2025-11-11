<?php
session_start();
include 'connection.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$admin_id = $_SESSION['admin_id'];

// Fetch admin details
$query = "SELECT * FROM admin_login WHERE id = $admin_id";
$result = mysqli_query($con, $query);
$admin = mysqli_fetch_assoc($result);

if (!$admin) {
    echo "<script>alert('Admin not found!'); location.href='index.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Admin Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="./assets/images/logos/favicon-128.png">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/icons.min.css" rel="stylesheet" />
    <link href="assets/css/app.min.css" rel="stylesheet" />
</head>
<body style="margin: 0;padding: 0;overflow: hidden;">

<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>

<div class="page-content d-flex justify-content-center align-items-center" style="background-color: #f4f5f7; min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-body text-center py-5 px-4">
                        <div class="mb-4">
                            <img src="<?php echo $admin['image'] ? 'uploads/' . $admin['image'] : 'assets/images/users/default.jpg'; ?>"
                                 alt="Profile Image" class="rounded-circle shadow avatar-xl"
                                 style="width: 120px; height: 120px; object-fit: cover;">
                        </div>

                        <h4 class="fw-semibold text-dark"><?php echo $admin['name']; ?></h4>
                        <p class="text-muted mb-4"><?php echo $admin['email']; ?></p>

                        <div class="d-flex justify-content-center gap-3 mb-4">
                            <a href="edit_profile.php" class="btn btn-soft-primary px-4">Edit Profile</a>
                            <a href="logout.php" class="btn btn-outline-danger px-4">Logout</a>
                        </div>

                        <hr class="my-4">

                        <h5 class="fw-bold text-start mb-3">Profile Details</h5>
                        <div class="row text-start text-muted">
                            <div class="col-sm-6 mb-2">
                                <p><strong class="text-dark">Full Name:</strong> <?php echo $admin['name']; ?></p>
                                <p><strong class="text-dark">Email:</strong> <?php echo $admin['email']; ?></p>
                                <p><strong class="text-dark">Phone:</strong> +91 1234567890</p>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <p><strong class="text-dark">Role:</strong> Super Admin</p>
                                <p><strong class="text-dark">Joined:</strong> Jan 1, 2024</p>
                                <p><strong class="text-dark">Status:</strong> <span class="badge bg-success">Active</span></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>
