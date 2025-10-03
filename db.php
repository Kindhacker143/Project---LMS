<?php
// db.php
$servername = "localhost"; // or your database server name
$username = "root"; // your database username
$password = "root"; // your database password
$dbname = "rms"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>