<?php
// add_event.php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventName = $_POST['event_name'];
    $eventDate = $_POST['event_date'];
    $eventTime = $_POST['event_time'];
    $eventLocation = $_POST['event_location'];

    $stmt = $pdo->prepare("INSERT INTO events (event_name, event_date, event_time, event_location) VALUES (?, ?, ?, ?)");
    $stmt->execute([$eventName, $eventDate, $eventTime, $eventLocation]);

    header("Location: view_events.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Event</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
            transition: transform 0.2s;
            margin-top: 80px; /* Adjust for navbar height */
        }

        .container:hover {
            transform: scale(1.02);
        }

        h1 {
            color: maroon;
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="date"],
        input[type="time"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        input[type="time"]:focus {
            border-color: maroon;
            outline: none;
        }

        button {
            background-color: maroon;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #a70000;
        }

        a {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: maroon;
            transition: color 0.3s;
        }

        a:hover {
            color: #a70000;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: maroon;
            color: #fff;
            padding: 1rem;
            display: flex;
            justify-content: space-between; /* Ensures links align to the right */
            align-items: center;
        }

        .navbar .nav-links {
            display: flex; /* Make nav-links a flex container */
        }

        .navbar a {
            margin: 0 10px;
            color: #fff;
            text-decoration: none;
            transition: color 0.3s;
        }

        .navbar a:hover {
            color: #a70000;
        }

        .clearfix {
            clear: both;
        }
       
        @media(max-width: 768px) {
            .container {
                width: 90%;
            }
        }

        nav {
            background-color: #800000; /* Maroon */
            color: white;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        nav .brand {
            font-size: 25px;
            color: white;
            text-decoration: none;
            padding-left: 200px;
            padding-bottom: 20px;
        }

        nav .nav-links {
            display: flex;
            gap: 15px;
            padding-right: 200px;
        }

        nav .nav-links a {
            text-decoration: none;
            color: white;
            font-size: 1rem;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        nav .nav-links a:hover {
            color: #ffcc00; /* Gold color on hover */
        }
    </style>
</head>
<body>
<nav>
    <a href="../index.html" class="brand">Refresh</a>
    <div class="nav-links">
        <a href="../index.html">Home</a>
        <a href="about.php">About Us</a>
        <a href="contact.php">Contact Us</a>
    </div>
</nav>
    <br><br><br><br>
    
    <div class="container">
        <h1>Add New Event</h1>
        <form method="POST" action="">
            <input type="text" name="event_name" placeholder="Event Name" required><br>
            <input type="date" name="event_date" required><br>
            <input type="time" name="event_time" required><br>
            <input type="text" name="event_location" placeholder="Event Location" required><br>
            <button type="submit">Add Event</button>
        </form>
    </div>
</body>
</html>