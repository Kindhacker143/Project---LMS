<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $borrower_name = $_POST['borrower_name'];
    $borrowed_date = date('Y-m-d');

    // Use prepared statements to prevent SQL Injection
    $stmt = $conn->prepare("INSERT INTO books (title, author, borrower_name, borrowed_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $author, $borrower_name, $borrowed_date);

    if ($stmt->execute()) {
        // Redirect to view_records.php after successful insertion
        header('Location: view_records.php');
        exit; // Ensure script termination after redirect
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close(); // Close the prepared statement
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Get a Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Container styles */
        .container {
            max-width: 400px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .title {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .form {
            display: flex;
            flex-direction: column;
        }

        .input-field {
            width: 100%;
            height: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px; /* Adjust margin for spacing */
        }

        .submit-btn {
            background-color: #800000; /* maroon */
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #600000; /* darker maroon */
        }

        nav {
            background-color: #800000; /* Maroon */
            color: white;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            height: 65px;
        }

        /* Navigation styles */
        nav .brand {
            font-size: 25px;
            color: white;
            text-decoration: none;
            padding-left: 200px;
            padding-bottom: 5px;
        }

        nav .nav-links {
            display: flex;
            gap: 15px;
            padding-right: 200px;
            padding-bottom: 5px;
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

        @media(max-width: 768px) {
            .container {
                width: 90%;
            }

            nav .nav-links {
                flex-direction: column;
                gap: 10px;
            }
        }
        .submit-btn {
            height: 40px;
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
    <h1 class="title">Get a Book</h1>
    <form class="form" method="POST" action="">
        <label for="title">Book Title:</label>
        <input type="text" name="title" required class="input-field" placeholder="Enter book title..."><br><br>
        
        <label for="author">Author:</label>
        <input type="text" name="author" required class="input-field" placeholder="Enter author's name..."><br><br>
        
        <label for="borrower_name">Borrower's Name:</label>
        <input type="text" name="borrower_name" required class="input-field" placeholder="Enter your name..."><br><br>
        
        <button type="submit" class="submit-btn">Borrow Book</button>
    </form>
</div>
</body>
</html>