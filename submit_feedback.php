<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $product_id = intval($_POST['product_id']);
    $comment = trim(mysqli_real_escape_string($con, $_POST['comment']));
    $image_path = NULL;

    // 1️⃣ Empty comment check
    if (empty($comment)) {
        echo "<script>alert('Feedback cannot be empty.'); history.back();</script>";
        exit;
    }

    // 2️⃣ Handle image upload if provided
    if (isset($_FILES['feedback_image']) && $_FILES['feedback_image']['error'] !== 4) { 
        // error 4 = no file uploaded
        $img = $_FILES['feedback_image'];

        // Check for upload errors
        if ($img['error'] !== 0) {
            echo "<script>alert('Image upload failed with error code: {$img['error']}'); history.back();</script>";
            exit;
        }

        $ext = strtolower(pathinfo($img['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($ext, $allowed)) {
            echo "<script>alert('Invalid image type! Only JPG, JPEG, PNG, GIF allowed.'); history.back();</script>";
            exit;
        }

        $newName = uniqid('fb_') . '.' . $ext;
        $targetDir = "feedback_img/";

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if (!move_uploaded_file($img['tmp_name'], $targetDir . $newName)) {
            echo "<script>alert('Failed to move uploaded file.'); history.back();</script>";
            exit;
        }

        $image_path = $targetDir . $newName;
    }

    // 3️⃣ Insert into feedback table
    $query = "INSERT INTO feedback (user_id, product_id, comment, image, created_at) 
              VALUES ('$user_id', '$product_id', '$comment', " . 
              ($image_path ? "'$image_path'" : "NULL") . ", NOW())";

    if (mysqli_query($con, $query)) {
        echo "<script>
                alert('✅ Thank you for your feedback!');
                location.href='product-detail.php?id=$product_id';
              </script>";
    } else {
        echo "<script>
                alert('❌ Something went wrong: " . mysqli_error($con) . "');
                history.back();
              </script>";
    }

    mysqli_close($con);
}
?>
