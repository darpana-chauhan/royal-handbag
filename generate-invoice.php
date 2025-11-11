<?php
require_once __DIR__ . '/vendor/autoload.php'; // mPDF autoload
include 'connection.php';

// Validate order_id
if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
    die("Invalid Order ID.");
}
$order_id = intval($_GET['order_id']);

// Fetch order details
$sql_order = "SELECT * FROM orders WHERE id = $order_id";
$result_order = mysqli_query($con, $sql_order);

if (!$result_order || mysqli_num_rows($result_order) == 0) {
    die("Order not found.");
}

$order = mysqli_fetch_assoc($result_order);
$customer_name = htmlspecialchars($order['fullname']);
$total_amount = $order['total_amount'];
$order_date = date("d M Y, h:i A", strtotime($order['created_at']));

// Fetch order items
$sql_items = "SELECT product_name, quantity, price FROM order_items WHERE order_id = $order_id";
$result_items = mysqli_query($con, $sql_items);

if (!$result_items || mysqli_num_rows($result_items) == 0) {
    die("No items found for this order.");
}

// Prepare items rows
$items_html = "";
$subtotal = 0;
while ($item = mysqli_fetch_assoc($result_items)) {
    $pname = htmlspecialchars($item['product_name']);
    $qty = intval($item['quantity']);
    $price = number_format($item['price'], 2);
    $total = $qty * $item['price'];
    $subtotal += $total;

    $items_html .= "
        <tr>
            <td style='text-align:left;'>$pname</td>
            <td>$qty</td>
            <td>₹$price</td>
            <td>₹" . number_format($total, 2) . "</td>
        </tr>
    ";
}

$delivery_charge = 100;

// Logo paths
$bag_icon   = __DIR__ . "/images/bag.png";
$heart_icon = __DIR__ . "/images/heart.png";

// Invoice HTML
$html = "
<style>
    body { font-family: dejavusans, sans-serif; font-size: 12px; margin:0; padding:0; }
    .page-border {
        border: 3px solid #e75480; /* Deep Pink Border */
        padding: 20px;
        margin: 10px;
    }
    .header {
        text-align:center;
        background:#e75480;
        color:#fff;
        padding:15px;
        border-radius:6px;
    }
    .header h2 { margin:0; font-size:22px; color:#fff; }
    .sub-header { margin-top:5px; font-size:13px; color:#ffe6ef; }

    .order-details { margin-top:20px; font-size:13px; }
    .order-details p { margin:5px 0; }

    table { width:100%; border-collapse: collapse; margin-top:20px; }
    th { background:#e75480; color:#fff; padding:10px; text-align:center; }
    td { padding:10px; border:1px solid #ccc; text-align:center; }
    tr:nth-child(even){ background:#ffe6ef; }

    .summary td { font-weight:bold; background:#f9d6e5; }
    .summary td:first-child { text-align:right; }

    .footer {
        margin-top:30px;
        text-align:center;
        font-size:12px;
        color:#555;
    }
    .footer hr {
        margin:15px 0;
        border:0;
        border-top:1px solid #ccc;
    }
</style>

<div class='page-border'>
    <div class='header'>
        <h2><img src='$bag_icon' width='28' style='vertical-align:middle; margin-right:8px;'> Royal Handbag</h2>
        <div class='sub-header'>Premium Women’s Fashion Store</div>
    </div>

    <div class='order-details'>
        <p><strong>Order ID:</strong> #$order_id</p>
        <p><strong>Customer:</strong> $customer_name</p>
        <p><strong>Date:</strong> $order_date</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style='text-align:left;'>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            $items_html
            <tr class='summary'>
                <td colspan='3'>Subtotal</td>
                <td>₹" . number_format($subtotal, 2) . "</td>
            </tr>
            <tr class='summary'>
                <td colspan='3'>Delivery Charge</td>
                <td>₹" . number_format($delivery_charge, 2) . "</td>
            </tr>
            <tr class='summary'>
                <td colspan='3'>Grand Total</td>
                <td><strong>₹" . number_format($total_amount, 2) . "</strong></td>
            </tr>
        </tbody>
    </table>

    <div class='footer'>
        <hr>
        <p>Thank you for shopping with <strong>Royal Handbag</strong>!<br>
        Visit us again for more exclusive collections.</p>
        <p><img src='$heart_icon' width='18'> Stay Stylish, Stay Royal!</p>
    </div>
</div>
";

// Generate PDF
$mpdf = new \Mpdf\Mpdf(['default_font' => 'dejavusans']);
$mpdf->SetTitle("Royal Handbag Invoice #$order_id");
$mpdf->WriteHTML($html);
$mpdf->Output("Invoice_Order_$order_id.pdf", "D");
?>
