<?php
// Database connection
$conn = new mysqli('localhost', 'root', 'root', 'student_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_name = $_POST['course_name'];
    $course_duration = $_POST['course_duration'];
    $course_fee = floatval($_POST['course_fee']);
    $subjects = $_POST['subjects']; // Array of subjects

    // Insert course details
    $stmt = $conn->prepare("INSERT INTO courses (course_name, course_duration, course_fee) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $course_name, $course_duration, $course_fee);
    $stmt->execute();
    $course_id = $stmt->insert_id;

    // Insert subjects
    $subject_stmt = $conn->prepare("INSERT INTO course_subjects (course_id, subject_name) VALUES (?, ?)");
    foreach ($subjects as $subject) {
        $subject_stmt->bind_param("is", $course_id, $subject);
        $subject_stmt->execute();
    }

    echo "<div class='alert alert-success'>Course and subjects added successfully!</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f0f0;
            font-family: Arial, sans-serif;
            padding-top: 56px; /* Adjust padding-top to not hide content behind fixed navbar */
        }
        .navbar {
            background-color: #800000; /* Maroon */
        }
        .navbar-brand, .nav-link {
            color: #fff !important;
            transition: color 0.3s ease;
        }
        .nav-link:hover {
            color: #ffe6e6 !important; /* Light Maroon */
        }
        .form-control {
            border: 1px solid #800000; /* Maroon Border */
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-control:focus {
            border-color: #b30000; /* Darker Maroon on focus */
            box-shadow: 0 0 0 0.2rem rgba(179, 0, 0, 0.25);
            outline: none; /* Remove default outline */
        }
        .btn-secondary {
            background-color: #800000; /* Maroon */
            border-color: #800000; /* Maroon */
            position: relative;
            overflow: hidden;
            transition: background-color 0.3s ease;
        }
        .btn-secondary:hover {
            background-color: #b30000; /* Darker Maroon */
            border-color: #b30000;
        }
        .animated-button {
            padding: 10px 20px;
            background-color: #800000; 
            color: white; 
            border-radius: 5px; 
            cursor: pointer; 
            position: relative; 
            overflow: hidden; 
            transition: background-color 0.4s; 
        }
        .animated-button::after {
            content: "";
            position: absolute; 
            left: 50%; 
            top: 50%; 
            width: 300%; 
            height: 300%; 
            background: rgba(255, 255, 255, 0.2); 
            border-radius: 50%; 
            transition: all 0.6s; 
            transform: translate(-50%, -50%) scale(0); 
            z-index: 0; 
        }
        .animated-button:hover::after {
            transform: translate(-50%, -50%) scale(1); 
        }
        .animated-button span {
            position: relative; 
            z-index: 1; 
        }
        .subject-container {
            transition: transform 0.3s;
        }
    </style>
</head>
<body class="container mt-5">
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Refresh</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav> 

    <h1 class="text-center mb-4">Add Courses</h1>

    <!-- Form to Add Course -->
    <form method="POST" action="add_courses.php" class="p-4 border rounded bg-light shadow-sm">
        <div class="mb-3">
            <label for="course_name" class="form-label">Course Name:</label>
            <input type="text" class="form-control" id="course_name" name="course_name" placeholder="Enter Course Name" required>
        </div>
        <div class="mb-3">
            <label for="course_duration" class="form-label">Course Duration:</label>
            <input type="text" class="form-control" id="course_duration" name="course_duration" placeholder="Enter Course Duration (e.g., 3 years)" required>
        </div>
        <div class="mb-3">
            <label for="course_fee" class="form-label">Course Fee:</label>
            <input type="number" step="0.01" class="form-control" id="course_fee" name="course_fee" placeholder="Enter Course Fee" required>
        </div>
        <div class="mb-3">
            <label for="subjects" class="form-label">Subjects:</label>
            <div id="subject-container">
                <input type="text" class="form-control mb-2" name="subjects[]" placeholder="Enter Subject Name" required>
            </div>
            <button type="button" id="add-subject" class="btn btn-secondary">Add Another Subject</button>
        </div>
        <button type="submit" class="btn animated-button w-100"><span>Add Course</span></button>
    </form>

    <script>
        document.getElementById('add-subject').addEventListener('click', () => {
            const container = document.getElementById('subject-container');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'subjects[]';
            input.placeholder = 'Enter Subject Name';
            input.className = 'form-control mb-2 subject-container';
            container.appendChild(input);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>