<?php
include 'components/connection.php';
session_start();
if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    }else{
        $user_id = '';
    }

    if (isset($_POST['logout'])) {
        session_destroy();
        header("location: login.php");
    }
?>
<style type="text/css">
    <?php include 'style.css'; ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>plant nursery- About Page</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>about us</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a><span>/ about</span>
        </div>
        <div class="about-category">
            
        </div>
        <section class="services">
            <div class="title">
                <img src="img4/logo.png" class="logo">
                <h1>why choose us</h1>
                <p>Live everyday with our indian traditional, By using Claymart products.</p>
            </div>
            <div class="box-container">
                <div class="box">
                    <img src="img/icon2.png">
                    <div class="detail">
                        <h1>Great savings</h1>
                        <p>save big every order</p>
                    </div>
                </div>
                <div class="box">
                    <img src="img/icon1.png">
                    <div class="detail">
                        <h1>24*7 support</h1>
                        <p>one-on-one support</p>
                    </div>
                </div>
                <div class="box">
                    <img src="img/icon0.png">
                    <div class="detail">
                        <h1>Gift vouchers</h1>
                        <p>save big every order</p>
                    </div>
                </div>
                <div class="box">
                    <img src="img/icon.png">
                    <div class="detail">
                        <h1>Worldwide delivery</h1>
                        <p>dropship Worldwide</p>
                    </div>
                </div>
            </div>
         </section>
         <div class="about">
            <div class="row">
                <div class="img">
                    <img src="img4/pn.jpg" width="500px">
                </div>
                <div class="detail">
                    <h1>visit our plant nursery</h1>
                    <p>A plant nursery is a facility that cultivates and grows plants for sale or transplantation, offering a wide variety of species including trees, shrubs, flowers, and vegetables. Nurseries can be wholesale, retail, or specialty-based, focusing on specific types like orchids or succulents. They employ various growing methods such as seed starting, cutting propagation, grafting, and tissue culture. To ensure optimal growth, nurseries provide controlled environments with adequate lighting, watering, fertilization, and pruning, while monitoring for pests and diseases. Many adopt sustainable practices like recycling, integrated pest management, and water conservation. By supporting local ecosystems and biodiversity, plant nurseries contribute to local economies, provide educational resources, and supply high-quality plants to gardeners, landscapers, and horticulture enthusiasts.</p>
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
            </div>
         </div>
        <div class="testimonial-container">
            <div class="title">
                <img src="img4/logo.png" class="logo">
                <h1>what people say about us</h1>
                <p>Customers appreciate our commitment to crafting not just functional items, 
                but beautiful works of art. it's clear that we have earned a reputation for 
                excellence and client satisfaction.</p>
            </div>
                <div class="container">
                   
                    <div class="testimonial-item">
                        <img src="img/03.jpg">
                        <h1>mayra saraf</h1>
                        <p>I enjoyed a range of bespoke services with RT Agro, including 
                        personalized agriculture items that perfectly match with my aesthetic vision. 
                       </p>
                    </div>
                    <div class="testimonial-item">
                        <img src="img/01.jpg">
                        <h1>samir</h1>
                        <p>I enjoyed a range of bespoke services with RT Agro, including 
                        personalized agriculture items that perfectly match with my aesthetic vision. 
                       </p>
                    </div>
                    
                </div>
        </div>
        <?php include 'components/footer.php'; ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>