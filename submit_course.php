<?php
$servername = "localhost"; // Change if different
$username = "root"; // Change if different
$password = "root"; // Change if different
$dbname = "course_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$course_name = $_POST['course_name'];
$course_duration = $_POST['course_duration'];
$course_fee = $_POST['course_fee'];
$subjects = implode(", ", $_POST['subjects']); // Combine subjects into a string

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO courses (course_name, course_duration, course_fee, subjects) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssds", $course_name, $course_duration, $course_fee, $subjects);

// Execute the statement
if ($stmt->execute()) {
    echo "New course added successfully!";
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>
<a href="add_course.php">Add Another Course</a>
<a href="view_courses.php">View Courses</a>