<?php
include 'connection.php';
include 'header.php';

// Check order_id in URL
if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
    echo "<div class='container my-5'><div class='alert alert-danger'>Invalid or missing Order ID.</div></div>";
    include 'footer.php';
    exit();
}

$order_id = intval($_GET['order_id']);

// Fetch order details
$sql = "SELECT * FROM orders WHERE id = $order_id";
$result = mysqli_query($con, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<div class='container my-5'><div class='alert alert-warning'>Order not found!</div></div>";
    include 'footer.php';
    exit();
}

$order = mysqli_fetch_assoc($result);
$customer_name = htmlspecialchars($order['fullname']);
$total_amount = $order['total_amount'];
$order_date = date("d M Y, h:i A", strtotime($order['created_at']));
$status = $order['status'];
?>

<div class="container text-center my-5">
    <div class="card shadow p-5">
        <div class="mb-4">
            <img src="https://cdn-icons-png.flaticon.com/512/845/845646.png" width="100" alt="Success">
        </div>
        <h2 class="text-success mb-3">Thank You, <?= $customer_name ?>!</h2>
        <h4>Your order has been placed successfully.</h4>
        <p class="text-muted">Order ID: <strong>#<?= $order_id ?></strong></p>
        <p class="text-muted">Order Date: <strong><?= $order_date ?></strong></p>
        <p class="text-muted">Total Amount: <strong class="text-danger">₹<?= number_format($total_amount, 2) ?></strong></p>
        <p class="text-muted">Order Status:
            <?php if ($status == "Pending"): ?>
                <span class="badge bg-warning text-dark"><?= $status ?></span>
            <?php elseif ($status == "Shipped"): ?>
                <span class="badge bg-info text-dark"><?= $status ?></span>
            <?php elseif ($status == "Delivered"): ?>
                <span class="badge bg-success"><?= $status ?></span>
            <?php else: ?>
                <span class="badge bg-secondary"><?= $status ?></span>
            <?php endif; ?>
        </p>
        <div class="mt-4">
            <a href="index.php" class="btn btn-primary px-4 py-2 me-2">Continue Shopping</a>
            <a href="generate-invoice.php?order_id=<?= $order_id ?>" class="btn btn-outline-dark px-4 py-2">Download Invoice PDF</a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
