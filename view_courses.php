<?php
// Database connection
$conn = new mysqli('localhost', 'root', 'root', 'student_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the search query if submitted
$search = isset($_POST['search']) ? $conn->real_escape_string($_POST['search']) : '';

// Fetch courses
$sql = "SELECT * FROM courses";
if (!empty($search)) {
    $sql .= " WHERE course_name LIKE '%$search%'";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
        <!-- Navigation Bar -->
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

    <h1 class="text-center mb-4">View Courses</h1>

    <!-- Search Form -->
    <form method="POST" action="view_courses.php" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" 
                   placeholder="Search by Course, Name, ID..." 
                   value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="btn btn-secondary">Search</button>
        </div>
    </form>

    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Course ID</th>
                    <th>Course Name</th>
                    <th>Duration</th>
                    <th>Fee</th>
                    <th>Subjects</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['course_name']) ?></td>
                        <td><?= htmlspecialchars($row['course_duration']) ?></td>
                        <td><?= htmlspecialchars($row['course_fee']) ?></td>
                        <td>
                            <?php
                            $course_id = $row['id'];
                            $subject_sql = "SELECT subject_name FROM course_subjects WHERE course_id = $course_id";
                            $subject_result = $conn->query($subject_sql);

                            if ($subject_result->num_rows > 0) {
                                echo "<ul>";
                                while ($subject_row = $subject_result->fetch_assoc()) {
                                    echo "<li>" . htmlspecialchars($subject_row['subject_name']) . "</li>";
                                }
                                echo "</ul>";
                            } else {
                                echo "<span class='text-muted'>No subjects listed.</span>";
                            }
                            ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning">No courses found.</div>
    <?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
