<?php
session_start();
include '../components/connection.php';

$admin_id = $_SESSION['admin_id'] ?? null;

if (!isset($admin_id)) {
    header('location:login.php');
    exit;
}

// Handle the edit form submission
if (isset($_POST['update_admin'])) {
    $edit_id = $_POST['edit_id'];
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    // Handle the image upload
    $image = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_images/' . $image;

    // Check if image is uploaded
    if (!empty($image)) {
        // Ensure the target directory exists
        if (!file_exists('../uploaded_images')) {
            mkdir('../uploaded_images', 0777, true); // Create the folder if it doesn't exist
        }

        // Move the uploaded file to the server folder and check for success
        if (move_uploaded_file($image_tmp_name, $image_folder)) {
            // Update admin with image
            $update_admin = $conn->prepare("UPDATE `admin` SET `name` = ?, `email` = ?, `profile` = ? WHERE `id` = ?");
            $update_admin->execute([$name, $email, $image, $edit_id]);

            echo "<script>alert('Image uploaded successfully!');</script>"; // Debugging: Alert success
        } else {
            echo "<script>alert('Failed to upload image.');</script>"; // Debugging: Alert failure
        }
    } else {
        // Update admin without image
        $update_admin = $conn->prepare("UPDATE `admin` SET `name` = ?, `email` = ? WHERE `id` = ?");
        $update_admin->execute([$name, $email, $edit_id]);
    }

    $success_msg[] = 'Admin updated successfully!';
}

// Handle admin deletion
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    
    // Fetch the current admin data to delete the image
    $select_admin_image = $conn->prepare("SELECT profile FROM `admin` WHERE id = ?");
    $select_admin_image->execute([$delete_id]);
    $fetch_image = $select_admin_image->fetch(PDO::FETCH_ASSOC);
    
    if (!empty($fetch_image['profile'])) {
        unlink('../uploaded_images/' . $fetch_image['profile']);  // Delete the image from the server
    }

    // Delete the admin from the database
    $delete_admin = $conn->prepare("DELETE FROM `admin` WHERE id = ?");
    $delete_admin->execute([$delete_id]);

    header('location:register_admin.php');
}

// Fetch the admin data to populate the form
$select_admin = $conn->prepare("SELECT * FROM `admin`");
$select_admin->execute();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="admin_style.css?v=<?php echo time(); ?>">
    <title>RURAL TOUCH AGRO Admin Panel - Register Admin's Page</title>
</head>

<body>
    <?php include '../components/admin_header.php'; ?>

    <div class="main">
        <div class="banner">
            <h1>Register Admin's</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">home</a><span>register admin's</span>
        </div>

        <section class="accounts">
            <h1 class="heading">Register Admin's</h1>
            <div class="box-container">
                <?php
                if ($select_admin->rowCount() > 0) {
                    while ($fetch_admin = $select_admin->fetch(PDO::FETCH_ASSOC)) {
                        $admin_id = $fetch_admin['id'];
                        $image = !empty($fetch_admin['profile']) ? $fetch_admin['profile'] : 'default.png';
                ?>
                        <div class="box">
                            <!-- Ensure the image path is correct -->
                            <img src="../img2/<?= htmlspecialchars($image); ?>" alt="Admin Image" width="100" height="100">
                            <p>Admin ID: <span><?= htmlspecialchars($admin_id); ?></span></p>
                            <p>Admin Name: <span><?= htmlspecialchars($fetch_admin['name']); ?></span></p>
                            <p>Admin Email: <span><?= htmlspecialchars($fetch_admin['email']); ?></span></p>
                            <a href="edit_profile.php?id=<?= htmlspecialchars($admin_id); ?>" class="btn">Edit</a>
                            <a href="admin_account.php?delete=<?= htmlspecialchars($admin_id); ?>" onclick="return confirm('Are you sure?')" class="btn delete">Delete</a>
                        </div>
                <?php
                    }
                } else {
                    echo '<div class="empty"><p>No admin registered yet!</p></div>';
                }
                ?>
            </div>
        </section>

        <!-- Edit Admin Form -->
        <section class="edit-admin-section" style="display: none;" id="edit-admin-section">
            <h1 class="heading">Edit Admin</h1>
            <form action="" method="post" class="edit-form" enctype="multipart/form-data">
                <input type="hidden" name="edit_id" id="edit_id">
                <div class="input-field">
                    <p>Admin Name <sup>*</sup></p>
                    <input type="text" name="name" id="edit_name" required placeholder="Enter admin name">
                </div>
                <div class="input-field">
                    <p>Admin Email <sup>*</sup></p>
                    <input type="email" name="email" id="edit_email" required placeholder="Enter admin email">
                </div>
                <div class="input-field">
                    <p>Admin Image</p>
                    <input type="file" name="image" id="edit_image">
                </div>
                <button type="submit" name="update_admin" class="btn">Update Admin</button>
                <button type="button" onclick="hideEditForm()" class="btn">Cancel</button>
            </form>
        </section>
    </div>

    <script>
        function showEditForm(adminId, adminName, adminEmail, adminImage) {
            document.getElementById('edit-admin-section').style.display = 'block';
            document.getElementById('edit_id').value = adminId;
            document.getElementById('edit_name').value = adminName;
            document.getElementById('edit_email').value = adminEmail;
        }

        function hideEditForm() {
            document.getElementById('edit-admin-section').style.display = 'none';
        }
    </script>

    <?php include '../components/alert.php'; ?>
</body>

</html>
