<?php
include 'db.php'; // Include your database connection file

// Fetch exams for dropdown
$stmt = $pdo->query("SELECT * FROM exams ORDER BY exam_name");
$exams = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $exam_id = $_POST['exam_id'];
    $student_name = $_POST['student_name'];
    $score = $_POST['score'];

    $stmt = $pdo->prepare("INSERT INTO results (exam_id, student_name, score) VALUES (:exam_id, :student_name, :score)");
    $stmt->bindParam(':exam_id', $exam_id);
    $stmt->bindParam(':student_name', $student_name);
    $stmt->bindParam(':score', $score);

    if ($stmt->execute()) {
        // Redirect to the view results page upon success
        header('Location: view_results.php');
        exit(); // Important to stop the script after redirection
    } else {
        echo "<div class='alert alert-danger' role='alert'>Failed to add result.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Result</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: maroon;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            animation: fadeIn 1s ease-in;
        }
        .form-control {
            transition: border-color 0.3s;
        }
        .form-control:focus {
            border-color: maroon;
            box-shadow: 0 0 5px rgba(128, 0, 0, 0.5);
        }
        .btn-primary {
            background-color: maroon;
            border-color: maroon;
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn-primary:hover {
            background-color: #8B0000; /* Darker maroon on hover */
            border: #800000;
            transform: scale(1.05);
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
    <br><br><br>
    <div class="container">
        <h1>Add New Result</h1>
        <form method="POST">
    <div class="form-group">
        <label for="exam_id">Exam Name:</label>
        <select class="form-control" id="exam_id" name="exam_id" required>
            <option value="">Select an Exam</option>
            <?php foreach ($exams as $exam): ?>
                <option value="<?php echo htmlspecialchars($exam['exam_id']); ?>">
                    <?php echo htmlspecialchars($exam['exam_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="student_name">Student Name:</label>
        <input type="text" class="form-control" id="student_name" name="student_name" placeholder="Enter Student Name" required>
    </div>
    <div class="form-group">
        <label for="score">Score:</label>
        <input type="number" class="form-control" id="score" name="score" placeholder="Enter Score (0-100)" min="0" max="100" step="0.01" required>
    </div>
    <button type="submit" class="btn btn-primary btn-block">Add Result</button>
</form>
    </div>
</body>
</html>