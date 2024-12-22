<?php
include 'components/connection.php';
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// Handle form submission for leaving a message
if (isset($_POST['submit-btn'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

    // Insert the message into the database
    $insert_message = $conn->prepare("INSERT INTO message (name, email, message) VALUES (?, ?, ?)");
    $insert_message->execute([$name, $email, $message]);

    // Provide feedback to the user
    echo "<script>swal('Success!', 'Your message has been sent.', 'success');</script>";
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
    <title>plant nursery- Contact Page</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Contact Us</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a><span>/ Contact Us</span>
        </div>
        <section class="services">
            <div class="form-container">
                <form method="post">
                    <div class="title">
                        <img src="img4/logo.png" class="logo">
                        <h1>Leave a Message</h1>
                    </div>
                    <div class="input-field">
                        <p>Your Name <sup>*</sup></p>
                        <input type="text" name="name" required>
                    </div>
                    <div class="input-field">
                        <p>Your Email <sup>*</sup></p>
                        <input type="email" name="email" required>
                    </div>
                    
                    <div class="input-field">
                        <p>Your Message <sup>*</sup></p>
                        <textarea name="message" required></textarea>
                    </div>
                    <button type="submit" name="submit-btn" class="btn">Send Message</button>
                </form>
            </div>
        </section>
        <div class="address">
            <div class="title">
                <img src="img4/logo.png" class="logo">
                <h1>Contact Details</h1>
                <p>Live every day with our Indian tradition, by using Claymart Products.</p>
            </div>
            <div class="box-container">
                <div class="box">
                    <i class="bx bxs-map-pin"></i>
                    <div>
                        <h4>Address</h4>
                        <p>1092 Yogichok Road, Surat</p>
                    </div>
                </div>
                <div class="box">
                    <i class="bx bxs-phone-call"></i>
                    <div>
                        <h4>Phone Number</h4>
                        <p>9862484927</p>
                    </div>
                </div>
                <div class="box">
                    <i class="bx bxs-envelope"></i>
                    <div>
                        <h4>Email</h4>
                        <p>yukta123@gmail.com</p>
                    </div>
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
