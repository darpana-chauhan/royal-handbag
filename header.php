<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'connection.php';

$cart_items = [];
$cart_count = 0;
$total_amount = 0;
$wishlist_count = 0;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $cart_query = mysqli_query($con, "
        SELECT c.quantity, p.price, p.name, p.image1 AS image 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = $user_id
    ");
    while ($row = mysqli_fetch_assoc($cart_query)) {
        $cart_items[] = $row;
        $cart_count += $row['quantity'];
        $total_amount += $row['quantity'] * $row['price'];
    }

    // Wishlist items
    $wishlist_result = mysqli_query($con, "SELECT COUNT(*) AS count FROM wishlist WHERE user_id = $user_id");
    $wishlist_data = mysqli_fetch_assoc($wishlist_result);
    $wishlist_count = $wishlist_data['count'];
} else {
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $cart_items[] = $item;
            $cart_count += $item['quantity'];
            $total_amount += $item['quantity'] * $item['price'];
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Royal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/icons/favicon-128.png"/>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="fonts/linearicons-v1.0.0/icon-font.min.css">
    <link rel="stylesheet" href="vendor/animate/animate.css">
    <link rel="stylesheet" href="vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" href="vendor/animsition/css/animsition.min.css">
    <link rel="stylesheet" href="vendor/select2/select2.min.css">
    <link rel="stylesheet" href="vendor/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="vendor/slick/slick.css">
    <link rel="stylesheet" href="vendor/MagnificPopup/magnific-popup.css">
    <link rel="stylesheet" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="css/util.css">
    <link rel="stylesheet" href="css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
.block2-pic {
    position: relative;
    overflow: hidden;
}
.block2-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.4);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.5s ease;
    z-index: 10;
}
.block2-pic:hover .block2-overlay {
    opacity: 1;
    visibility: visible;
}
.block2-overlay a {
    display: inline-block;
    text-align: center;
    padding: 10px 15px;
    font-size: 14px;
    margin: 5px 0;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid #000;
}
.block2-overlay a:first-child {
    background-color: #fff;
    color: #333;
    border-color: #999;
}
.block2-overlay a:last-child {
    background-color: #000;
    color: #fff;
	border-color: #000;
}
.block2-overlay a:last-child:hover {
    background-color: #444;
}
.delete-btn i {
    font-size: 1.1rem;
    transition: 0.2s ease;
}
.delete-btn:hover i {
    transform: scale(1.2);
    color: white;
}
</style>

</head>
<body class="animsition">

<header class="header-v4">
    <div class="wrap-header-mobile">
        <div class="logo-mobile">
            <a href="index.php"><img src="images/icons/logo-01.png" alt="IMG-LOGO"></a>
        </div>

        <div class="wrap-icon-header flex-w flex-r-m m-r-15">
            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
                <i class="zmdi zmdi-search"></i>
            </div>

            <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" 
                id="cart-count" data-notify="<?= $cart_count ?>">
                <i class="zmdi zmdi-shopping-cart"></i>
            </div>

            <a href="wishlist.php" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti" data-notify="<?= $wishlist_count ?>">
                <i class="zmdi zmdi-favorite-outline"></i>
            </a>
        </div>

        <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </div>
    </div>

    <div class="menu-mobile">
        <ul class="main-menu-m">
            <li><a href="index.php">Home</a></li>
            <li><a href="product.php">Shop</a></li>
            <li><a href="shoping-cart.php">Collections</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
            <?php if (isset($_SESSION['user_id'])): ?><li><a href="my-orders.php">My Orders</a></li><?php endif; ?>
        </ul>
    </div>

    <div class="container-menu-desktop">
        <div class="wrap-menu-desktop how-shadow1">
            <nav class="limiter-menu-desktop container">
                <a href="index.php" class="logo">
                    <img src="images/icons/logo-03.jfif" alt="IMG-LOGO">
                </a>
                <div class="menu-desktop">
                    <ul class="main-menu">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="product.php">Shop</a></li>
                        <li><a href="features.php">Collections</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="contact.php">Contact</a></li>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li><a href="my-orders.php">My Orders</a></li>
                        <?php endif; ?>
                        <!-- User Profile Icon -->
                        <li>
                            <a href="<?= isset($_SESSION['user_id']) ? 'user_profile.php?id=' . $_SESSION['user_id'] : 'login.php' ?>" 
                            style="display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; background-color: black; border-radius: 50%; overflow: hidden; text-decoration: none;">
                                <?php if(isset($_SESSION['user_img']) && !empty($_SESSION['user_img'])): ?>
                                    <img src="<?= htmlspecialchars($_SESSION['user_img']) ?>" style="width: 40px; height: 40px; border-radius: 50%;">
                                <?php else: ?>
                                    <i class="fa fa-user" style="color: white; font-size: 18px;"></i>
                                <?php endif; ?>
                            </a>
                        </li>

                        <!-- Register Button -->
                        <?php if(!isset($_SESSION['user_id'])): ?>
                        <li><a class="btn1" style="padding: 10px 20px; background-color: #333; color: white; border-radius: 5px; margin-left: 5px;" href="registration.php">Register</a></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="wrap-icon-header flex-w flex-r-m">
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                        <i class="zmdi zmdi-search"></i>
                    </div>
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" data-notify="<?= $cart_count ?>">
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </div>
                    <a href="wishlist.php" id="wishlist-count" class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 icon-header-noti" data-notify="<?= $wishlist_count ?>">
                        <i class="zmdi zmdi-favorite-outline"></i>
                    </a>
                </div>
            </nav>
        </div>
    </div>
