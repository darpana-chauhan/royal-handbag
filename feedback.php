<?php
session_start();
include 'connection.php';
include 'header.php';

// Check user login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Validate inputs
if (!isset($_GET['order_id'], $_GET['item_id'])) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Invalid Request.</div></div>";
    include 'footer.php';
    exit();
}

$order_id = intval($_GET['order_id']);
$item_id = intval($_GET['item_id']); // order_items.id

// Fetch order item along with real product ID
$sql = "SELECT oi.*, p.id AS product_id, p.image1 AS product_image
        FROM order_items oi
        JOIN orders o ON o.id = oi.order_id
        JOIN products p ON p.id = oi.product_id
        WHERE oi.order_id = $order_id
          AND oi.id = $item_id
          AND o.user_id = $user_id
          AND o.status='Delivered'
        LIMIT 1";

$res = mysqli_query($con, $sql);

if (!$res || mysqli_num_rows($res) == 0) {
    echo "<div class='container mt-5'><div class='alert alert-warning'>You cannot give feedback for this product.</div></div>";
    include 'footer.php';
    exit();
}

$item = mysqli_fetch_assoc($res);

// Handle feedback submission
if (isset($_POST['submit_feedback'])) {
    $comment = mysqli_real_escape_string($con, $_POST['comment']);
    $imagePath = $item['product_image']; // default product image

    // Optional uploaded image
    if (!empty($_FILES['image']['name'])) {
        $dir = "feedback_img/";
        if (!is_dir($dir)) mkdir($dir, 0777, true);

        $filename = "fb_" . uniqid() . "." . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $target = $dir . $filename;

        // Validate image type
        $allowed_types = ['jpg','jpeg','png','gif'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if(!in_array($ext, $allowed_types)) {
            echo "<div class='alert alert-danger text-center'>Invalid image type. Only JPG, PNG, GIF allowed.</div>";
        } elseif ($_FILES['image']['size'] > 2*1024*1024) { // 2MB limit
            echo "<div class='alert alert-danger text-center'>Image size should be less than 2MB.</div>";
        } else {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $imagePath = $target;
            } else {
                echo "<div class='alert alert-danger text-center'>Failed to upload image.</div>";
            }
        }
    }

    // Insert feedback using actual product ID
    $product_id = $item['product_id'];

    // Check if feedback already exists
    $check = mysqli_query($con, "SELECT * FROM feedbacks WHERE user_id=$user_id AND product_id=$product_id AND order_id=$order_id");
    if(mysqli_num_rows($check) > 0){
        echo "<div class='alert alert-warning text-center'>You have already submitted feedback for this product.</div>";
    } else {
        $ins = "INSERT INTO feedbacks (user_id, product_id, order_id, comment, image, created_at)
                VALUES ($user_id, $product_id, $order_id, '$comment', '$imagePath', NOW())";

        if (mysqli_query($con, $ins)) {
            echo "<script>alert('Feedback submitted successfully!');window.location='order-details.php?order_id=$order_id';</script>";
            exit();
        } else {
            echo "<div class='alert alert-danger text-center'>Error: " . mysqli_error($con) . "</div>";
        }
    }
}
?>

<div class="container my-5">
    <h3 class="text-center text-primary mb-4">Give Feedback</h3>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3 text-center">
                    <img src="admin/uploads/<?= htmlspecialchars($item['product_image']) ?>" width="150" class="img-thumbnail">
                </div>
                <div class="mb-3">
                    <label class="form-label">Your Feedback</label>
                    <textarea name="comment" class="form-control" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Upload Image (optional)</label>
                    <input type="file" name="image" class="form-control">
                    <small class="text-muted">Allowed types: JPG, PNG, GIF | Max size: 2MB</small>
                </div>
                <button type="submit" name="submit_feedback" class="btn btn-success w-100">Submit Feedback</button>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
