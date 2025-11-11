<?php
include 'connection.php';

if (!isset($_GET['id'])) {
    echo "<script>alert('No user selected'); location.href='users.php';</script>";
    exit;
}

$id = $_GET['id'];

// Fetch user data
$query = "SELECT * FROM registration WHERE id = $id";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "<script>alert('User not found'); location.href='users.php';</script>";
    exit;
}

// Update logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $phone    = $_POST['phone'];
    $country  = $_POST['country'];
    $state    = $_POST['state'];
    $city     = $_POST['city'];
    $code     = $_POST['code'];

    // Handle profile image upload
    if (isset($_FILES['profile_img']) && $_FILES['profile_img']['name'] != '') {
        $imageName = time() . '_' . $_FILES['profile_img']['name'];
        $imagePath = "uploads/" . $imageName;
        move_uploaded_file($_FILES['profile_img']['tmp_name'], "../" . $imagePath); // Save to root uploads folder
    } else {
        $imagePath = $user['profile_img']; // keep old image
    }

    $updateQuery = "UPDATE registration SET 
                        name='$name',
                        email='$email',
                        phone_no='$phone',
                        country='$country',
                        state='$state',
                        city='$city',
                        code='$code',
                        profile_img='$imagePath'
                    WHERE id = $id";

    if (mysqli_query($con, $updateQuery)) {
        echo "<script>alert('User updated successfully'); location.href='users.php';</script>";
    } else {
        echo "<script>alert('Error updating user');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="./assets/images/logos/favicon-128.png">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/icons.min.css" rel="stylesheet" />
    <link href="assets/css/app.min.css" rel="stylesheet" />
    <style>
        .form-section {
            padding: 25px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .profile-img-preview {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ccc;
        }
    </style>
</head>
<body style="margin: 0;padding: 0;overflow: hidden;">

<?php include 'sidebar.php'; ?>
<?php include 'header.php'; ?><br><br>

<div class="page-wrapper" >
    <div class="page-content" style="padding-top: 60px;">
        <div class="container-fluid">
            <h4 class="page-title">Edit User</h4>
            <div class="card">
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data" class="form-section">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="<?php echo $user['name']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="<?php echo $user['email']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Phone</label>
                                <input type="text" name="phone" class="form-control" value="<?php echo $user['phone_no']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Country</label>
                                <input type="text" name="country" class="form-control" value="<?php echo $user['country']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>State</label>
                                <input type="text" name="state" class="form-control" value="<?php echo $user['state']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>City</label>
                                <input type="text" name="city" class="form-control" value="<?php echo $user['city']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Pincode</label>
                                <input type="text" name="code" class="form-control" value="<?php echo $user['code']; ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Profile Image</label>
                                <input type="file" name="profile_img" class="form-control">
                                <br>
                                <?php if ($user['profile_img']) { ?>
                                    <img src="../<?php echo $user['profile_img']; ?>" class="profile-img-preview" alt="Profile Image">
                                <?php } ?>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="user.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/js/app.js"></script>

</body>
</html>
