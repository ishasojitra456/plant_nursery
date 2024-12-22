<?php

session_start();
include '../components/connection.php';

$admin_id = $_SESSION['admin_id'] ?? null;

if (!isset($admin_id)) {
    header('location:login.php');
    exit;
}

// Update order status (if action is taken)
if (isset($_GET['update_status'])) {
    $order_id = $_GET['order_id'];
    $new_status = $_GET['status'];

    $update_order = $conn->prepare("UPDATE `orders` SET status = ? WHERE id = ?");
    $update_order->execute([$new_status, $order_id]);

    $message = "Order status updated successfully!";
}

// Fetch all confirmed orders (status = "in progress")
$select_orders = $conn->prepare("SELECT * FROM `orders` WHERE status = ?");
$select_orders->execute(['in progress']);
$orders = $select_orders->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="admin_style.css?v=<?php echo time(); ?>">
    <title>plant nursery Admin Panel- Confirmed Orders</title>
</head>
<body>
    <?php include '../components/admin_header.php'; ?>

    <div class="main">
        <div class="banner">
            <h1>Confirmed Orders</h1>
        </div>

        <div class="title2">
            <a href="dashboard.php">Home</a> <span>Confirmed Orders</span>
        </div>

        <section class="dashboard">
            <h1 class="heading">Confirmed Orders (In Progress)</h1>

            <?php if (isset($message)) { ?>
                <p class="success-message"><?= htmlspecialchars($message); ?></p>
            <?php } ?>

            <div class="box-container">
                <?php if (count($orders) > 0) { ?>
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer Name</th>
                                <th>Product</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($order['id']); ?></td>
                                    <td><?= htmlspecialchars($order['user_name'] ?? 'N/A'); ?></td>
                                    <td><?= htmlspecialchars($order['product_name'] ?? 'N/A'); ?></td>
                                    <td>$<?= htmlspecialchars($order['total_price'] ?? '0.00'); ?></td>
                                    <td><?= htmlspecialchars($order['status']); ?></td>
                                    <td>
                                        <!-- Action buttons to update order status -->
                                        <a href="conorder.php?update_status&order_id=<?= htmlspecialchars($order['id']); ?>&status=completed" class="btn green">Complete</a>
                                        <a href="conorder.php?update_status&order_id=<?= htmlspecialchars($order['id']); ?>&status=canceled" class="btn red">Cancel</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <p>No confirmed orders in progress.</p>
                <?php } ?>
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
