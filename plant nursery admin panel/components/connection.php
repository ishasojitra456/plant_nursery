<?php
   $servername = "localhost";  // Database server
   $username = "root";         // Database username
   $password = "";             // Database password
   $dbname = "plant_store";        // Database name
   
   // Correct DSN string
   $dsn = "mysql:host=$servername;dbname=$dbname";

   try {
       // Initialize PDO with correct arguments
       $conn = new PDO($dsn, $username, $password);

       // Set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       
   } catch (PDOException $e) {
       echo "Connection failed: " . $e->getMessage();
   }

   function unique_id(){
       $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
       $charLength = strlen($chars);
       $randomString = '';

       for ($i=0; $i < 20; $i++){
           $randomString .= $chars[mt_rand(0, $charLength - 1)];
       }
       return $randomString;
   }
?>
