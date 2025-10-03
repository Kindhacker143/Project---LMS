<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch student details by ID
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $full_name = $_POST['full_name'];
    $name_with_initial = $_POST['name_with_initial'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $course = $_POST['course'];
    $year_of_admission = intval($_POST['year_of_admission']);
    $father_name = $_POST['father_name'];
    $nationality = $_POST['nationality'];
    $course_fee = floatval($_POST['course_fee']);
    $balance = floatval($_POST['balance']);  // New balance field

    // Handle image update if provided
    if (!empty($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];
        $image_data = file_get_contents($_FILES['image']['tmp_name']);
        
        // Prepared statement for image update (14 placeholders)
        $stmt = $conn->prepare("UPDATE students 
                                SET full_name=?, name_with_initial=?, gender=?, dob=?, address=?, email=?, phone=?, course=?, 
                                    year_of_admission=?, father_name=?, nationality=?, course_fee=?, balance=?, image_name=?, image_data=? 
                                WHERE id=?");
        $stmt->bind_param(
            "ssssssssissdsssi", // 14 placeholders for balance added
            $full_name, $name_with_initial, $gender, $dob, $address, $email, $phone, $course, 
            $year_of_admission, $father_name, $nationality, $course_fee, $balance, $image_name, $image_data, $id
        );
    } else {
        // Prepared statement when no image is updated (13 placeholders)
        $stmt = $conn->prepare("UPDATE students 
                                SET full_name=?, name_with_initial=?, gender=?, dob=?, address=?, email=?, phone=?, course=?, 
                                    year_of_admission=?, father_name=?, nationality=?, course_fee=?, balance=? 
                                WHERE id=?");
        $stmt->bind_param(
            "ssssssssissdsi", // 13 placeholders when image is not updated
            $full_name, $name_with_initial, $gender, $dob, $address, $email, $phone, $course, 
            $year_of_admission, $father_name, $nationality, $course_fee, $balance, $id
        );
    }

    // Execute the statement
    $stmt->execute();
    header("Location: view_students.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/edit.css">
</head>
<body>  
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
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

<div class="container mt-4">
    <h1 class="text-center">Edit Student</h1>
    <form action="edit_student.php" method="POST" enctype="multipart/form-data" class="mt-4">
        <input type="hidden" name="id" value="<?= htmlspecialchars($student['id']) ?>">
        <div class="row mb-3">
            <div class="col-md-6"><input type="text" class="form-control" name="full_name" value="<?= htmlspecialchars($student['full_name']) ?>" required></div>
            <div class="col-md-6"><input type="text" class="form-control" name="name_with_initial" value="<?= htmlspecialchars($student['name_with_initial']) ?>" required></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <select class="form-control" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="Male" <?= $student['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
                    <option value="Female" <?= $student['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
                </select>
            </div>
            <div class="col-md-6"><input type="date" class="form-control" name="dob" value="<?= htmlspecialchars($student['dob']) ?>" required></div>
        </div>
        <div class="mb-3"><textarea class="form-control" name="address" rows="2" required><?= htmlspecialchars($student['address']) ?></textarea></div>
        <div class="row mb-3">
            <div class="col-md-6"><input type="email" class="form-control" name="email" value="<?= htmlspecialchars($student['email']) ?>" required></div>
            <div class="col-md-6"><input type="text" class="form-control" name="phone" value="<?= htmlspecialchars($student['phone']) ?>" required></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6"><input type="text" class="form-control" name="course" value="<?= htmlspecialchars($student['course']) ?>" required></div>
            <div class="col-md-6"><input type="number" class="form-control" name="year_of_admission" value="<?= htmlspecialchars($student['year_of_admission']) ?>" required></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6"><input type="text" class="form-control" name="father_name" value="<?= htmlspecialchars($student['father_name']) ?>" required></div>
            <div class="col-md-6"><input type="text" class="form-control" name="nationality" value="<?= htmlspecialchars($student['nationality']) ?>" required></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6"><input type="number" class="form-control" name="course_fee" value="<?= htmlspecialchars($student['course_fee']) ?>" step="0.01" placeholder="Course Fee" required></div>
        </div>
        <!-- Balance field -->
        <!--  <div class="row mb-3">
                <div class="col-md-6"><input type="number" class="form-control" name="balance" value="<?= htmlspecialchars($student['balance']) ?>" step="0.01" placeholder="Balance" required></div>
        </div>-->
        <div class="mb-3">
            <label>Current Image:</label><br>
            <img src="data:image/jpeg;base64,<?= base64_encode($student['image_data']) ?>" alt="Image" width="100"><br><br>
            <input type="file" class="form-control" name="image" accept="image/*">
        </div>
        <button type="submit" class="btn btn-success">Update Student</button>
        <a href="view_students.php" class="btn btn-secondary">Cancel</a>
    </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
