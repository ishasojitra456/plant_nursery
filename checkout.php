<?php
include 'components/connection.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
}

if (isset($_POST['place_order'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $address = $_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['country'] . ', ' . $_POST['pincode'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);
    $address_type = $_POST['address_type'];
    $address_type = filter_var($address_type, FILTER_SANITIZE_STRING);
    $method = $_POST['method'];
    $method = filter_var($method, FILTER_SANITIZE_STRING);

    $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $verify_cart->execute([$user_id]);

    if (isset($_GET['get_id'])) {
        $get_product = $conn->prepare("SELECT * FROM `products` WHERE id=? LIMIT 1");
        $get_product->execute([$_GET['get_id']]);
        if ($get_product->rowCount() > 0) {
            while ($fetch_p = $get_product->fetch(PDO::FETCH_ASSOC)) {
                $insert_orders = $conn->prepare("INSERT INTO `orders`(id, user_id, name, number, email, address, address_type, method, product_id, price, qty) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
                $insert_orders->execute([uniqid(), $user_id, $name, $number, $email, $address, $address_type, $method, $fetch_p['id'], $fetch_p['price'], 1]);
                header("location: order.php");
            }
        } else {
            $warning_msg[] = 'Product not found or something went wrong.';
        }
    } elseif ($verify_cart->rowCount() > 0) {
        while ($f_cart = $verify_cart->fetch(PDO::FETCH_ASSOC)) {
            $insert_orders = $conn->prepare("INSERT INTO `orders`(id, user_id, name, number, email, address, address_type, method, product_id, price, qty) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
            $insert_orders->execute([uniqid(), $user_id, $name, $number, $email, $address, $address_type, $method, $f_cart['product_id'], $f_cart['price'], $f_cart['qty']]);
        }

        if ($insert_orders) {
            $delete_cart_id = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
            $delete_cart_id->execute([$user_id]);
            header("location: orders.php");
        }
    } else {
        $warning_msg[] = 'Your cart is empty or something went wrong.';
    }
}
?>
<style type="text/css">
    <?php include 'style.css'; ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>RURAL TOUCH AGRO - Checkout Page</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Checkout Summary</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a><span>/ Checkout Summary</span>
        </div>
        <section class="checkout">
            <div class="title">
                <img src="img/download.png" class="logo">
                <h1>Checkout Summary</h1>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Qui, ad nemo fugiat Est.</p>
            </div>
            <div class="row">
                <form method="post">
                    <h3>Billing Details</h3>
                    <div class="flex">
                        <div class="box">
                            <div class="input-field">
                                <p>Your Name <span>*</span></p>
                                <input type="text" name="name" required maxlength="50" placeholder="Enter Your Name" class="input">
                            </div>
                            <div class="input-field">
                                <p>Your Number <span>*</span></p>
                                <input type="number" name="number" required maxlength="10" placeholder="Enter Your Number" class="input">
                            </div>
                            <div class="input-field">
                                <p>Your Email <span>*</span></p>
                                <input type="email" name="email" required maxlength="50" placeholder="Enter Your Email" class="input">
                            </div>
                            <div class="input-field">
                                <p>Payment Method <span>*</span></p>
                                <select name="method" class="input">
                                    <option value="cash on delivery">Cash on Delivery</option>
                                    <option value="credit or debit card">Credit or Debit</option>
                                    <option value="net banking">Net Banking</option>
                                    <option value="UPI or RuPay">UPI or RuPay</option>
                                    <option value="paytm">Paytm</option>
                                </select>
                            </div>
                            <div class="input-field">
                                <p>Address Type <span>*</span></p>
                                <select name="address_type" class="input">
                                    <option value="home">Home</option>
                                    <option value="office">Office</option>
                                </select>
                            </div>
                        </div>
                        <div class="box">
                            <div class="input-field">
                                <p>Address Line 01 <span>*</span></p>
                                <input type="text" name="flat" required maxlength="50" placeholder="e.g. Flat & Building Number" class="input">
                            </div>
                            <div class="input-field">
                                <p>Address Line 02 <span>*</span></p>
                                <input type="text" name="street" required maxlength="50" placeholder="e.g. Street Name" class="input">
                            </div>
                            <div class="input-field">
                                <p>City Name <span>*</span></p>
                                <input type="text" name="city" required maxlength="50" placeholder="Enter Your City Name" class="input">
                            </div>
                            <div class="input-field">
                                <p>Country Name <span>*</span></p>
                                <input type="text" name="country" required maxlength="50" placeholder="Enter Your Country Name" class="input">
                            </div>
                            <div class="input-field">
                                <p>Pincode <span>*</span></p>
                                <input type="text" name="pincode" required maxlength="6" placeholder="395010" min="0" max="999999" class="input">
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="place_order" class="btn">Place Order</button>
                </form>
                <div class="summary">
                    <h3>My Bag</h3>
                    <div class="box-container">
                        <?php
                        $grand_total = 0;
                        if (isset($_GET['get_id'])) {
                            $select_get = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                            $select_get->execute([$_GET['get_id']]);
                            while ($fetch_get = $select_get->fetch(PDO::FETCH_ASSOC)) {
                                $sub_total = $fetch_get['price'];
                                $grand_total += $sub_total;
                        ?>
                        <div class="flex">
                            <img src="img4/<?=$fetch_get['image']; ?>" class="img">
                            <div>
                                <h3 class="name"><?=$fetch_get['name']; ?></h3>
                                <p class="price"><?=$fetch_get['price']; ?>/-</p>
                            </div>
                        </div>
                        <?php
                            }
                        } else {
                            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                            $select_cart->execute([$user_id]);
                            if ($select_cart->rowCount() > 0) {
                                while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                                    $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                                    $select_products->execute([$fetch_cart['product_id']]);
                                    $fetch_product = $select_products->fetch(PDO::FETCH_ASSOC);

                                    if ($fetch_product) { // Check if fetch was successful
                                        $sub_total = ($fetch_cart['qty'] * $fetch_product['price']);
                                        $grand_total += $sub_total;
                        ?>
                        <div class="flex">
                            <img src="img4/<?=$fetch_product['image']; ?>" class="img">
                            <div>
                                <h3 class="name"><?=$fetch_product['name']; ?></h3>
                                <p class="price"><?=$fetch_product['price']; ?>/-</p>
                            </div>
                        </div>
                        <?php
                                    } else {
                                        echo '<p class="empty">Product not found or has been removed.</p>';
                                    }
                                }
                            } else {
                                echo '<p class="empty">Your Bag is Empty</p>';
                            }
                        }
                        ?>
                    </div>
                    <div class="grand-total">Total Amount: <span><?= $grand_total; ?>/-</span></div>
                </div>
            </div>
        </section>
    </div>
    <?php include 'components/footer.php'; ?>
    <script src="script.js"></script>
</body>
</html>
