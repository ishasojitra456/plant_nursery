<?php
include 'components/connection.php';
session_start();

function unique_id() {
    return uniqid('', true);
}

$user_id = $_SESSION['user_id'] ?? '';

// Logout logic
if (isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
    exit();
}

// Add to Wishlist
if (isset($_POST['add_to_wishlist'])) {
    $id = unique_id();
    $product_id = $_POST['product_id'];

    $verify_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ? AND product_id = ?");
    $verify_wishlist->execute([$user_id, $product_id]);

    $cart_num = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
    $cart_num->execute([$user_id, $product_id]);

    if ($verify_wishlist->rowCount() > 0) {
        $warning_msg[] = 'Product already exists in your wishlist';
    } else if ($cart_num->rowCount() > 0) {
        $warning_msg[] = 'Product already exists in your cart';
    } else {
        $select_price = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
        $select_price->execute([$product_id]);
        $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

        $insert_wishlist = $conn->prepare("INSERT INTO `wishlist` (id, user_id, product_id, price) VALUES (?, ?, ?, ?)");
        $insert_wishlist->execute([$id, $user_id, $product_id, $fetch_price['price']]);
        $success_msg[] = "Product added to wishlist successfully";
    }
}

// Add to Cart
if (isset($_POST['add_to_cart'])) {
    $id = unique_id();
    $product_id = $_POST['product_id'];
    $qty = $_POST['qty'];

    $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
    $verify_cart->execute([$user_id, $product_id]);

    $max_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $max_cart_items->execute([$user_id]);

    if ($verify_cart->rowCount() > 0) {
        $warning_msg[] = 'Product already exists in your cart';
    } else if ($max_cart_items->rowCount() > 20) {
        $warning_msg[] = 'Your cart is full';
    } else {
        $select_price = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
        $select_price->execute([$product_id]);
        $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

        $insert_cart = $conn->prepare("INSERT INTO `cart` (id, user_id, product_id, price, qty) VALUES (?, ?, ?, ?, ?)");
        $insert_cart->execute([$id, $user_id, $product_id, $fetch_price['price'], $qty]);
        $success_msg[] = "Product added to cart successfully";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Product Detail</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Product Detail</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a><span>/ Product Detail</span>
        </div>
        <section class="view_page">
            <?php
            if (isset($_GET['pid'])) {
                $pid = $_GET['pid'];
                $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
                $select_products->execute([$pid]);

                if ($select_products->rowCount() > 0) {
                    $fetch_product = $select_products->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="image">
                <img src="image/<?= $fetch_product['image']; ?>">
            </div>
            <div class="title"><?= $fetch_product['name']; ?></div>
            <div class="price">$<?= $fetch_product['price']; ?>/-</div>
            <div class="detail"><?= $fetch_product['product_detail']; ?></div>

            <form action="" method="post" class="box">
                <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">
                <input type="number" name="qty" value="1" min="1" max="99" placeholder="Qty" class="qty-input">
                <div class="flex-btn">
                    <button type="submit" name="add_to_wishlist" class="btn">Add to Wishlist</button>
                    <button type="submit" name="add_to_cart" class="btn">Add to Cart</button>
                </div>
            </form>

            <?php
                } else {
                    echo '<p class="empty">No products available</p>';
                }
            } else {
                echo '<p class="empty">Product not found</p>';
            }
            ?>
        </section>
    </div>
    <script src="script.js"></script>
</body>
</html>
