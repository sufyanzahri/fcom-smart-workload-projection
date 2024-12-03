<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "db_lwms";


// database connection
$conn = new mysqli($server, $username, $password, $database);

// check connection
if ($conn->connect_error) {
    die('Connection Failed : '. $conn->connect_error);
}
?>

