<?php
$host = 'localhost';
$db_user = 'root'; // Your database username
$db_pass = 'root';     // Your database password
$db_name = 'rms';

$conn = mysqli_connect($host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>