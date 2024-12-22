<?php
include 'components/connection.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Adjust the path if necessary

if (isset($_POST['reset_password'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $query = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $query->execute([$email]);

    if ($query->rowCount() > 0) {
        // Generate a new password
        $new_password = bin2hex(random_bytes(4)); // Generates a random 8-character password
        $hashed_password = sha1($new_password);

        // Update the database
        $update = $conn->prepare("UPDATE `users` SET password = ? WHERE email = ?");
        $update->execute([$hashed_password, $email]);

        // Send an email with the new password using PHPMailer
        $mail = new PHPMailer(true);
        try {
            // SMTP settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Use your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'your_email@gmail.com'; // Your email
            $mail->Password = 'your_password'; // Your password or App password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('your_email@gmail.com', 'RURAL TOUCH AGRO');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your New Password';
            $mail->Body = "Your new password is: <b>$new_password</b>";

            $mail->send();
            $success_msg = "A new password has been sent to your email.";
        } catch (Exception $e) {
            $error_msg = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $error_msg = "Email not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="main-container">
        <section class="form-container">
            <h1>Reset Your Password</h1>
            <form action="" method="post">
                <div class="input-field">
                    <p>Your Email <sup>*</sup></p>
                    <input type="email" name="email" required placeholder="Enter your email">
                </div>
                <input type="submit" name="reset_password" value="Reset Password" class="btn">
            </form>
            <?php if (isset($success_msg)) echo "<p>$success_msg</p>"; ?>
            <?php if (isset($error_msg)) echo "<p>$error_msg</p>"; ?>
        </section>
    </div>
</body>
</html>
