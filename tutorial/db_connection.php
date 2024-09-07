<?php
// Database connection parameters
$servername = "localhost";  
$username = "root";         
$password = "";             
$dbname = "tutorialbase";  //Ito lang papalitan mo

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
?>