</header>

<!-- 🔎 Search Modal -->
<div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
    <button class="flex-c-m btn-hide-modal-search trans-04">
        <i class="zmdi zmdi-close"></i>
    </button>
    <div class="container-search-header" style="width: 60%; margin: auto; position: relative;">
        <input id="search-box" class="form-control" type="text" placeholder="Search for products...">
        <div id="search-results" style="background: white; position: absolute; top: 45px; left: 0; right: 0; 
             width: 100%; max-height: 300px; overflow-y: auto; border: 1px solid #ccc; display: none; 
             z-index: 999; border-radius: 5px;">
        </div>
    </div>
</div>

<!-- Cart Panel -->
<div class="wrap-header-cart js-panel-cart">
    <div class="s-full js-hide-cart"></div>
    <div class="header-cart flex-col-l p-l-65 p-r-25">
        <div class="header-cart-title flex-w flex-sb-m p-b-8">
            <span class="mtext-103 cl2">Your Cart</span>
            <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
                <i class="zmdi zmdi-close"></i>
            </div>
        </div>

        <div class="header-cart-content flex-w js-pscroll">
            <ul class="header-cart-wrapitem w-full">
                <?php if (!empty($cart_items)): ?>
                    <?php foreach ($cart_items as $item): ?>
                        <li class="header-cart-item flex-w flex-t m-b-12">
                            <div class="header-cart-item-img">
                                <img src="admin/uploads/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                            </div>

                            <div class="header-cart-item-txt p-t-8">
                                <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                    <?= htmlspecialchars($item['name']) ?>
                                </a>
                                <span class="header-cart-item-info">
                                    <?= $item['quantity'] ?> x ₹<?= number_format($item['price'], 2) ?>
                                </span>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="text-center w-full">Your cart is empty</li>
                <?php endif; ?>
            </ul>

            <div class="w-full">
                <div class="header-cart-total w-full p-tb-40">
                    Total: ₹<?= number_format($total_amount, 2) ?>
                </div>

                <div class="header-cart-buttons flex-w w-full">
                    <a href="shoping-cart.php" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
                        View Cart
                    </a>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="vendor/animsition/js/animsition.min.js"></script>
<script src="js/main.js"></script>

<script>
$(document).ready(function(){
    $("#search-box").keyup(function(){
        let query = $(this).val();
        if(query.length > 1){
            $.get("search.php", {q: query}, function(data){
                $("#search-results").html(data).show();
            });
        } else {
            $("#search-results").hide();
        }
    });

    $(document).click(function(e) {
        if (!$(e.target).closest("#search-box, #search-results").length) {
            $("#search-results").hide();
        }
    });
});
</script>

