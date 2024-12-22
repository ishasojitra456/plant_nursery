<?php
session_start();
include '../components/connection.php';

$admin_id = $_GET['id'] ?? null;

if (!isset($admin_id)) {
    header('location:dashboard.php');
    exit;
}

if (isset($_POST['update_admin'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Basic validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_msg[] = 'Invalid email format';
    } else {
        $update_admin = $conn->prepare("UPDATE `admin` SET `name` = ?, `email` = ? WHERE `id` = ?");
        if ($update_admin->execute([$name, $email, $admin_id])) {
            $success_msg[] = 'Admin updated successfully!';
        } else {
            $error_msg[] = 'Failed to update admin.';
        }
    }
}

$select_admin = $conn->prepare("SELECT * FROM `admin` WHERE `id` = ?");
$select_admin->execute([$admin_id]);
$fetch_admin = $select_admin->fetch(PDO::FETCH_ASSOC);

if (!$fetch_admin) {
    header('location:dashboard.php');
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
    <title>Edit Admin - RURAL TOUCH AGRO Admin Panel</title>
</head>

<body>
    <?php include '../components/admin_header.php'; ?>

    <div class="main">
        <section class="edit-admin-section">
            <h1 class="heading">Edit Admin</h1>

            <!-- Display success or error messages -->
            <?php
            if (isset($success_msg) && !empty($success_msg)) {
                foreach ($success_msg as $msg) {
                    echo '<div class="message">' . htmlspecialchars($msg) . '</div>';
                }
            }
            if (isset($error_msg) && !empty($error_msg)) {
                foreach ($error_msg as $msg) {
                    echo '<div class="message" style="background: red;">' . htmlspecialchars($msg) . '</div>';
                }
            }
            ?>

            <form action="" method="post" class="edit-form">
                <input type="hidden" name="edit_id" value="<?= htmlspecialchars($admin_id); ?>">
                <div class="input-field">
                    <p>Admin Name <sup>*</sup></p>
                    <input type="text" name="name" value="<?= htmlspecialchars($fetch_admin['name']); ?>" required>
                </div>
                <div class="input-field">
                    <p>Admin Email <sup>*</sup></p>
                    <input type="email" name="email" value="<?= htmlspecialchars($fetch_admin['email']); ?>" required>
                </div>
                <button type="submit" name="update_admin" class="btn">Update Admin</button>
                <a href="admin_account.php" class="btn cancel">Cancel</a>
            </form>
        </section>
    </div>

    <!-- Include Alert Component -->
    <?php include '../components/alert.php'; ?>
</body>

</html>
