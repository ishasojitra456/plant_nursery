<?php

session_start();
include '../components/connection.php';


$admin_id = $_SESSION['admin_id'] ?? null; 


if (!isset($admin_id)){
    header('location:login.php');
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
    <title>plant nursery Admin Panel - register users's Page</title>
</head>
<body>
    <?php include '../components/admin_header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>register users's</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">home</a><span>register users's</span>
        </div>
        <section class="accounts">
            <h1 class="heading">register users's</h1>
            <div class="box-container">
                <?php
                    $select_users = $conn->prepare("SELECT * FROM `users`");
                    $select_users->execute();

                    if ($select_users->rowCount() > 0) {
                        while($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)){
                            $user_id = $fetch_users['id'];

                ?>
                <div class="box">
                    
                    <p>user id : <span><?= $user_id; ?></span></p>
                    <p>user name : <span><?= $fetch_users['name']; ?></span></p>
                    <p>user email : <span></span><?= $fetch_users['email']; ?></p>
                </div>
                <?php
                        }
                    }else{
                        echo '<div class="empty">
                                <p>no user registered yet!</p>
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
