<?php
include 'db.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $exam_id = $_POST['exam_id'];
    $student_name = $_POST['student_name'];
    $exam_name = $_POST['exam_name'];
    $exam_date = $_POST['exam_date'];
    $exam_time = $_POST['exam_time'];
    $exam_location = $_POST['exam_location'];

    $stmt = $pdo->prepare("INSERT INTO exams (exam_id, student_name, exam_name, exam_date, exam_time, exam_location) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$exam_id, $student_name, $exam_name, $exam_date, $exam_time, $exam_location]);

    echo "<script>alert('Exam added successfully!'); window.location.href='view_exams.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Exam</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            animation: fadeIn 1s ease-in;
        }
        .container {
            margin-top: 50px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        h1 {
            color: maroon;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }
        .form-control {
            border-radius: 5px;
            transition: border-color 0.3s;
        }
        .form-control:focus {
            border-color: maroon;
            box-shadow: 0 0 5px maroon;
        }
        .btn-primary {
            background-color: maroon;
            border-color: maroon;
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn-primary:hover {
            background-color: #8B0000; /* Darker maroon on hover */
            transform: scale(1.05);
        }
        .alert {
            margin-top: 20px;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
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
        
        nav {
            background-color: #800000; /* Maroon */
            color: white;
            padding: 10px 20px;
            padding-top: 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            height: 80px;
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

    <div class="container">
        <h1>Add New Exam</h1>

        <form method="POST" action="">
    <div class="form-group">
        <label for="exam_id">Exam ID:</label>
        <input type="text" class="form-control" id="exam_id" name="exam_id" placeholder="Enter Exam ID" required>
    </div>
    <div class="form-group">
        <label for="student_name">Student Name:</label>
        <input type="text" class="form-control" id="student_name" name="student_name" placeholder="Enter Student Name" required>
    </div>
    <div class="form-group">
        <label for="exam_name">Exam Name:</label>
        <input type="text" class="form-control" id="exam_name" name="exam_name" placeholder="Enter Exam Name" required>
    </div>
    <div class="form-group">
        <label for="exam_date">Exam Date:</label>
        <input type="date" class="form-control" id="exam_date" name="exam_date" required>
    </div>
    <div class="form-group">
        <label for="exam_time">Exam Time:</label>
        <input type="time" class="form-control" id="exam_time" name="exam_time" required>
    </div>
    <div class="form-group">
        <label for="exam_location">Exam Location:</label>
        <input type="text" class="form-control" id="exam_location" name="exam_location" placeholder="Enter Exam Location" required>
    </div>
    <button type="submit" class="btn btn-primary btn-block">Add Exam</button>
</form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>