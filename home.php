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
    <title>plant nursery - Home Page</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        
        <section class="home-section">
        <div class="slider">
            <div class="slider_slider slide1">
                <div class="overlay"></div>
                <div class="slide-detail">
                    <h1>welcome to shop</h1>
                    <p>Live everyday with our indian traditional, By using Rural Touch seed products.</p>
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
                <div class="hero-dec-top"></div>
                <div class="hero-dec-bottom"></div>
            </div>
            <!-- slide end -->
            <div class="slider_slider slide2">
                <div class="overlay"></div>
                <div class="slide-detail">
                    <h1>welcome to shop</h1>
                    <p>Live everyday with our indian traditional, By using Rural Touch reen vegetable products.</p>
                    <a href="view_products.php" class="btn" >shop now</a>
                </div>
                <div class="hero-dec-top"></div>
                <div class="hero-dec-bottom"></div>
            </div>
            <!-- slide end -->
            <div class="slider_slider slide3">
                <div class="overlay"></div>
                <div class="slide-detail">
                    <h1>welcome to shop</h1>
                    <p>Live everyday with our indian traditional, By using Rural Touch fruit products.</p>
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
                <div class="hero-dec-top"></div>
                <div class="hero-dec-bottom"></div>
            </div>
            <div class="slider_slider slide4">
                <div class="overlay"></div>
                <div class="slide-detail">
                    <h1>welcome to shop</h1>
                    <p>Live everyday with our indian traditional, By using Rural Touch Nuts products.</p>
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
                <div class="hero-dec-top"></div>
                <div class="hero-dec-bottom"></div>
            </div>
            <!-- slide end -->
            <div class="slider_slider slide5">
                <div class="overlay"></div>
                <div class="slide-detail">
                    <h1>welcome to shop</h1>
                    <p>Live everyday with our indian traditional, By using eqvipment products.</p>
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
                <div class="hero-dec-top"></div>
                <div class="hero-dec-bottom"></div>
            </div>
            <!-- slide end -->
            <div class="left-arrow"><i class="bx bxs-left-arrow"></i></div>
            <div class="right-arrow"><i class="bx bxs-right-arrow"></i></div>
        </div>
        </section>
        <!-- home slider end -->
         <section>
            <!--<div class="thumb">
                <div class="box-container">
                    <div class="box">
                        <img src="img4/inside.png" width="200px" height="200px">
                        <h3>indoor plants</h3>
                        <p>Indoor plants are a popular choice for adding greenery and a touch of nature to interior spaces</p>
                        
                    </div>
                    <div class="box">
                        <img src="img2/thumb1.jpg" width="200px" height="200px">
                        <h3>Green vegetable</h3>
                        <p>A flower pot is a container in which flowers and other plants are grown.</p>
                        
                    </div>
                    <div class="box">
                        <img src="img2/thumb.jpg" width="200px" height="200px">
                        <h3>fruit</h3>
                        <p>A natural detoxification process ensures that stored water is clean,safe for drink.</p>
                        
                    </div>
                    <div class="box">
                        <img src="img2/thumb2.jpg" width="200px" height="200px">
                        <h3>Potatos</h3>
                        <p>Vases come in different sizes to support flowers, holding & keeping in place. </p>
                        
                    </div>
                </div>
</div>-->
         </section>
         <section class="shop">
            <div class="title">
                <img src="img4/logo.png" width="100px" height="100px">
                <h1>Trending products</h1>
            </div>
            <div class="row">
                
            </div>
            <div class="box-container">
                <div class="box">
                    <img src="img4/i2.jpg " width="600px" height="400px">
                    <a href="view_products.php" class="btn">inside plant</a>
                </div>
                <div class="box">
                    <img src="img4/cycas.jpg" width="600px" height="400px">
                    <a href="view_products.php" class="btn">outside plant</a>
                </div>
                <div class="box">
                    <img src="img4/seed.jpeg" width="600px" height="400px">
                    <a href="view_products.php" class="btn">plant seeds</a>
                </div>
              <!--  <div class="box">
                    <img src="img2/n2.jpeg" width="600px" height="400px">
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
                <div class="box">
                    <img src="img2/v.jpeg" width="600px" height="400px">
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
                <div class="box">
                    <img src="img2/v2.jpeg" width="600px" height="400px">
                    <a href="view_products.php" class="btn">shop now</a>
                </div>-->
            </div>
         </section>
         <section class="container">
            <div class="box-container">
                <div class="box">
                    <img src="img4/pc1.jpg" width="490px">
                </div>
                <div class="box">
                    <img src="img4/logo.png"width="100px" height="100px">
                    <span>Unity of Indian Cultures</span>
                    <h1>save up to 50% off</h1>
                    <p>agriculture is the Art of balance,Harmony and Sutainability</p>
                </div>
            </div>
         </section>


         <section class="services">
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
        <?php include 'components/footer.php'; ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>