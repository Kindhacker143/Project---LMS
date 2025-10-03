<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            color: #333;
            margin: 0;
            padding: 0;
        }

        nav {
            background-color: #800000; /* Maroon */
            color: white;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            height: 40px;
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
            padding-bottom: 20px;
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

        h1 {
            text-align: center;
            color: #800000; /* Maroon */
            margin: 20px 0;
        }

        .container {
            width: 60%;
            margin: 20px auto;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .container:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #800000; /* Maroon */
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s ease;
            font-size: 15px;
        }

        input[type="text"]:focus,
        textarea:focus {
            border-color: #800000; /* Maroon */
            outline: none;
        }

        input[type="submit"] {
            background-color: #800000; /* Maroon */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #a00; /* Lighter Maroon */
            transform: translateY(-2px);
        }

        a {
            display: inline-block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #800000; /* Maroon */
            font-size: 16px;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
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
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav>
        <a href="../index.html" class="brand">Refresh</a>
        <div class="nav-links">
            <a href="../index.html">Home</a>
            <a href="about.php">About Us</a>
            <a href="contact.php">Contact Us</a>
        </div>
    </nav>

    <br>
    <h1>Library Management System</h1>
    <br>
    <div class="container">
        <form action="insert.php" method="POST">
            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name" placeholder="Enter your full name" required>

            <label for="course_name">Course Name:</label>
            <input type="text" id="course_name" name="course_name" placeholder="Enter your course name" required>

            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" placeholder="Enter your phone number" required>

            <label for="address">Address:</label>
            <textarea id="address" name="address" placeholder="Enter your address" required></textarea>

            <label for="book_name">Book Name:</label>
            <input type="text" id="book_name" name="book_name" placeholder="Enter the name of the book" required>

            <label for="book_author">Book Author:</label>
            <input type="text" id="book_author" name="book_author" placeholder="Enter the author's name" required>

            <input type="submit" value="Submit">
        </form>
        <center><a href="view.php">View Records</a></center>
    </div>
</body>
</html>
