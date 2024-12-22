<?php
include 'components/connection.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

// Logout functionality
if (isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
}

// Update Order
if (isset($_POST['update_order'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];
    $update_order = $conn->prepare("UPDATE `orders` SET status = ? WHERE id = ? AND user_id = ?");
    $update_order->execute([$new_status, $order_id, $user_id]);
    header("location: orders.php");
}

// Delete Order
if (isset($_POST['delete_order'])) {
    $order_id = $_POST['order_id'];
    $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ? AND user_id = ?");
    $delete_order->execute([$order_id, $user_id]);
    header("location: orders.php");
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
    <title>plant nursery - Order Page</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>My Order</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a><span>/ Order</span>
        </div>
        
        <!-- Product Section -->
        <section class="products">
            <div class="box-container">
                <?php
                    $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? ORDER BY date DESC");
                    $select_orders->execute([$user_id]);
                    if ($select_orders->rowCount() > 0) {
                        while ($fetch_order = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                            $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                            $select_products->execute([$fetch_order['product_id']]);
                            if ($select_products->rowCount() > 0) {
                                while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class="box" <?php if ($fetch_order['status'] == 'cancel') {echo 'style="border:2px solid red";';} ?>>
                    <a href="view_order.php?get_id=<?= $fetch_order['id']; ?>">
                        <!--<p class="date"><i class="bi bi-calendar-fill"></i><span>'<?= $fetch_order['date']; ?></span></p>-->
                        <img src="img4/<?= $fetch_product['image']; ?>" class="image" width="200px" hight="200px">
                        <div class="row">
                            <h3 class="name"><?= $fetch_product['name']; ?></h3>
                            <p class="price">Price: RS<?= $fetch_order['price']; ?> X <?= $fetch_order['qty']; ?></p>
                            <p class="status" style="color:<?php if($fetch_order['status']=='delivered'){echo 'green';}elseif($fetch_order['status']=='canceled'){echo 'red';}else{echo 'orange';} ?>">
                                <?= ucfirst($fetch_order['status']); ?>
                            </p>
                        </div>
                    </a>

                    <!-- Update Order Form -->
                    <form method="POST" class="order-actions">
                        <input type="hidden" name="order_id" value="<?= $fetch_order['id']; ?>">
                       
                       
                        <button type="submit" name="delete_order" class="btn-delete" onclick="return confirm('Are you sure you want to delete this order?');">Delete</button>
                    </form>
                </div>
                <?php
                                }
                            }
                        }
                    } else {
                        echo '<p class="empty">No orders have been placed yet!</p>';
                    }
                ?>
            </div>
        </section>

        <!-- Extra Information Section -->
        <section class="extra-info">
            <div class="box-container">
                <div class="title">
                    <img src="img4/logo.png"width="100px" height="100px" class="logo">
                    <h1>My Orders</h1>
                    <p>Live everyday with our Indian tradition by using RT Agro products.</p>
                </div>
            </div>
        </section>

        <?php include 'components/footer.php'; ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>
