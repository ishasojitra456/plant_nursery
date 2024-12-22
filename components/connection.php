<?php
$servername = "localhost";  // Database server
$username = "root";         // Database username
$password = "";             // Database password
$dbname = "plant_store";  // Database name

try {
    // Creating a connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit; // Stop script execution if there is a connection error
}
?>

<?php
    if(isset($success_msg)){
        foreach($success_msg as $success_msg){
        echo '<script>swal("'.$warning_msg.'", "", "success");</script>';
        }
    }
    if (isset($warning_msg)){
        foreach($warning_msg as $warning_msg){
        echo'<script>swal("'.$warning_msg.'","","success");</script>';
        }
    }
    if(isset($info_msg)){
        foreach($info_msg as $info_msg){
        echo'<script>swal("'.$info_msg.'","","success");</script>';
        }
    }
    if(isset($error_msg)){
        foreach($error_msg as $error_msg){
            echo'<script>swal("'.$error_msg.'","","success");</script>';
           }
    }


?>