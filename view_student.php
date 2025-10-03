<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "root";
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
} else {
    die("Invalid request.");
}

// Handle delete action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_student'])) {
    $id = intval($_POST['id']);
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: view_students.php?message=Student Deleted Successfully");
    exit;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/view1.css">
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
    <h1 class="text-center">Student Details</h1>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td><?= htmlspecialchars($student['id']) ?></td>
        </tr>
        <tr>
            <th>Full Name</th>
            <td><?= htmlspecialchars($student['full_name']) ?></td>
        </tr>
        <tr>
            <th>Name with Initial</th>
            <td><?= htmlspecialchars($student['name_with_initial']) ?></td>
        </tr>
        <tr>
            <th>Gender</th>
            <td><?= htmlspecialchars($student['gender']) ?></td>
        </tr>
        <tr>
            <th>Date of Birth</th>
            <td><?= htmlspecialchars($student['dob']) ?></td>
        </tr>
        <tr>
            <th>Address</th>
            <td><?= htmlspecialchars($student['address']) ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= htmlspecialchars($student['email']) ?></td>
        </tr>
        <tr>
            <th>Phone</th>
            <td><?= htmlspecialchars($student['phone']) ?></td>
        </tr>
        <tr>
            <th>Course</th>
            <td><?= htmlspecialchars($student['course']) ?></td>
        </tr>
        <tr>
            <th>Year of Admission</th>
            <td><?= htmlspecialchars($student['year_of_admission']) ?></td>
        </tr>
        <tr>
            <th>Father's Name</th>
            <td><?= htmlspecialchars($student['father_name']) ?></td>
        </tr>
        <tr>
            <th>Nationality</th>
            <td><?= htmlspecialchars($student['nationality']) ?></td>
        </tr>
        <tr>
            <th>Course Fee</th>
            <td><?= htmlspecialchars($student['course_fee']) ?></td>
        </tr>
        <tr>
            <th>Image</th>
            <td>
                <img src="data:image/jpeg;base64,<?= base64_encode($student['image_data']) ?>" 
                     alt="Student Image" 
                     width="150" 
                     style="cursor: pointer;" 
                     onclick="showFullscreen(this)">
            </td>
        </tr>
    </table>
    <div class="d-flex justify-content-between">
        <a href="edit_student.php?id=<?= $student['id'] ?>" class="btn btn-secondary">Edit</a>
        <form action="view_student.php?id=<?= $student['id'] ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this student?');">
            <input type="hidden" name="id" value="<?= $student['id'] ?>">
            <button type="submit" name="delete_student" class="btn btn-secondary">Delete</button>
        </form>
        <a href="view_students.php" class="btn btn-secondary">Back to Students List</a>
    </div>
    </div>

    <script>
        function showFullscreen(imgElement) {
            const overlay = document.createElement('div');
            overlay.style.position = 'fixed';
            overlay.style.top = '0';
            overlay.style.left = '0';
            overlay.style.width = '100%';
            overlay.style.height = '100%';
            overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
            overlay.style.display = 'flex';
            overlay.style.alignItems = 'center';
            overlay.style.justifyContent = 'center';
            overlay.style.zIndex = '1000';
            overlay.style.cursor = 'pointer';

            const fullscreenImage = document.createElement('img');
            fullscreenImage.src = imgElement.src;
            fullscreenImage.style.maxWidth = '90%';
            fullscreenImage.style.maxHeight = '90%';
            fullscreenImage.style.border = '2px solid white';

            overlay.appendChild(fullscreenImage);
            overlay.onclick = function () {
                document.body.removeChild(overlay);
            };

            document.body.appendChild(overlay);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
