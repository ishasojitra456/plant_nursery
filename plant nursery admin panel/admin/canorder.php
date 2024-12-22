<?php

session_start();
include '../components/connection.php';

// Check if the admin is logged in
$admin_id = $_SESSION['admin_id'] ?? null;

if (!isset($admin_id)) {
    header('location:login.php');
    exit;
}

// Handle changing the status of an order (if needed)
if (isset($_POST['update'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];
    $order_id = filter_var($order_id, FILTER_SANITIZE_STRING);

    $update_order = $conn->prepare("UPDATE `orders` SET status = ? WHERE id = ?");
    $update_order->execute([$new_status, $order_id]);

    $success_msg[] = 'Order status updated successfully';
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="admin_style.css?v=<?php echo time(); ?>">
    <title>RURAL TOUCH AGRO Admin Panel - Canceled Orders Page</title>
</head>
<body>
    <?php include '../components/admin_header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>canceled orders</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">dashboard</a><span>/ canceled orders</span>
        </div>
        <section class="show-post">
            <h1 class="heading">canceled orders</h1>
            <div class="box-container">
                <?php
                $select_canceled_orders = $conn->prepare("SELECT * FROM `orders` WHERE status = ?");
                $select_canceled_orders->execute(['canceled']);

                if ($select_canceled_orders->rowCount() > 0) {
                    while ($fetch_order = $select_canceled_orders->fetch(PDO::FETCH_ASSOC)) {
                        $total_price = $fetch_order['total_price'] ?? 'N/A'; // Default value if not set
                        $order_details = $fetch_order['order_details'] ?? 'No details'; // Default value if not set
                ?>
                <form action="" method="post" class="box">
                    <input type="hidden" name="order_id" value="<?= htmlspecialchars($fetch_order['id']); ?>">
                    <div class="status" style="color: red;"><?= htmlspecialchars($fetch_order['status']); ?></div>
                    <div class="price">$<?= htmlspecialchars($total_price); ?>/-</div>
                    <div class="title"><?= htmlspecialchars($order_details); ?></div>
                    <div class="flex-btn">
                        <select name="status" class="btn">
                            <option value="completed">Mark as Completed</option>
                            <option value="in progress">Mark as In Progress</option>
                        </select>
                        <button type="submit" name="update" class="btn">Update Status</button>
                    </div>
                </form>
                <?php
                    }
                } else {
                    echo '
                        <div class="empty">
                            <p>No canceled orders yet! <br> <a href="order.php" class="btn">View all orders</a></p>
                        </div>
                    ';
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
