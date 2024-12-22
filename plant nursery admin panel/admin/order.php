<?php
session_start();
include '../components/connection.php';

$admin_id = $_SESSION['admin_id'] ?? null; 

if (!isset($admin_id)){
    header('location:login.php');
    exit;
}

// Delete order
if (isset($_POST['delete_order'])) {
    $order_id = filter_input(INPUT_POST, 'order_id', FILTER_SANITIZE_STRING);

    $verify_delete = $conn->prepare("SELECT * FROM orders WHERE id = ?");
    $verify_delete->execute([$order_id]);

    if ($verify_delete->rowCount() > 0) {
        $delete_order = $conn->prepare("DELETE FROM orders WHERE id = ?");
        $delete_order->execute([$order_id]);
        $success_msg[] = 'Order deleted successfully.';
    } else {
        $warning_msg[] = 'Order already deleted or not found.';
    }
}

// Update order
if (isset($_POST['update_order'])) {
    $order_id = filter_input(INPUT_POST, 'order_id', FILTER_SANITIZE_STRING);
    $update_payment = filter_input(INPUT_POST, 'update_payment', FILTER_SANITIZE_STRING);

    $update_pay = $conn->prepare("UPDATE orders SET payment_status = ? WHERE id = ?");
    $update_pay->execute([$update_payment, $order_id]);
    $success_msg[] = 'Order updated successfully.';
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="admin_style.css?v=<?php echo time(); ?>">
    <title>plant nursery Admin Panel - Orders</title>
</head>
<body>
    <?php include '../components/admin_header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Orders Placed</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">Home</a><span> / Orders Placed</span>
        </div>
        <section class="order-container">
            <h1 class="heading">Orders Placed</h1>
            <div class="box-container">
                <?php
                    $select_orders = $conn->prepare("SELECT * FROM orders");
                    $select_orders->execute();

                    if ($select_orders->rowCount() > 0) {
                        while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class="box">
                    <div class="status" style="color: <?php echo ($fetch_orders['status'] == 'in progress') ? "green" : "red"; ?>;">
                        <?= htmlspecialchars($fetch_orders['status']); ?>
                    </div>
                    <div class="detail">
                        <p>Username: <span><?= htmlspecialchars($fetch_orders['name']); ?></span></p>
                        <p>User ID: <span><?= htmlspecialchars($fetch_orders['id']); ?></span></p>
                        <p>Placed on: <span><?= htmlspecialchars($fetch_orders['date']); ?></span></p>
                        <p>Phone: <span><?= htmlspecialchars($fetch_orders['number']); ?></span></p>
                        <p>Email: <span><?= htmlspecialchars($fetch_orders['email']); ?></span></p>
                        <p>Total Price: <span><?= htmlspecialchars($fetch_orders['price']); ?></span></p>
                        <p>Payment Method: <span><?= htmlspecialchars($fetch_orders['method']); ?></span></p>
                        <p>Address: <span><?= htmlspecialchars($fetch_orders['address']); ?></span></p>
                    </div>
                    <form action="" method="post">
                        <input type="hidden" name="order_id" value="<?= htmlspecialchars($fetch_orders['id']); ?>">
                        <select name="update_payment" required>
                            <option disabled selected><?= htmlspecialchars($fetch_orders['payment_status']); ?></option>
                            <option value="pending">Pending</option>
                            <option value="delivered">delivered</option>
                        </select>
                        <div class="flex-btn">
                            <button type="submit" name="update_order" class="btn">Update order</button>
                            <button type="submit" name="delete_order" class="btn" onclick="return confirm('Are you sure you want to delete this order?');">Delete Order</button>
                        </div>
                    </form>
                </div>
                <?php
                        }
                    } else {
                        echo '<div class="empty"><p>No orders placed!</p></div>';
                    }
                ?>
            </div>
        </section>
    </div>

    <!-- SweetAlert CDN Link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- Custom JS Link -->
    <script type="text/javascript" src="script.js"></script>

    <!-- Include Alert Component -->
    <?php include '../components/alert.php'; ?>
</body>   
</html>
