<?php
session_start();
include '../components/connection.php';

// Check if the admin is logged in
$admin_id = $_SESSION['admin_id'] ?? null; 

if (!isset($admin_id)) {
    header('Location: login.php');
    exit;
}

// Handle message deletion
if (isset($_POST['delete'])) {
    $delete_id = filter_var($_POST['delete_id'], FILTER_SANITIZE_STRING);

    $verify_delete = $conn->prepare("SELECT * FROM message WHERE id = ?");
    $verify_delete->execute([$delete_id]);

    if ($verify_delete->rowCount() > 0) {
        $delete_message = $conn->prepare("DELETE FROM message WHERE id = ?");
        $delete_message->execute([$delete_id]);
        echo "<script>swal('Deleted!', 'Message has been deleted.', 'success');</script>";
    } else {
        echo "<script>swal('Warning!', 'Message already deleted.', 'warning');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="admin_style.css?v=<?php echo time(); ?>">
    <title>plant nursery Admin Panel - Unread Messages Page</title>
</head>
<body>
    <?php include '../components/admin_header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Unread Messages</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">Home</a><span>/ Unread Messages</span>
        </div>
        <section class="accounts">
            <h1 class="heading">Unread Messages</h1>
            <div class="box-container">
                <?php
                    $select_message = $conn->prepare("SELECT * FROM message");
                    $select_message->execute();

                    if ($select_message->rowCount() > 0) {
                        while($fetch_message = $select_message->fetch(PDO::FETCH_ASSOC)){
                ?>
                <div class="box">
                    <h3 class="name"><?= htmlspecialchars($fetch_message['name']); ?></h3>
                    <h4><?= htmlspecialchars($fetch_message['email']); ?></h4>
                    <p><?= htmlspecialchars($fetch_message['message']); ?></p>   
                    <form action="" method="post" class="flex-btn">
                        <input type="hidden" name="delete_id" value="<?= htmlspecialchars($fetch_message['id']); ?>">
                        <button type="submit" name="delete" class="btn" onclick="return confirm('Are you sure you want to delete this message?');">Delete Message</button>
                    </form>
                </div>
                <?php
                        }
                    } else {
                        echo '<div class="empty"><p>No messages sent yet!</p></div>';
                    }
                ?>
            </div>
        </section>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include '../components/alert.php'; ?>
</body>
</html>
