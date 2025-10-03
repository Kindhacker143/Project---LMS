<?php
require_once 'config.php';

// Fetch student data based on the student ID from the database
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];
    
    // Query to get student details from the database
    $query = "SELECT * FROM admission WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        // Handle case if student is not found
        echo "Student not found.";
        exit;
    }
    
    $stmt->close();
} else {
    echo "Student ID is missing.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get student data from form
    $student_id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $name_with_initials = $_POST['name_with_initials'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $course = $_POST['course'];
    $year_of_admission = $_POST['year_of_admission'];
    $father_name = $_POST['father_name'];
    $nationality = $_POST['nationality'];
    $course_fee = $_POST['course_fee'];

    // Image Upload Logic (Optional)
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);

        // Move the uploaded file to the server directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // If image upload is successful, include the image path in the update
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        $image = $student['image'];  // Keep the existing image if no new image is uploaded
    }

    // Update student data in the database
    $query = "UPDATE admission SET 
                full_name = ?, 
                name_with_initials = ?, 
                gender = ?, 
                dob = ?, 
                address = ?, 
                email = ?, 
                phone = ?, 
                course = ?, 
                year_of_admission = ?, 
                father_name = ?, 
                nationality = ?, 
                course_fee = ?,
                image = ? 
              WHERE id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssssssssssi", $full_name, $name_with_initials, $gender, $dob, $address, $email, $phone, $course, $year_of_admission, $father_name, $nationality, $course_fee, $image, $student_id);

    if ($stmt->execute()) {
        echo "Student details updated successfully.";
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Your original CSS here */
    </style>
</head>
<body>
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

<h1>Edit Student</h1>
<div class="form-container">
    <form action="edit_student.php?id=<?php echo $student['id']; ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
        <div class="form-row">
            <div class="form-group">
                <input type="text" id="full_name" name="full_name" placeholder="Enter your full name" value="<?php echo $student['full_name']; ?>" required>
            </div>

            <div class="form-group">
                <input type="text" id="name_with_initials" name="name_with_initials" placeholder="Enter name with initials" value="<?php echo $student['name_with_initials']; ?>" required>
            </div>
            <div class="form-group">
                <select id="gender" name="gender" required>
                    <option value="" disabled>Select gender</option>
                    <option value="male" <?php echo ($student['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                    <option value="female" <?php echo ($student['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
                    <option value="other" <?php echo ($student['gender'] == 'other') ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>

            <div class="form-group">
                <input type="date" id="dob" name="dob" value="<?php echo $student['dob']; ?>" required>
            </div>

            <div class="form-group full-width">
                <textarea id="address" name="address" rows="3" placeholder="Enter your address" required><?php echo $student['address']; ?></textarea>
            </div>

            <div class="form-group">
                <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo $student['email']; ?>" required>
            </div>

            <div class="form-group">
                <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" value="<?php echo $student['phone']; ?>" required>
            </div>

            <div class="form-group">
                <input type="text" id="course" name="course" placeholder="Enter your course" value="<?php echo $student['course']; ?>" required>
            </div>

            <div class="form-group">
                <input type="number" id="year_of_admission" name="year_of_admission" placeholder="Enter year of admission" value="<?php echo $student['year_of_admission']; ?>" required>
            </div>

            <div class="form-group">
                <input type="text" id="father_name" name="father_name" placeholder="Enter father's name" value="<?php echo $student['father_name']; ?>" required>
            </div>

            <div class="form-group">
                <input type="text" id="nationality" name="nationality" placeholder="Enter your nationality" value="<?php echo $student['nationality']; ?>" required>
            </div>

            <div class="form-group">
                <input type="number" id="course_fee" name="course_fee" placeholder="Enter course fee" value="<?php echo $student['course_fee']; ?>" required>
            </div>

            <div class="form-group full-width">
                <input type="file" id="image" name="image" accept="image/*">
                <small>Current Image: <?php echo $student['image']; ?></small>
            </div>
        </div>
        <br>
        <div class="form-row">
            <button type="submit">Update Student</button>
            <a class="btn-secondary" href="view_students.php">View Students</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
