<?php
session_start();
include '../components/connection.php';

// Check if the admin is logged in
$admin_id = $_SESSION['admin_id'] ?? null;

if (!isset($admin_id)) {
    header('Location: login.php');
    exit;
}

// Fetch the message by ID
$message_id = $_GET['id'] ?? null;
if ($message_id) {
    $select_message = $conn->prepare("SELECT * FROM message WHERE id = ?");
    $select_message->execute([$message_id]);
    $message = $select_message->fetch(PDO::FETCH_ASSOC);
} else {
    header('Location: admin_message.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="admin_style.css?v=<?php echo time(); ?>">
    <title>Message Details</title>
</head>
<body>
    <?php include '../components/admin_header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Message Details</h1>
        </div>
        <div class="message-details">
            <h3>Name: <?= htmlspecialchars($message['name']); ?></h3>
            <h4>Email: <?= htmlspecialchars($message['email']); ?></h4>
            <p>Message: <?= htmlspecialchars($message['message']); ?></p>
        </div>
    </div>

    <?php include '../components/alert.php'; ?>
</body>
</html>
