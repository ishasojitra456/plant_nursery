<header class="header">
    <div class="flex">
        <!-- Logo Section -->
        <a href="home.php" class="logo"><img src="img4/logo_1.jpg" width="100px" height="70px"></a>
        
        <!-- Navigation Links -->
        <nav class="navbar">
            <a href="home.php">Home</a>
            <a href="view_products.php">Products</a>
            <a href="order.php">Orders</a>
            <a href="about.php">About Us</a>
            <a href="contect.php">Contact Us</a>
        </nav>

        <!-- User and Cart Icons -->
        <div class="icons">
            <!-- User Icon -->
            <i class="bx bxs-user" id="user-btn"></i>

            <!-- Wishlist Icon with Count -->
            <?php 
                $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
                $count_wishlist_items->execute([$user_id]);
                $total_wishlist_items = $count_wishlist_items->rowCount(); 
            ?>
            <a href="wishlist.php" class="cart-btn"><i class="bx bx-heart"></i><sup><?=$total_wishlist_items ?></sup></a>

            <!-- Cart Icon with Count -->
            <?php 
                $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                $count_cart_items->execute([$user_id]);
                $total_cart_items = $count_cart_items->rowCount(); 
            ?>
            <a href="cart.php" class="cart-btn"><i class="bx bx-cart-download"></i><sup><?=$total_cart_items ?></sup></a>
            
            <!-- Menu Icon -->
            <i class="bx bx-list-plus" id="menu-btn" style="font-size: 2rem;"></i>
        </div>

        <!-- User Box: Display User Info if Logged In -->
        <div class="user-box">
            <?php if(isset($_SESSION['user_id'])): ?>
                <p>Username :<span><?= $_SESSION['user_name']; ?></span></p>
                <p>Email :<span><?= $_SESSION['user_email']; ?></span></p>
                <!-- Logout Button -->
                <form method="post">
                    <button type="submit" name="logout" class="logout-btn">Log Out</button>
                </form>
            <?php else: ?>
                <!-- Login and Register Links -->
                <a href="login.php" class="btn">Login</a>
                <a href="register.php" class="btn">Register</a>
            <?php endif; ?>
        </div>
    </div>
</header>
