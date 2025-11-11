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

// Validate order_id
if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Invalid Order ID.</div></div>";
    include 'footer.php';
    exit();
}

$order_id = intval($_GET['order_id']);

// Fetch order
$order_sql = "SELECT * FROM orders WHERE id = $order_id AND user_id = $user_id";
$order_result = mysqli_query($con, $order_sql);

if (!$order_result || mysqli_num_rows($order_result) == 0) {
    echo "<div class='container mt-5'><div class='alert alert-warning'>Order not found or access denied.</div></div>";
    include 'footer.php';
    exit();
}

$order = mysqli_fetch_assoc($order_result);

// Fetch items
$item_sql = "SELECT * FROM order_items WHERE order_id = $order_id";
$item_result = mysqli_query($con, $item_sql);
?>

<div class="container my-5">
    <h3 class="text-center text-primary mb-4">Order #<?= $order_id ?> Details</h3>

    <!-- Order Info -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h5>Billing Info</h5>
            <p><strong>Name:</strong> <?= htmlspecialchars($order['fullname']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($order['phone']) ?></p>
            <p><strong>Address:</strong> <?= htmlspecialchars($order['address']) ?>, <?= htmlspecialchars($order['city']) ?> - <?= $order['zip'] ?></p>
        </div>
        <div class="col-md-6">
            <h5>Order Info</h5>
            <p><strong>Date:</strong> <?= date("d M Y, h:i A", strtotime($order['created_at'])) ?></p>
            <p><strong>Payment:</strong> <?= ucfirst($order['payment_method']) ?> <br><small><?= htmlspecialchars($order['payment_details']) ?></small></p>
            <p><strong>Total:</strong> ₹<?= number_format($order['total_amount'], 2) ?></p>
            <p><strong>Status:</strong>
                <span class="badge 
                    <?php
                        if ($order['status'] == 'Pending') echo 'bg-warning text-dark';
                        elseif ($order['status'] == 'Shipped') echo 'bg-info text-dark';
                        elseif ($order['status'] == 'Delivered') echo 'bg-success';
                        else echo 'bg-secondary';
                    ?>">
                    <?= $order['status'] ?>
                </span>
            </p>
        </div>
    </div>

    <!-- Items -->
    <h5 class="mb-3">Products</h5>
    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>Feedback</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $grand_total = 0;
                while ($item = mysqli_fetch_assoc($item_result)) :
                    $subtotal = $item['price'] * $item['quantity'];
                    $grand_total += $subtotal;

                    // Check if feedback already exists
                    $check_feedback = mysqli_query($con, "SELECT * FROM feedbacks WHERE order_id={$order_id} AND product_id={$item['product_id']} AND user_id={$user_id}");
                    $feedback_exists = mysqli_num_rows($check_feedback) > 0;
                ?>
                <tr>
                    <td><img src="admin/uploads/<?= htmlspecialchars($item['image']) ?>" width="70"></td>
                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                    <td><?= number_format($item['price'],2) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td><?= number_format($subtotal,2) ?></td>
                    <td>
                        <?php if($order['status'] == 'Delivered' && !$feedback_exists): ?>
                            <a href="feedback.php?item_id=<?= $item['id'] ?>&order_id=<?= $order_id ?>" class="btn btn-sm btn-success">Give Feedback</a>
                        <?php elseif($feedback_exists): ?>
                            <span class="text-success">Feedback Submitted</span>
                        <?php else: ?>
                            <span class="text-muted">Not Available</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>

                <tr class="table-warning">
                    <td colspan="4"><strong>Delivery Charge</strong></td>
                    <td>₹100</td>
                    <td></td>
                </tr>
                <tr class="table-info">
                    <td colspan="4"><strong>Total</strong></td>
                    <td>₹<?= number_format($grand_total+100,2) ?></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <a href="my-orders.php" class="btn btn-secondary">← Back</a>
    </div>
</div>

<?php include 'footer.php'; ?>
