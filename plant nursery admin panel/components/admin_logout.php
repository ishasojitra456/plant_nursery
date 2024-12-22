<?php
    include 'connection.php';

    session_start(); // Correct function name
    session_unset();
    session_destroy();
    header('location: ../admin/login.php');
    exit();
?>
