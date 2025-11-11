<?php
session_start();
include 'connection.php';

// Check login
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Handle delete
if ($user_id && isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    mysqli_query($con, "DELETE FROM cart WHERE user_id = $user_id AND product_id = $delete_id");
    header("Location: shoping-cart.php");
    exit();
} elseif (!$user_id && isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['product_id'] == $delete_id) {
                unset($_SESSION['cart'][$key]);
                break;
            }
        }
    }
    header("Location: shoping-cart.php");
    exit();
}

// Handle quantity update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    if ($user_id) {
        foreach ($_POST['quantity'] as $product_id => $qty) {
            $qty = max(1, intval($qty)); // minimum 1
            mysqli_query($con, "UPDATE cart SET quantity=$qty WHERE user_id=$user_id AND product_id=$product_id");
        }
    } else {
        foreach ($_POST['quantity'] as $product_id => $qty) {
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['product_id'] == $product_id) {
                    $item['quantity'] = max(1, intval($qty));
                }
            }
        }
    }
    header("Location: shoping-cart.php");
    exit();
}

include 'header.php';

// Fetch cart
$cart_items = [];
$total_amount = 0;

if ($user_id) {
    $query = "SELECT c.product_id, c.quantity, p.price, p.name, p.image1 AS image 
              FROM cart c 
              JOIN products p ON c.product_id = p.id 
              WHERE c.user_id = $user_id";
    $result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $cart_items[] = $row;
        $total_amount += $row['price'] * $row['quantity'];
    }
} else {
    $cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    foreach ($cart_items as $item) {
        $total_amount += $item['price'] * $item['quantity'];
    }
}
?>

<div class="container my-5">
    <h2 class="text-center text-uppercase mb-5">Your Shopping Cart</h2>

    <?php if (!empty($cart_items)): ?>
        <form method="POST" action="checkout1.php">
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Select</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price (INR)</th>
                            <th>Quantity</th>
                            <th>Total (INR)</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $item): 
                            $item_total = $item['price'] * $item['quantity'];
                        ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="selected_items[]" value="<?= $item['product_id'] ?>" checked>
                            </td>
                            <td><img src="admin/uploads/<?= htmlspecialchars($item['image']) ?>" width="80"></td>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td>₹<?= number_format($item['price'], 2) ?></td>
                            <td>
                                <input type="number" name="quantity[<?= $item['product_id'] ?>]" 
                                       value="<?= $item['quantity'] ?>" min="1" class="form-control w-50 mx-auto">
                            </td>
                            <td>₹<?= number_format($item_total, 2) ?></td>
                            <td>
                                <a class="btn btn-outline-danger btn-sm rounded-circle" href="?delete=<?= $item['product_id'] ?>" 
                                   onclick="return confirm('Remove this item?')">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="row justify-content-between mt-4">
                <div class="col-md-4">
                    <button type="submit" name="update_cart" formaction="shoping-cart.php" 
                            class="btn btn-warning w-100">Update Cart</button>
                </div>
                <div class="col-md-4">
                    <button type="submit" name="checkout" class="btn btn-success w-100">Proceed to Checkout</button>
                </div>
            </div>
        </form>
    <?php else: ?>
        <div class="alert alert-warning text-center">
            Your cart is empty. <a href="product.php">Continue Shopping</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
