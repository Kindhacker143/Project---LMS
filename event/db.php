<?php
// db.php
$host = 'localhost';
$db = 'rms';
$user = 'root'; // Use your database username
$pass = 'root'; // Use your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>