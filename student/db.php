<?php
$server = "localhost";
$username = "root";  // Change if you have a different DB user
$password = "root";      // Change if your MySQL has a password
$database = "rms";

$conn = mysqli_connect($server, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>