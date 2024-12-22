<?php
session_start();
include '../components/connection.php';

$admin_id = $_SESSION['admin_id'] ?? null;
$edit_id = $_GET['id'] ?? $admin_id; // Default to the logged-in admin if no ID is provided

if (!isset($admin_id)) {
    header('location:login.php');
    exit;
}

// Fetch the profile data from the database for the selected admin
$fetch_profile = null;
if ($edit_id) {
    $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
    $select_profile->execute([$edit_id]);

    if ($select_profile->rowCount() > 0) {
        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "<script>alert('Profile not found.');</script>";
    }
}

// Handle form submission for profile update
if (isset($_POST['update_profile'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Handle password update if provided
    $password = $_POST['password'] ?? null;
    $hashed_password = null;
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password
    }

    // Handle image upload if provided
    $image = $_FILES['image']['name'] ?? null;
    $image_tmp_name = $_FILES['image']['tmp_name'] ?? null;
    $image_folder = '../img2/' . $image;

    // Initialize the base query and the data array
    $update_query = "UPDATE `admin` SET name = ?, email = ?";
    $update_data = [$name, $email];

    // Add profile image to the query if provided
    if (!empty($image)) {
        if (!file_exists('../img2')) {
            mkdir('../uploaded_images', 0777, true); // Create the folder if it doesn't exist
        }

        if (move_uploaded_file($image_tmp_name, $image_folder)) {
            $update_query .= ", profile = ?";
            $update_data[] = $image; // Add image to data array
        } else {
            echo "<script>alert('Failed to upload image.');</script>";
        }
    }

    // Add password to the query if provided
    if (!empty($hashed_password)) {
        $update_query .= ", password = ?";
        $update_data[] = $hashed_password; // Add hashed password to data array
    }

    // Complete the query with the WHERE clause
    $update_query .= " WHERE id = ?";
    $update_data[] = $edit_id; // Add admin ID to data array

    // Execute the update query
    $update_profile = $conn->prepare($update_query);
    $update_profile->execute($update_data);

    if ($update_profile) {
        $_SESSION['success_message'] = 'Profile updated successfully!';
        header('location:edit_profile.php?id=' . $edit_id);
        exit;
    } else {
        echo "<script>alert('Failed to update profile. Please try again.');</script>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="admin_style.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include '../components/admin_header.php'; ?>

    <div class="main">
        <div class="banner">
            <h1>Edit Profile</h1>
        </div>

        <section class="edit-profile-section">
            <h2>Edit Profile Information</h2>
            
            <form action="" method="post" enctype="multipart/form-data"> <!-- Added enctype for file upload -->
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?= htmlspecialchars($fetch_profile['name'] ?? '') ?>" required>
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?= htmlspecialchars($fetch_profile['email'] ?? '') ?>" required>
    
    <!-- Input for Image Upload -->
    <label for="image">Profile Image:</label>
    <input type="file" id="image" name="image">
    
    <!-- Input for Password -->
    <label for="password">New Password:</label>
    <input type="password" id="password" name="password" placeholder="Enter new password (optional)">
    
    <button type="submit" name="update_profile" class="btn">Update Profile</button>
</form>

        </section>
    </div>

    <!-- SweetAlert CDN Link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Show success message if profile updated -->
    <?php if (isset($_SESSION['success_message'])) { ?>
        <script>
            swal("Success", "<?php echo $_SESSION['success_message']; ?>", "success");
        </script>
        <?php unset($_SESSION['success_message']); } ?>

    <!-- Custom JS Link -->
    <script type="text/javascript" src="script.js"></script>
</body>
</html>
