<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'connection.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$admin_id = $_SESSION['admin_id'];
$query = "SELECT * FROM admin_login WHERE id = $admin_id";
$result = mysqli_query($con, $query);
$admin = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = mysqli_real_escape_string($con, $_POST['name']);
    $email    = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $imagePath = "uploads/" . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    } else {
        $imageName = $admin['image'];
    }

    $update = "UPDATE admin_login SET 
                name = '$name',
                email = '$email',
                password = '$password',
                image = '$imageName'
               WHERE id = $admin_id";

    if (mysqli_query($con, $update)) {
        $_SESSION['admin_username'] = $name;
        echo "<script>alert('Profile updated successfully!'); location.href='edit_profile.php';</script>";
        exit;
    } else {
        echo "<script>alert('Error updating profile!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="./assets/images/logos/favicon-128.png">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/icons.min.css" rel="stylesheet" />
    <link href="assets/css/app.min.css" rel="stylesheet" />
</head>
<body style="margin: 0; padding: 0; overflow-x: hidden;">

<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>

<div class="page-content d-flex justify-content-center align-items-center" style="background-color: #f4f5f7; min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-body py-5 px-4">
                        <h4 class="text-center text-primary mb-4 fw-bold">Edit Admin Profile</h4>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Full Name</label>
                                    <input type="text" name="name" class="form-control" value="<?= $admin['name']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email Address</label>
                                    <input type="email" name="email" class="form-control" value="<?= $admin['email']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Password</label>
                                    <input type="text" name="password" class="form-control" value="<?= $admin['password']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Profile Image</label>
                                    <input type="file" name="image" class="form-control" id="image">
                                    <img id="preview" src="<?= $admin['image'] ? 'uploads/' . $admin['image'] : 'assets/images/users/default.jpg'; ?>"
                                         class="rounded-circle shadow mt-2" alt="Profile Image"
                                         style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #ccc;">
                                </div>
                            </div>

                            <div class="d-flex justify-content-center gap-3 mt-5">
                                <button type="submit" class="btn btn-success px-4 fw-semibold">Update</button>
                                <a href="index.php" class="btn btn-secondary px-4 fw-semibold">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ✅ Image Preview Script -->
<script>
    document.getElementById('image').addEventListener('change', function (event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview');

        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>

</body>
</html>
