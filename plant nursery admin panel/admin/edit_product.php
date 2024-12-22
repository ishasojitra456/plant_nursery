<?php
// Start session and include necessary files at the beginning
session_start();
include '../components/connection.php';

$admin_id = $_SESSION['admin_id'] ?? null; // Use null coalescing to handle undefined session

if (!isset($admin_id)) {
    header('location:login.php');
    exit();
}

// Update product
if (isset($_POST['update'])) {
    $post_id = $_GET['id'];

    $name = $_POST['name'] ?? ''; // Ensure that the key exists
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $price = $_POST['price'] ?? ''; // Ensure that the key exists
    $price = filter_var($price, FILTER_SANITIZE_STRING);

    $content = $_POST['content'] ?? ''; // Ensure that the key exists
    $content = filter_var($content, FILTER_SANITIZE_STRING);

    $status = $_POST['status'] ?? ''; // Ensure that the key exists
    $status = filter_var($status, FILTER_SANITIZE_STRING);

    // UPDATE product
    $update_product = $conn->prepare("UPDATE `products` SET name = ?, price = ?, product_detail = ?, status = ? WHERE id = ?");
    $update_product->execute([$name, $price, $content, $status, $post_id]);

    $success_msg[] = 'Product updated';

    $old_image = $_POST['old_image'];
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../image/' . $image;

    $select_image = $conn->prepare("SELECT * FROM `products` WHERE image = ?");
    $select_image->execute([$image]);

    if (!empty($image)) {
        if ($image_size > 2000000) {
            $warning_msg[] = 'Image size is too large';
        } elseif ($select_image->rowCount() > 0 && $image != '') {
            $warning_msg[] = 'Please rename your image';
        } else {
            $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
            $update_image->execute([$image, $post_id]);
            move_uploaded_file($image_tmp_name, $image_folder);

            if ($old_image != $image && $old_image != '') {
                unlink('../image/' . $old_image);
            }
            $success_msg[] = 'Image updated';
        }
    }
}

// Delete product
if (isset($_POST['delete'])) {
    $p_id = $_POST['product_id'] ?? ''; // Ensure that the key exists
    $p_id = filter_var($p_id, FILTER_SANITIZE_STRING);

    $delete_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $delete_image->execute([$p_id]);

    $fetch_product_image = $delete_image->fetch(PDO::FETCH_ASSOC);

    if ($fetch_product_image['image'] != '') {
        unlink('../image/' . $fetch_product_image['image']);
    }

    $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
    $delete_product->execute([$p_id]);

    header('location:view_product.php');
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- boxicon cdn link -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="admin_style.css?v=<?php echo time(); ?>">
    <title>plant nursery Admin Panel - Edit Product Page</title>
</head>

<body>
    <?php include '../components/admin_header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Edit Products</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">Dashboard</a><span>/ Edit Products</span>
        </div>
        <section class="edit-post">
            <h1 class="heading">Edit Product</h1>
            <?php
            $post_id = $_GET['id'];

            $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
            $select_product->execute([$post_id]);

            if ($select_product->rowCount() > 0) {
                while ($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <div class="form-container">
                        <form action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="old_image" value="<?= htmlspecialchars($fetch_product['image']); ?>">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($fetch_product['id']); ?>">

                            <div class="input-field">
                                <label>Update Status</label>
                                <select name="status">
                                    <?php
                                    if (!empty($fetch_product['status'])) {
                                        echo '<option selected disabled value="' . htmlspecialchars($fetch_product['status']) . '">' . htmlspecialchars($fetch_product['status']) . '</option>';
                                    } else {
                                        echo '<option selected disabled>Select Status</option>';
                                    }
                                    ?>
                                    <option value="active">Active</option>
                                    <option value="deactive">Deactive</option>
                                </select>
                            </div>
                            <div class="input-field">
                                <label>Product Name</label>
                                <input type="text" name="name" value="<?= htmlspecialchars($fetch_product['name']); ?>">
                            </div>
                            <div class="input-field">
                                <label>Product Price</label>
                                <input type="number" name="price" value="<?= htmlspecialchars($fetch_product['price']); ?>">
                            </div>
                            <div class="input-field">
                                <label>Product Description</label>
                                <textarea name="content"><?= htmlspecialchars($fetch_product['product_detail']); ?></textarea>
                            </div>
                            <div class="input-field">
                                <label>Product Image</label>
                                <input type="file" name="image" accept="image/*">
                                <img src="../image/<?= htmlspecialchars($fetch_product['image']); ?>">
                            </div>
                            <div class="flex-btn">
                                <button type="submit" name="update" class="btn">Update Product</button>
                                <a href="view_product.php" class="btn">Go Back</a>
                                <button type="submit" name="delete" class="btn">Delete Product</button>
                            </div>
                        </form>
                    </div>
            <?php
                }
            } else {
                echo '
                    <div class="empty">
                        <p>No product added yet! <br> <a href="add_products.php" style="margin-top:1.5rem;" class="btn">Add Product</a></p>
                    </div>
                ';
            }
            ?>
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
