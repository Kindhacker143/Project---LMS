<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Admission Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #f7f0f0, #fff5f5);
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #800000;
            margin: 20px 0;
            font-size: 2rem;
        }

        .form-container {
            max-width: 70%;
            margin: 30px auto;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            padding: 25px;
            animation: fadeIn 1s ease-in-out;
        }

        label {
            font-weight: 500;
            color: #800000;
        }

        input, textarea, select {
            border: 1px solid #d1d1d1;
            border-radius: 8px;
            padding: 10px;
            width: 100%;
            height: 45px;
            margin-bottom: 15px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        input:focus, textarea:focus, select:focus {
            border-color: #800000;
            box-shadow: 0 0 5px rgba(128, 0, 0, 0.5);
            outline: none;
        }

        button {
            background: #800000;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            height: 40px;
            width: 150px;
        }

        button:hover {
            background-color:rgb(100, 10, 10);
            transform: scale(1.05);
        }

        button:active {
            transform: scale(1);
        }

        .btn-secondary {
            padding-top: 9px;
            
            width: 150px;
            height: 40px;
            text-decoration: none;
            color: #fff;
            background-color: #800000;
            border-radius: 8px;
            display: inline-block;
            text-align: center;
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn-secondary:hover {
            background-color:rgb(83, 7, 7);
            transform: scale(1.05);
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            
        }

        .form-group {
            flex: 1 1 48%;
            height: 40px;
        }

        .full-width {
            flex: 1 1 100%;
        }
        nav {
            background: linear-gradient(90deg, #800000, #b30000); /* Gradient background */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            z-index: 100; /* Ensure navbar is above other elements */
            height: 70px;
        }

        nav .navbar-brand {
            font-size: 1.8rem; /* Increased size for the brand */
            color: #fff; /* White text color */
            font-weight: bold; /* Bolder text */
            transition: color 0.3s; /* Smooth color transition */
        }

        nav .navbar-brand:hover {
            color: #ffcc00; /* Change brand color on hover */
        }

        nav a {
            color: #f2f2f2; /* Light color for contrast */
            text-align: center;
            padding: 20px;
            text-decoration: none;
            transition: background-color 0.3s ease, color 0.3s ease;
            border-radius: 5px; /* Rounded corners for links */
        }

        nav a:hover {
            background-color: rgba(255, 255, 255, 0.2); /* Light background on hover */
            color: #ffcc00; /* Gold color for text on hover */
        }
    </style>
</head>
<body>
<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize a submitted variable
$submitted = false;

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $full_name = $_POST['full_name'];
    $name_with_initials = $_POST['name_with_initials'];
    $gender = $_POST['gender'];
    $dob  = $_POST['dob'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone= $_POST['phone'];
    $course = $_POST['course'];
    $year_of_admission = $_POST['year_of_admission'];
    $phone = $_POST['father_name'];
    $nationality= $_POST['nationality'];
    $course_fee = $_POST['course_fee'];
    

    
    // Handle Image Upload
    $target_dir = "uploads/"; // Ensure this directory exists and is writable
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true); // Create the directory if it doesn't exist
    }

    $image = $_FILES['image'];
    $image_name = basename($image['name']);
    $image_type = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
    $target_file = $target_dir . uniqid() . "." . $image_type;

    // Validate image file
    $upload_ok = true;
    $error_message = "";

    // Check if file is an actual image
    $check = getimagesize($image['tmp_name']);
    if ($check === false) {
        $upload_ok = false;
        $error_message = "File is not an image.";
    }

    // Check file size (limit to 2MB)
    if ($image['size'] > 2 * 1024 * 1024) {
        $upload_ok = false;
        $error_message = "File size exceeds 10MB.";
    }

    // Allow only specific file types
    $allowed_types = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($image_type, $allowed_types)) {
        $upload_ok = false;
        $error_message = "Only JPG, JPEG, PNG, and GIF files are allowed.";
    }

    // Check for upload errors
    if ($upload_ok && move_uploaded_file($image['tmp_name'], $target_file)) {
        // File uploaded successfully
    } else {
        $target_file = ""; // Set to empty if upload fails
        if (empty($error_message)) {
            $error_message = "File upload failed.";
        }
        echo "Error: " . $error_message;
        exit;
    }
    // Database connection
    $conn = new mysqli('localhost', 'root', 'root', 'rms');

    // Check connection
    if ($conn->connect_error) {
        die("<div class='error'>Connection failed: " . $conn->connect_error . "</div>");
    }

    // Using a prepared statement to prevent SQL injection
    $stmt = $conn->prepare ("INSERT INTO admission (full_name, name_with_initials, gender, dob, address, email, phone, course, year_of_admission, father_name, nationality, course_fee, image)
            VALUES ('$full_name', '$name_with_initials', '$gender', '$dob', '$address', '$email', '$phone', '$course', '$year_of_admission', '$father_name', '$nationality', '$course_fee', '$target_file'");
    $balance = $course_fee; // Assuming balance equals course fee
    $stmt->bind_param("ssdds", $name, $email, $phone, $course_fee, $balance);

    // Execute the statement and check if successful
    if ($stmt->execute()) {
        echo "<div class='message'>Student added successfully!</div>";
        $submitted = true; // Set submitted to true after successful insertion
    } else {
        echo "<div class='error'>Error: " . $stmt->error . "</div>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
<nav class="navbar navbar-expand-lg navbar-light shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="../index.html">Refresh</a>
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
<h1>Add Student</h1>
<div class="form-container">
    <form action="view_students.php" method="POST" enctype="multipart/form-data">
        <div class="form-row">
            <div class="form-group">
                <input type="text" id="full_name" name="full_name" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                
                <input type="text" id="name_with_initials" name="name_with_initials" placeholder="Enter name with initials" required>
            </div>
            <div class="form-group">
            
            <select id="gender" name="gender" required>
                <option value="" disabled selected>Select gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
        </div>

            <div class="form-group">
             
                <input type="date" id="dob" name="dob" required>
            </div>

            <div class="form-group full-width">
             
                <textarea id="address" name="address" rows="3" placeholder="Enter your address" required></textarea>
            </div>

            <div class="form-group">
           
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                
                <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
            </div>

            
            <div class="form-group">
              
                <input type="text" id="course" name="course" placeholder="Enter your course" required>
            </div>

            <div class="form-group">
               
                <input type="number" id="year_of_admission" name="year_of_admission" placeholder="Enter year of admission" required>
            </div>

            <div class="form-group">
               
               <input type="text" id="father_name" name="father_name" placeholder="Enter father's name" required>
           </div>

           <div class="form-group">
               
               <input type="text" id="nationality" name="nationality" placeholder="Enter your nationality" required>
           </div>

            <div class="form-group">
             
                <input type="number" id="course_fee" name="course_fee" placeholder="Enter course fee" required>
            </div>


            <div class="form-group full-width">
               
                <input type="file" id="image" name="image" accept="image/*">
            </div>
        </div>
<br>
        <div class="form-row">
            <button type="submit">Add Student</button>
            <a class="btn-secondary" href="view_students.php">View Students</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
