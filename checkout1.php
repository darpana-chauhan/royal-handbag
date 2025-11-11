<?php
session_start();
include 'connection.php';
include 'header.php';

$cart = [];
$total = 0;
$delivery_charge = 100;

if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_back'] = "checkout1.php";
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user info
$user_query = mysqli_query($con, "SELECT name,email,phone_no FROM registration WHERE id = $user_id");
$user_data = mysqli_fetch_assoc($user_query);
$default_name = $user_data['name'] ?? '';
$default_email = $user_data['email'] ?? '';
$default_phone = $user_data['phone_no'] ?? '';

$selected_items = $_POST['selected_items'] ?? [];

if (!empty($selected_items)) {
    $ids = implode(",", array_map('intval', $selected_items));
    $query = "SELECT c.product_id, c.quantity, p.name, p.price, p.image1 AS image 
              FROM cart c JOIN products p ON c.product_id = p.id 
              WHERE c.user_id = $user_id AND c.product_id IN ($ids)";
    $result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $cart[] = $row;
        $total += $row['price'] * $row['quantity'];
    }
    $grand_total = $total + $delivery_charge;
} else {
    echo "<script>alert('No items selected.'); window.location='shoping-cart.php';</script>";
    exit();
}

// Handle Order Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $zip = $_POST['zip'];
    $payment_method = $_POST['payment_method'];

    $payment_details = "Cash on Delivery";
    if ($payment_method === 'online') {
        $card_name = $_POST['card_name'];
        $card_number = $_POST['card_number'];
        $expiry = $_POST['expiry'];
        $cvv = $_POST['cvv'];
        $payment_details = "Card: $card_name, Number: $card_number, Expiry: $expiry";
    }

    $order_query = "INSERT INTO orders 
        (fullname,email,phone,address,city,zip,payment_method,payment_details,total_amount,created_at,user_id)
        VALUES ('$fullname','$email','$phone','$address','$city','$zip','$payment_method','$payment_details','$grand_total',NOW(),$user_id)";
    
    if (mysqli_query($con, $order_query)) {
        $order_id = mysqli_insert_id($con);
        foreach ($cart as $item) {
            mysqli_query($con,"INSERT INTO order_items (order_id,product_id,product_name,price,quantity,image) 
                               VALUES ('$order_id','".$item['product_id']."','".$item['name']."','".$item['price']."','".$item['quantity']."','".$item['image']."')");
            mysqli_query($con, "UPDATE products SET stock=stock-".$item['quantity']." WHERE id=".$item['product_id']);
        }

        // Delete ordered items from cart
        $delete_ids = implode(",", array_map('intval', $selected_items));
        mysqli_query($con, "DELETE FROM cart WHERE user_id=$user_id AND product_id IN ($delete_ids)");

        echo "<script>alert('Order placed successfully!'); window.location='order-success.php?order_id=$order_id';</script>";
        exit();
    } else {
        echo "<script>alert('Order failed.');</script>";
    }
}
?>

<div class="container my-5">
    <h2 class="text-center text-uppercase mb-5">Checkout</h2>
    <form method="POST" onsubmit="return validateForm()">
        <?php foreach ($selected_items as $id): ?>
            <input type="hidden" name="selected_items[]" value="<?= $id ?>">
        <?php endforeach; ?>

        <div class="row">
            <!-- Billing Info -->
            <div class="col-md-6">
                <div class="p-4 border rounded shadow-sm">
                    <h4>Billing Information</h4>
                    <div class="form-group mb-3">
                        <label>Full Name</label>
                        <input type="text" name="fullname" class="form-control" required value="<?= htmlspecialchars($default_name) ?>">
                    </div>
                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($default_email) ?>">
                    </div>
                    <div class="form-group mb-3">
                        <label>Phone</label>
                        <input type="tel" name="phone" class="form-control" maxlength="10" pattern="\d{10}" required value="<?= htmlspecialchars($default_phone) ?>">
                    </div>
                    <div class="form-group mb-3"><label>Address</label><textarea name="address" class="form-control" required></textarea></div>
                    <div class="form-group mb-3"><label>City</label><input type="text" name="city" class="form-control" required></div>
                    <div class="form-group mb-3"><label>Pincode</label><input type="text" name="zip" class="form-control" maxlength="6" pattern="\d{6}" required></div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-md-6">
                <div class="p-4 border rounded shadow-sm">
                    <h4>Order Summary</h4>
                    <ul class="list-group mb-3">
                        <?php foreach ($cart as $item): ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <div><?= htmlspecialchars($item['name']) ?> x <?= $item['quantity'] ?></div>
                                <span>₹<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                            </li>
                        <?php endforeach; ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <div>Delivery Charge</div>
                            <span>₹<?= number_format($delivery_charge, 2) ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Total</strong>
                            <strong>₹<?= number_format($grand_total, 2) ?></strong>
                        </li>
                    </ul>

                    <h5>Payment Method</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" value="cod" id="cod" checked>
                        <label class="form-check-label" for="cod">Cash on Delivery</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="payment_method" value="online" id="online">
                        <label class="form-check-label" for="online">Online Payment</label>
                    </div>

                    <div id="online-payment-section" style="display: none;">
                        <div class="form-group mb-3"><label>Card Name</label><input type="text" name="card_name" id="card_name" class="form-control"></div>
                        <div class="form-group mb-3"><label>Card Number</label><input type="text" name="card_number" id="card_number" class="form-control" maxlength="16" pattern="\d{16}"></div>
                        <div class="form-group mb-3"><label>Expiry</label><input type="text" name="expiry" id="expiry" class="form-control" placeholder="MM/YY"></div>
                        <div class="form-group mb-3"><label>CVV</label><input type="text" name="cvv" id="cvv" class="form-control" maxlength="3" pattern="\d{3}"></div>
                    </div>

                    <button type="submit" name="place_order" class="btn btn-success w-100">Place Order</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.getElementById("cod").addEventListener("click", () => {
    document.getElementById("online-payment-section").style.display = "none";
});
document.getElementById("online").addEventListener("click", () => {
    document.getElementById("online-payment-section").style.display = "block";
});

function validateForm() {
    let method = document.querySelector('input[name="payment_method"]:checked').value;
    if (method === 'online') {
        let cardName = document.getElementById('card_name').value.trim();
        let cardNumber = document.getElementById('card_number').value.trim();
        let expiry = document.getElementById('expiry').value.trim();
        let cvv = document.getElementById('cvv').value.trim();
        if (cardName === '' || cardNumber.length !== 16 || !/^\d{16}$/.test(cardNumber)) { alert('Enter valid Card Name and Number'); return false;}
        if (!/^\d{2}\/\d{2}$/.test(expiry)) { alert('Enter Expiry MM/YY'); return false;}
        if (!/^\d{3}$/.test(cvv)) { alert('Enter valid CVV'); return false;}
    }
    return true;
}
</script>

<?php include 'footer.php'; ?>
