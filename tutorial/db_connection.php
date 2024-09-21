<?php
// Database connection parameters
$servername = "localhost";  
$username = "root";         
$password = "";             
$dbname = "tutorialbase";  //Ito lang papalitan mo

$conn = mysqli_connect($servername, $username, $password, $dbname);
//There are two types of checking $conn
//The standard way is $conn->connect_error
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
?>
